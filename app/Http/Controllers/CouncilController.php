<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Council;
use App\Models\GroupCouncil;
use App\Models\RoundCollection;
use App\Models\PositionCouncil;
use App\Models\CouncilUser;
use App\Models\User;
use Datatables;
use Response;
use DB;
use Validator;

class CouncilController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	public function index()
	{
		$round_collections = RoundCollection::where('status', 1)->get();
		$groupCouncils = GroupCouncil::where('status', 1)->get();
		$position_councils = PositionCouncil::where('status', 1)->get();
		$users = User::where('type',9)->get();
		$count_user = User::where('type', 9)->count();
		// dd($count_user);
		return view('backend.council.index',[
			'round_collections' => $round_collections,
			'groupCouncils' => $groupCouncils,
			'position_councils'	=>	$position_councils,
			'users'	=>	$users,
			'count_user'	=>	$count_user
		]);
	}

	public function list()
	{   
		$council = Council::orderBy('id','desc');

		return Datatables::of($council)
		->addColumn('action', function ($council) {

			$string = "";
			$string .= '<a data-id='.$council->id.' data-tooltip="tooltip" title="Xem thành viên" class="btn btn-success btn-view-member btn-xs"><i class="fa fa-users"></i></a>';

			$string .= '<a data-id='.$council->id.' data-tooltip="tooltip" title="Xem chi tiết"  class="btn btn-info btn-view btn-xs"><i class="fa fa-eye"></i></a>';

			$string .= '<a data-id='.$council->id.' data-tooltip="tooltip" title="Chỉnh sửa" class="btn btn-warning btn-edit btn-xs"><i class="fa fa-pencil"></i></a>';

			$string .= '<a data-id='.$council->id.' data-tooltip="tooltip" title="Xóa" class="btn btn-danger delete-btn btn-delete btn-xs"><i class="fa fa-trash-o"></i></a>';

			return $string;
		})
		->addColumn('created_at', function($doc) {

			return date('d-m-Y',strtotime($doc->created_at));
		})
		->addColumn('group_council_id', function ($council) {
			return GroupCouncil::find($council->group_council_id)->name;
		})
		->addColumn('round_collection_id', function($council) {

			$round_collection_id = RoundCollection::find($council->round_collection_id);
			if (!empty($round_collection_id->year) && !empty($round_collection_id->name)) {
				return $round_collection_id->year.' - '.$round_collection_id->name;
			}
			
			return "Chưa cập nhật";
		})
		->addColumn('status', function($council) {

			if ($council->status == 0) {
				return '<label data-tooltip="tooltip" title="Hiện" class="switch switch-small"><input type="checkbox" data-id="'.$council->id.'" class="hide-council"/><span></span></label>';
			}

			if ($council->status == 1) {
				return '<label data-tooltip="tooltip" title="Ẩn" class="switch switch-small"><input type="checkbox" data-id="'.$council->id.'" checked class="hide-council"/><span></span></label>';
			}

		})

		->addIndexColumn()
		->make(true);
	}

	public function store(Request $request)
	{
		$data =  $request->only(['name', 'round_collection_id','group_council_id']);

		if (empty($data['name']) || empty($data['round_collection_id'])|| empty($data['group_council_id']) ) {

			return Response::json([
				'error'   =>  true,
				'message' =>  'Vui lòng điền đầy đủ thông tin yêu cầu!'
			]);
		}

		DB::beginTransaction();
		try {

			$result = Council::create(['name' => $data['name'], 'round_collection_id' => $data['round_collection_id'], 'group_council_id' => $data['group_council_id']]);

			DB::commit();

			return response()->json([
				'error' => false,
				'message' => 'Tạo mới hội đồng thành công!',
			]);

		} catch(Exception $e) {
			Log::info('Can not update hard Copy submit: Council = ' .$result->id );
			DB::rollack();
			return response()->json([
				'error' => true,
				'message' => 'Internal Server Error:'. $e->getMessage() . 'OK'
			], 500);
		}
	}

	public function hide(Request $request)
	{
		$council = Council::find($request->id);

		if (!empty($council)) {

			DB::beginTransaction();
			try {

				$council->update([
					'status'  => $request->status,
				]);

				if ($request->status == 1) {

					$msg = "Hội đồng $council->name đã được hiển thị";
				} else {

					$msg = "Hội đồng $council->name đã bị ẩn";
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
				'message' =>  'Không tìm thấy hội đồng, vui lòng thử lại sau',
			]);
		}
	}

	public function show($id)
	{
		$council = Council::find($id);
		$group_council_id = GroupCouncil::find($council->group_council_id)->name;
		$roundCollections = RoundCollection::find($council->round_collection_id);
		$roundCollection = $roundCollections['year'].' - '.$roundCollections['name'];

		return response()->json([
			'data' => $council,
			'group_council_id' => $group_council_id,
			'roundCollection' => $roundCollection,
		],200);
	}

	public function update(Request $request, $id)
	{
		$data=$request->all();
		$council=Council::find($id)->update($data);

		return response()->json(['data'=>$council],200);
	}

	public function destroy($id)
	{
		Council::where('id',$id)->delete();
		return response()->json(['data'=>'deleted'],200);
	}

	public function viewMember($id)
	{
		$council = Council::find($id);
		$group_council_id = GroupCouncil::find($council->group_council_id)->name;
		$roundCollections = RoundCollection::find($council->round_collection_id);
		$roundCollection = $roundCollections['year'].' - '.$roundCollections['name'];

		// $council_users = CouncilUser::where('council_id', $council->id)->get();

		// $council_user_arr =  array();

		// if ($council_users != null && !empty($council_users)) {
			
		// 	foreach ($council_users as $council_user) {
		// 		$user = User::find($council_user->user_id);
		// 		$position_council = PositionCouncil::find($council_user->position_council_id);
		// 		$arr['user_name']	=	$user->name;
		// 		$arr['email']	=	$user->email;
		// 		$arr['position_council']	=	$position_council->name;
		// 		$arr['id']	=	$council_user->id;
				
		// 		$council_user_arr[]	=	$arr;
		// 	}
			
		// }

		return response()->json([
			'data' => $council,
			'group_council_id' => $group_council_id,
			'roundCollection' => $roundCollection,
			// 'council_user_arr'	=>	$council_user_arr,
		],200);
	}

	public function listMember($id) {
		$council = Council::find($id);
		
		// $ouncil_users = $council->getUsers;
		$council_users = User::whereIn('id', function($query) use ($id) {
			$query->select('user_id')->from('council_users')->where('council_id', $id)->get();
		})->get();

		return Datatables::of($council_users)
		->addIndexColumn()
		->addColumn('user_name', function($council_user) {
			return $council_user->name;
		})
		->addColumn('email', function($council_user) {
			return '<a href="mailto:'.$council_user->email.'">'.$council_user->email.'</a>';
			
		})
		->addColumn('phone', function($council_user) {
			if ($council_user->mobile != "") {
				return '<a href="tel:'.$council_user->mobile.'">'.$council_user->mobile.'</a>';
			}
			else {
				return 'Chưa cập nhật';
			}
		})
		->addColumn('position_council', function($council_user) use ($council) {
			$position_council_id = CouncilUser::where('council_id', $council->id)->where('user_id', $council_user->id)->first()->position_council_id;

			return PositionCouncil::find($position_council_id)->name;
			
			
		})
		->addColumn('action', function($council_user) use ($council) {
			$str = '';
			$str = $str . "<a class='btn btn-warning btn-xs update-member' data-userid='".$council_user->id."' data-councilid='".$council->id."' data-tooltip='tooltip' title='Sửa'><i class='fa fa-pencil'></i></a>";

			$str = $str . "<a class='btn btn-danger btn-xs delete-member' data-userid='".$council_user->id."' data-councilid='".$council->id."' data-tooltip='tooltip' title='Xoá'><i class='fa fa-trash-o'></i></a>";
                                                       
			return $str;
		})
		->make(true);
	}

	public function countPositionCouncil($position_id, $council_id) {
		return CouncilUser::where('position_council_id', $position_id)->where('council_id', $council_id)->count();
	}

	public function addMember(Request $request) {

		$data = $request->only(['user_id', 'position_council_id', 'council_id']);

		$council_users = CouncilUser::where('user_id', $data['user_id'])->where('council_id', $data['council_id'])->get();

		$count_num = CouncilUser::where('council_id', $data['council_id'])->count();

		if ($count_num == env('MAX_MEMBER')) {
			
			return response()->json([
				'error'	=>	true,
				'message'	=>	'Hội đồng không quá '.env('MAX_MEMBER').' thành viên',
			]);
		}

		if ($council_users->count() > 0) {
			return response()->json([
				'error'	=>	true,
				'message'	=>	'Thành viên đã có trong hội đồng',
			]);
		}

		if ($this->countPositionCouncil($data['position_council_id'], $data['council_id']) && $data['position_council_id'] == 1) {
			return response()->json([
				'error'	=>	true,
				'message'	=>	'Vị trí chủ tịch hội đồng đã đủ',
			]);
		}

		if ($this->countPositionCouncil($data['position_council_id'], $data['council_id']) && $data['position_council_id'] == 2) {
			return response()->json([
				'error'	=>	true,
				'message'	=>	'Vị trí phó chủ tịch hội đồng đã đủ',
			]);
		}

		if ($this->countPositionCouncil($data['position_council_id'], $data['council_id']) == 2 && $data['position_council_id'] == 3) {
			return response()->json([
				'error'	=>	true,
				'message'	=>	'Vị trí uỷ viên phản biện đã đủ',
			]);
		}

		DB::beginTransaction();

		try {
			CouncilUser::create(['user_id'	=>	$data['user_id'], 'position_council_id' => $data['position_council_id'], 'council_id'	=>	$data['council_id']]);

			DB::commit();

			return response()->json([
				'error'	=>	false,
				'message'	=>	'Thêm thành viên thành công',
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

	public function deleteMember(Request $request) {
		$data = $request->only(['user_id', 'council_id']);

		DB::beginTransaction();

		try {
			CouncilUser::where('user_id', $data['user_id'])->where('council_id', $data['council_id'])->first()->delete();
			DB::commit();
			return response()->json([
				'error'	=>	false,
				'message'	=>	'Xoá thành viên thành công'
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

	public function editMember(Request $request) {
		$data = $request->only(['user_id', 'council_id']);

		$CouncilUser = CouncilUser::where('user_id', $data['user_id'])->where('council_id', $data['council_id'])->first();

		$position_council_id = $CouncilUser->position_council_id;

		$user = User::find($data['user_id']);

		return response()->json([
			'position_council_id'	=>	$position_council_id,
			'user'	=>	$user
		]);
	}

	public function updateMember(Request $request) {
		$data = $request->only(['e_council_id', 'e_user_id', 'e_position_council_id']);

		DB::beginTransaction();

		try {
			$council =CouncilUser::where('council_id', $data['e_council_id'])->where('user_id', $data['e_user_id'])->first();
			$council->update(['position_council_id' => $data['e_position_council_id']]);

			DB::commit();

			return response()->json([
				'error'	=>	false,
				'message'	=>	'Cập nhật thành viên thành công',
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
