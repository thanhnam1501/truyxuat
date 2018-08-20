<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoundCollectionRequest;
use App\Models\RoundCollection;
use DB;
use Datatables;

class RoundCollectionController extends Controller
{
    public function __construct() {
      // $this->middleware('auth');
      // $this->middleware('permission:round-collection-view')->only('index','show','list');
      // $this->middleware('permission:round-collection-create')->only('store');
      // $this->middleware('permission:round-collection-edit')->only('show','update');
      // $this->middleware('permission:round-collection-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.round_collection.index');
    }

    public function list()
    {
      $roundCollection = RoundCollection::orderBy('id','desc');

      return Datatables::of($roundCollection)
              ->addIndexColumn()
              ->editColumn('status', function($roundCollection) {

                if ($roundCollection->status == 0) {

                  return '<label data-tooltip="tooltip" title="Hiện" class="switch switch-small"><input type="checkbox" data-id="'.$roundCollection->id.'" class="hide-collection"/><span></span></label>';

                } else if ($roundCollection->status == 1) {

                  return '<label data-tooltip="tooltip" title="Ẩn" class="switch switch-small"><input type="checkbox" data-id="'.$roundCollection->id.'" checked class="hide-collection"/><span></span></label>';

                }
              })
              ->addColumn('action', function($roundCollection) {

                  $string = "";

                  //if (Entrust::can('account-detail')) {

                    $string .= '<a data-id='.$roundCollection->id.' data-tooltip="tooltip" title="Xem chi tiết"  class="btn btn-info btn-view btn-xs"><i class="fa fa-eye"></i></a>';
                  //}

                  //if (Entrust::can('account-edit')) {

                    $string .= '<a data-id='.$roundCollection->id.' data-tooltip="tooltip" title="Chỉnh sửa" class="btn btn-warning btn-edit btn-xs"><i class="fa fa-pencil"></i></a>';
                  //}

                  //if (Entrust::can('account-delete')) {

                    $string .= '<a data-id='.$roundCollection->id.' data-tooltip="tooltip" title="Xóa" class="btn btn-danger delete-btn btn-delete btn-xs"><i class="fa fa-trash-o"></i></a>';
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoundCollectionRequest $request)
    {
        $data=$request->all();
        // dd($data['expiration_time']);
        if($data['year']>=date("Y")){
            $collection=new RoundCollection;
            $collection->name=$data['name'];
            $collection->year=$data['year'];
            $collection->expiration_time=$data['expiration_time'];
            $collection->save();
        
            return response()->json(['data'=>$collection],200);
        }else{
            return response()->json(['err'=>true,'msg'=>"Năm này đã là quá khứ, mời nhập lại."],200);
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
        $collection=RoundCollection::find($id);
        return response()->json(['data'=>$collection],200);
    }

    /**
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
    public function update(RoundCollectionRequest $request, $id)
    {
        // dd($request);
        $data=$request->all();
        if($data['year']>=date("Y")){
        // dd($data['expiration_time']);
            $collection= RoundCollection::find($id);
            $collection->name=$data['name'];
            $collection->year=$data['year'];
            $collection->expiration_time=$data['expiration_time'];
            $collection->save();
            
            return response()->json(['data'=>$collection],200);
        }else{
            return response()->json(['err'=>true,'msg'=>"Năm này đã là quá khứ, mời nhập lại."],200);
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
        RoundCollection::where('id',$id)->delete();
        return response()->json(['data'=>'deleted'],200);
    }

    public function hide(Request $request)
    {
      $collection = RoundCollection::find($request->id);

      if (!empty($collection)) {

          DB::beginTransaction();
          try {

              $collection->update([
                'status'  => $request->status,
              ]);

              if ($request->status == 1) {

                  $msg = "Đợt thu hồ sơ $collection->name đã được hiển thị";
              } else {

                  $msg = "Đợt thu hồ sơ $collection->name đã bị ẩn";
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
            'message' =>  'Không tìm thấy đợt thu hồ sơ, vui lòng thử lại sau',
        ]);
      }
    }
}
