<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositionCouncil;
use Datatables;
use DB;

class PositionCouncilController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.position_councils.index');
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
    public function store(Request $request)
    {
        $data = $request->only('name');

        if ($data['name'] == null) {
            return response()->json([
                'error' =>  true,
                'message'   =>  'Vui lòng nhập đầy đủ thông tin',
            ]);
        }
        else {
            DB::beginTransaction();

            try {
                PositionCouncil::create(['name' => $data['name']]);

                DB::commit();

                return response()->json([
                    'error' =>  false,
                    'message'   =>  'Thêm mới thành công']);
            }

            catch (Exception $e) {

              DB::rollback();

              Log::info($e->getMessage());

              return response()->json([
                  'error' => true,
                  'message' => $e->getMessage()
              ]);
          }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position_council = PositionCouncil::find($id);
        $created_at = date_format($position_council->created_at, 'd-m-Y');

        return response()->json(
            ['data'=>$position_council,
             'created_at'   => $created_at
            ]
            ,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position_council = PositionCouncil::find($id);
        return response()->json(
            ['position_council'=>$position_council],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->only(['name', 'id']);

        if ($data['name'] == null) {
            return response()-> json([
                'error' =>  true,
                'message'   =>  'Vui lòng điền đầy đủ thông tin'
            ]);
        }
        else {
            DB::beginTransaction();
            try {
                PositionCouncil::find($data['id'])->update(['name'  =>  $data['name']]);
                DB::commit();
                return response()->json([

                    'error' =>  false,
                    'message'   =>  'Cập nhật thành công',
                ]);



            }
            catch (Exception $e) {
                DB::rollback();

                Log::info($e->getMessage());

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            PositionCouncil::find($id)->delete();
            DB::commit();
            return response()->json([
                'error' => false,
                'message'   =>  'Xoá vị trí hội đồng thành công'
            ]);
        }
        catch (Exception $e) {
            DB::rollback();

            Log::info($e->getMessage());

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getList() {

        $position_councils = PositionCouncil::orderBy('id','desc');

        return Datatables::of($position_councils)
        ->addIndexColumn()
              ->editColumn('status', function($position_council) {

                if ($position_council->status == 0) {

                  return '<label data-tooltip="tooltip" title="Hiện" class="switch switch-small"><input type="checkbox" data-id="'.$position_council->id.'" class="hide-group"/><span></span></label>';

                } else if ($position_council->status == 1) {

                  return '<label data-tooltip="tooltip" title="Ẩn" class="switch switch-small"><input type="checkbox" data-id="'.$position_council->id.'" checked class="hide-group"/><span></span></label>';

                }
              })
              ->addColumn('action', function($position_council) {

                  $string = "";

                  //if (Entrust::can('account-detail')) {

                    $string .= '<a data-id='.$position_council->id.' data-tooltip="tooltip" title="Xem chi tiết"  class="btn btn-info btn-view btn-xs"><i class="fa fa-eye"></i></a>';
                  //}

                  //if (Entrust::can('account-edit')) {

                    $string .= '<a data-id='.$position_council->id.' data-tooltip="tooltip" title="Chỉnh sửa" class="btn btn-warning btn-edit btn-xs"><i class="fa fa-pencil"></i></a>';
                  //}

                  //if (Entrust::can('account-delete')) {

                    $string .= '<a data-id='.$position_council->id.' data-tooltip="tooltip" title="Xóa" class="btn btn-danger delete-btn btn-delete btn-xs"><i class="fa fa-trash-o"></i></a>';
                  //}

                  return $string;
              })
              ->make(true);
    }

    public function hide(Request $request)
    {
      $group = PositionCouncil::find($request->id);

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
            'message' =>  'Không tìm thấy vị trí hội đồng, vui lòng thử lại sau',
        ]);
      }
    }
}
