<?php

namespace App\Helpers;

use App\Models\RoundCollection;
use App\Models\Organization;
use App\Models\MissionFile;

use Auth;
use DB;

class UploadFile {

  /**
   * format money
   *
   *
   * @param string $str: 100,000...; $symbol: vnđ, đ, usd...;
   * @return return $str in integer: 100000
   */
  public static function formatName($data)
  {
    //dot_goi_ho_so/ten_to_chuc_000005.pdf
    // $data = ['number_step','code_form', 'organization_id', 'parent_id', 'number_input'];

    // $or = Organization::find($data['organization_id']);
    $user_name = str_slug($data['representative']);
    $id = str_pad($data['parent_id'], 6, '0', STR_PAD_LEFT);
    $number_input = str_pad($data['number_input'], 2, '0', STR_PAD_LEFT);

    $file_name = "S".$data['number_step']."-".$data['code_form']."-".$user_name."-".$id."-".$number_input.".pdf";

    return $file_name;
  }

  /**
   * Convert number money to words money
   *
   *
   * @param Number $amount
   * @return return money in words type
   */
  public static function storeFile($data)
  {
    // $data ([
    //   number_step : giai đoạn
    //   code_form: ten viet tat cua form (A1, A2, A3)
    //   organization_id: id của tổ chức
    //   parent_id : id của phiếu
    //   number_input: số thứ tự của thẻ input
    //   file : file truyền vào
    //   round_collection_name : tên của đợt gọi hồ sơ])

    $arr = [
            'number_step'         =>  1,
            'organization_id'     =>  Auth::guard('profile')->user()->organization_id,
            'parent_id'           =>  $data['parent_id'], //id của mission
            'number_input'        =>  $data['number_input'],
            'code_form'           =>  $data['code_form'],
            'representative'      =>  Auth::guard('profile')->user()->representative
          ];

    if ($data['file'] != null) {

      $name = UploadFile::formatName($arr);

      $path = $data['file']->storeAs('/upload'.'/'.$data['round_collection_name'], $name);
      }

      return $path;
  }


  public static function getPath($missionAttribute, $mission_id, $column, $table) {

    // $missionAttribute = 'App\Models\MissionSxtnAttribute'
    // $column = 'evaluation_form_01'
    // $table = 'A2'
    $path  = '';

    $missionFile = MissionFile::where('mission_id' , $mission_id)
                  ->where('profile_id', Auth::guard('profile')->id())
                  ->where('table_name', $table);

    $missionFile = $missionFile->where('mission_attribute_id', $missionAttribute::where('column', $column)->first()->id)->orderBy('id', 'DESC')->first();

    if ($missionFile != null && !empty($missionFile)) {
         $path = $missionFile->path;
    }

    return $path;
  }


  public static function upFile($data) { //file, key, table (App\Models\MissionSxtn), code_form, $table_attribute(App\Models\MissionSxtnAttribute), order, table_name
      $file = $data['file'];
      // dd($file->getClientOriginalExtension());
      if ($file->getClientOriginalExtension() != 'pdf' && $file->getClientOriginalExtension() != 'PDF') {
            return response()->json(['error' =>  true, 'message'  =>  'Chỉ nhận định dang PDF']);
      }
      if ($file->getSize() > 5000000) {
            return response()->json(['error' =>  true, 'message'  =>  'Dung lượng file không quá 5 Mb']);
      }

      $uploadFile['file'] = $file;

      $mission = $data['table']::where('key', $data['key'])
            ->where('profile_id', Auth::guard('profile')->user()->id)
            ->first();


      $uploadFile['parent_id'] = $mission->id;

      $round_collection = RoundCollection::find($mission->round_collection_id);

      $round_collection_name = $round_collection->year .'_' . $round_collection->name;

      $uploadFile['round_collection_name']  = str_slug($round_collection_name);

      $uploadFile['number_input'] = $data['order'];

      $uploadFile['code_form']  = $data['code_form'];

      $path = UploadFile::storeFile($uploadFile);

      $mission_attribute_id = $data['table_attribute']::where('column', 'evaluation_form_' . $data['order'])->first()->id;

      $status = MissionFile::create([
          'table_name'  =>  $data['table_name'],
          'profile_id'  =>  Auth::guard('profile')->id(),
          'mission_id'  =>  $mission->id,
          'mission_attribute_id'  =>  $mission_attribute_id,
          'path'  =>  $path,
      ]);

      if (!empty($status) && $status != null) {
        return response()->json(['error' =>  false, 'message'  =>  'Tải lên thành công']);
      }
      else {
        return response()->json(['error' =>  true, 'message'  =>  'Tải lên thất bại']);
      }


  }

  /**
   * Upload quyết định danh mục nhiệm vụ được thực hiện
   *
   * @param array = [
   *           'id' => id hồ sơ nhiệm vụ
   *           'file' => file muốn upload
   *           'table_name' => tên bảng lưu hồ sơ nhiệm vụ
   *           'form' => A1 / A3
   *        ]
   * @return ârray
   * @author
   **/
  public static function uploadListCategories($data)
  {
    if (!is_file($data['file'])) {

        return [
            'error' => true,
            'message' =>  "Vui lòng đính kèm quyết định danh mục nhiệm vụ được thực hiện",
        ];
    }

    $topic = DB::table($data['table_name'])->where('id',$data['id']);

    $round_collection = DB::table($data['table_name'])->select('round_collections.name','year')
                            ->join('round_collections',$data['table_name'].".round_collection_id",'round_collections.id')
                            ->where($data['table_name'].'.id',$data['id'])
                            ->first();

    $round_collection_name = $round_collection->year."-".$round_collection->name;
    DB::beginTransaction();
    try {

        $name = $topic->first()->code."-list-categories.".$data['file']->getClientOriginalExtension();

        $path = $data['file']->storeAs('/upload'.'/'.$round_collection_name, $name);

        $topic->update([
          'list_categories' => $path,
        ]);

      DB::commit();

        return [
            'error' => false,
        ];

    } catch (Exception $e) {

        DB::rollback();

        Log::info($e->getMessage());

        return [
            'error' => true,
            'message' => $e->getMessage()
        ];
    }

  }
}

?>
