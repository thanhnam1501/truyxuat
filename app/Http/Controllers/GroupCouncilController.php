<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupCouncilRequest;
use App\Models\GroupCouncil;
use App\Models\OptionValue;
use App\Models\Option;
use DB;
use Datatables;

class GroupCouncilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
      $this->middleware('auth');
    }
  
    public function index()
    {
        $option = Option::where('code', 'GROUP-COUNCIL-FUNC')->first();

        if ($option != null) {
          $option_id = $option->id;
          $optionValues = OptionValue::where('option_id', $option_id)->get();
        }
        return view('backend.group_council.index', compact('optionValues'));
    }

    public function list()
    {
      $groupCouncil = GroupCouncil::orderBy('id','desc');

      return Datatables::of($groupCouncil)
              ->addIndexColumn()
              ->editColumn('status', function($groupCouncil) {

                if ($groupCouncil->status == 0) {

                  return '<label data-tooltip="tooltip" title="Hiện" class="switch switch-small"><input type="checkbox" data-id="'.$groupCouncil->id.'" class="hide-group"/><span></span></label>';

                } else if ($groupCouncil->status == 1) {

                  return '<label data-tooltip="tooltip" title="Ẩn" class="switch switch-small"><input type="checkbox" data-id="'.$groupCouncil->id.'" checked class="hide-group"/><span></span></label>';

                }
              })
              ->addColumn('action', function($groupCouncil) {

                  $string = "";

                  //if (Entrust::can('account-detail')) {

                    $string .= '<a data-id='.$groupCouncil->id.' data-tooltip="tooltip" title="Xem chi tiết"  class="btn btn-info btn-view btn-xs"><i class="fa fa-eye"></i></a>';
                  //}

                  //if (Entrust::can('account-edit')) {

                    $string .= '<a data-id='.$groupCouncil->id.' data-tooltip="tooltip" title="Chỉnh sửa" class="btn btn-warning btn-edit btn-xs"><i class="fa fa-pencil"></i></a>';
                  //}

                  //if (Entrust::can('account-delete')) {

                    $string .= '<a data-id='.$groupCouncil->id.' data-tooltip="tooltip" title="Xóa" class="btn btn-danger delete-btn btn-delete btn-xs"><i class="fa fa-trash-o"></i></a>';
                  //}

                  return $string;
              })
              ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupCouncilRequest $request)
    {
        $data=$request->all();

        $group=GroupCouncil::create($data);
        
        return response()->json(['data'=>$group],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group=GroupCouncil::find($id);

        $option = Option::where('code', 'GROUP-COUNCIL-FUNC')->first();

        $optionValueName = '';
        if ($option != null) {
          $option_id = $option->id;
          $optionValue = OptionValue::where('option_id', $option_id)->where('value', $group->type)->first();
          $optionValueName = $optionValue->name;
        }
        return response()->json(['data'=>$group, 'optionValueName'=>$optionValueName],200);
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupCouncilRequest $request, $id)
    {
        $data=$request->all();
        $group=GroupCouncil::find($id)->update($data);
    
        return response()->json(['data'=>$group],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GroupCouncil::where('id',$id)->delete();
        return response()->json(['data'=>'deleted'],200);
    }

    public function hide(Request $request)
    {
      $group = GroupCouncil::find($request->id);

      if (!empty($group)) {

          DB::beginTransaction();
          try {

              $group->update([
                'status'  => $request->status,
              ]);

              if ($request->status == 1) {

                  $msg = "Nhóm hội đồng $group->name đã được hiển thị";
              } else {

                  $msg = "Nhóm hội đồng $group->name đã bị ẩn";
              }

              DB::commit();

              return response()->json([
                  'error' => false,
                  'message' => $msg,
              ]);

          } catch (Exception $e) {

              DB::rollback();

              Log::info($e->getMessage());

              return response()->json([
                  'error' => true,
                  'message' => $e->getMessage()
              ]);
          }
      } else {
        return response()->json([
            'error'     =>  true,
            'message' =>  'Không tìm thấy nhóm hội đồng, vui lòng thử lại sau',
        ]);
      }
    }
}
