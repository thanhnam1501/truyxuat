<?php

namespace App\Helpers;
use DB;
use Log;
use Carbon\Carbon;
use Auth;
use App\Models\ApplyLog;
use App\Models\MissionScienceTechnologyAttribute;
use App\Models\MissionScienceTechnology;
use App\Models\UserHandleFile;
use App\Models\Email;
use App\Models\Profile;
use App\Models\EvaluationForm;
use App\Models\CouncilUser;
use Crypt;



class AdminMission {


	/**
	 * Thu bản cứng hồ sơ
	 *
	 * @param array [
	 *        	'id'	=>	id bản ghi muốn thu bản cứng,
	 *        	'table_name'	=> tên bảng muốn thu bản cứng (mission_topics)
	 *        ]
	 * @return array
	 * @author
	 **/
	public static function submitHardCopy($data)
	{
		if (!empty($data['id']) && !empty($data['table_name'])) {

			$topic = DB::table($data['table_name'])->where('id',$data['id']);
			$old_data = $topic->get()[0];
			$id_profile = $old_data->profile_id;

			if ($topic->exists()) {
				
				DB::beginTransaction();
				try {

					$topic->update([
						'time_submit_hard_copy'	=> Carbon::now(),
						'is_submit_hard_copy'	=> 1,
					]);

					//* Mã hồ sơ
					$order = DB::table($data['table_name'])->select('order_submit_hard_copy')->orderBy('order_submit_hard_copy', 'desc')->limit(1)->first();
					$order = intval($order->order_submit_hard_copy) + 1 ;
			    	$numb = str_pad($order, 4, '0', STR_PAD_LEFT);
					$year = date('Y', strtotime(now()));

					$code = $year.".".$data['form'].".".$numb;

					$topic->update([
						'code'	=>	$code,
						'order_submit_hard_copy'	=>	$order
					]);
					//* End

					$new_data = $topic->get()[0];

					//* Create logs *//
			        $arr = [
			          'admin_id' => Auth::guard('web')->user()->id,
			          'content'    => 'Xác nhận thu hồ sơ bản cứng',
			          'old_data'   => json_encode($old_data),
			          'new_data'   => json_encode($new_data),
			          'table_name' => 'mission_science_technologies',
			          'record_id'  => $data['id']
			        ];
			        ApplyLog::createLog($arr);
					//* End

			      	// send email to user
			      	// $id = $topic->profile_id;
			      	$profile = Profile::find($id_profile);
			      	$to = $profile->email;
			      	$subject = "Thông báo thu hồ sơ bản cứng";
			      	$view = "emails.status_file";
			      	$parameter = [
			      		'name'	=>	!empty($profile->representative) ? $profile->representative : "bạn",
			      		'content'	=>	'Chúng tôi thông báo rằng hồ sơ bản cứng nhiệm vụ: '.$data['mission_name'].' đã được thu.'
			      	];
			      	$type = 2;
			      	$status = 2;
			      	$numb = 0;
			      	Email::createEmailLog($to, $subject, $view, $parameter, $type, $status, $numb);
			      	// end
					DB::commit();

			    return $result = [
			        'error' => false,
			        'message' => 'Hồ sơ đã được thu bản cứng'
			    ];

				} catch (Exception $e) {

				    DB::rollback();

				    Log::info($e->getMessage());

				    return $result = [
				        'error' => true,
				        'message' => $e->getMessage()
				    ];
				}
			} else {

				return $result = [
					'error' => true,
					'message' => 'Không tìm thấy bản ghi, vui lòng liên hệ phòng IT và thử lại sau!',
				];
			}
		} else {

			return $result = [
				'error' => true,
				'message' => 'Có lỗi không xác định xảy ra, vui lòng liên hệ phòng IT và thử lại sau!'
			];
		}
	}

	public static function submitValid($data){
		
		if (!empty($data['id']) && !empty($data['table_name'])) {
			$topic = DB::table($data['table_name'])->where('id',$data['id']);
			$old_data = $topic->get()[0];
			$id_profile = $old_data->profile_id;

			if ($topic->exists()) {
			//
				DB::beginTransaction();
				try {
						if ($data['status'] == 'valid') { // valid
							$topic->update([
								'is_valid'	=> 1
							]);

							$action = "Xác nhận hồ sơ hợp lệ";
							$msg = "Hồ sơ đã được xác nhận là hợp lệ";
							$content_email = 'Chúng tôi thông báo rằng, hồ sơ nhiệm vụ: "'.$data['mission_name'].'" được xác nhận là hợp lệ.';
						} else if ($data['status'] == 'invalid') { // invalid
							$topic->update([
								'is_invalid'	=> 1,
								'is_invalid_reason'	=>	$data['reason']
							]);

							$action = "Xác nhận hồ sơ không hợp lệ";
							$msg = "Hồ sơ đã được xác nhận là không hợp lệ";
							$content_email = 'Chúng tôi thông báo rằng, hồ sơ nhiệm vụ: "'.$data['mission_name'].'" được xác nhận là không hợp lệ với lý do: "'.$data['reason'].'".';
						}

						$new_data = $topic->get()[0];

						//* Create logs *//
					      $arr = [
					          'admin_id' 	 => Auth::guard('web')->user()->id,
					          'content'    => $action,
					          'old_data'   => json_encode($old_data),
					          'new_data'   => json_encode($new_data),
					          'table_name' => $data['table_name'],
					          'record_id'  => $data['id']
					        ];
					      ApplyLog::createLog($arr);
						//* End

						//* Send email
						if ($data['checkbox'] == 'true') {
							$profile = Profile::find($id_profile);
					      	$to = $profile->email;
					      	$subject = "Kết quả kiểm tra tính hợp lệ của hồ sơ";
					      	$view = "emails.status_file";
					      	$parameter = [
					      		'name'	=>	!empty($profile->representative) ? $profile->representative : "bạn",
					      		'content'	=>	$content_email 
					      	];
					      	$type = 2;
					      	$status = 2;
					      	$numb = 0;
					      	Email::createEmailLog($to, $subject, $view, $parameter, $type, $status, $numb);
						}
						//* End
						//
						
						UserHandleFile::where('mission_table', $data['table_name'])
							->where('mission_id', $data['id'])
							->where('user_id', Auth::guard('web')->user()->id)
							->update([
								'is_handle' => 1
							]);

						DB::commit();

				    return $result = [
				        'error' => false,
				        'message' => $msg
				    ];
			//
				} catch (Exception $e) {
			//
				    DB::rollback();

				    Log::info($e->getMessage());

				    return $result = [
				        'error' => true,
				        'message' => $e->getMessage()
				    ];
				}
			} else {
			//
				return $result = [
					'error' => true,
					'message' => 'Không tìm thấy bản ghi, vui lòng liên hệ phòng IT và thử lại sau!',
				];
			}
		} else {

			return $result = [
				'error' => true,
				'message' => 'Có lỗi không xác định xảy ra, vui lòng liên hệ phòng IT và thử lại sau!'
			];
		}
	}

	public static function approveMission($data)
	{
		if (!empty($data['id']) && !empty($data['table_name'])) {
			$topic = DB::table($data['table_name'])->where('id',$data['id']);
			$old_data = $topic->get()[0];

			$id_profile = $old_data->profile_id;

			if ($topic->exists()) {

				DB::beginTransaction();
				try {
						if ($data['is_performed']) { // valid

							if (empty($topic->first()->list_categories)) {
								return $result = [
										'error' => true,
										'message' => 'Vui lòng đính kèm quyết định danh mục nhiệm vụ được thực hiện'
								];
							}

							$topic->update([
								'is_performed'	=> 1,
								'is_unperformed'	=> 0,
								'approve_type'	=> $data['approve_type'],
							]);

							$action = "Xác nhận được phê duyệt thực hiện";
							$msg = "Hồ sơ đã được phê duyệt thực hiện";
							$content_email = 'Chúng tôi thông báo rằng, hồ sơ nhiệm vụ: "'.$data['mission_name'].'" được xác nhận phê duyệt.';
						} else if ($data['is_performed'] == 0) { // invalid
							$topic->update([
								'is_unperformed'	=> 1,
								'is_performed'	=> 0,
								'is_unperformed_reason'	=>	$data['is_unperformed_reason']
							]);

							$action = "Xác nhận không hồ sơ được phê duyệt thực hiện";
							$msg = "Hồ sơ không được phê duyệt thực hiện";
							$content_email = 'Chúng tôi thông báo rằng, hồ sơ nhiệm vụ: "'.$data['mission_name'].'" không được xác nhận phê duyệt với lý do: "'.$data['is_unperformed_reason'].'".';

						}

						$new_data = $topic->get()[0];

						//* Create logs *//
			      $arr = [
			          'admin_id' 	 => Auth::guard('web')->user()->id,
			          'content'    => $action,
			          'old_data'   => json_encode($old_data),
			          'new_data'   => json_encode($new_data),
			          'table_name' => $data['table_name'],
			          'record_id'  => $data['id']
			        ];
			      ApplyLog::createLog($arr);
						//* End
					
					//* Send email
						if (isset($data['is_send_email']) && $data['is_send_email'] == 'is_send_email') {
							$profile = Profile::find($id_profile);
					      	$to = $profile->email;
					      	$subject = "Kết quả phê duyệt thực hiện";
					      	$view = "emails.status_file";
					      	$parameter = [
					      		'name'	=>	!empty($profile->representative) ? $profile->representative : "bạn",
					      		'content'	=>	$content_email 
					      	];
					      	$type = 2;
					      	$status = 2;
					      	$numb = 0;
					      	Email::createEmailLog($to, $subject, $view, $parameter, $type, $status, $numb);
						}
						//* End
						//
					DB::commit();

			    return $result = [
			        'error' => false,
			        'message' => $msg
			    ];
			//
				} catch (Exception $e) {
			//
				    DB::rollback();

				    Log::info($e->getMessage());

				    return $result = [
				        'error' => true,
				        'message' => $e->getMessage()
				    ];
				}
			} else {
			//
				return $result = [
					'error' => true,
					'message' => 'Không tìm thấy bản ghi, vui lòng liên hệ phòng IT và thử lại sau!',
				];
			}
		} else {

			return $result = [
				'error' => true,
				'message' => 'Có lỗi không xác định xảy ra, vui lòng liên hệ phòng IT và thử lại sau!'
			];
		}
	}

	public static function submitJudged($data){

		if (!empty($data['id']) && !empty($data['table_name'])) {
			$topic = DB::table($data['table_name'])->where('id',$data['id']);
			$old_data = $topic->get()[0];
			$id_profile = $old_data->profile_id;

			if ($topic->exists()) {
			//
				DB::beginTransaction();
				try {
						if ($data['status'] == 'judged') { // judged
							$topic->update([
								'is_judged'	=> 1
							]);

							$action = "Xác nhận hồ sơ được đánh giá trong hội đồng";
							$msg = "Hồ sơ đã được xác nhận đánh giá trong hội đồng";
							$content_email = 'Chúng tôi thông báo rằng, hồ sơ nhiệm vụ: "'.$data['mission_name'].'" được đưa vào đánh giá trong hội đồng.';
						} else if ($data['status'] == 'denied') { // invalid
							$topic->update([
								'is_denied'	=> 1,
								'is_denied_reason'	=>	$data['reason']
							]);

							$action = "Từ chối đánh giá hồ sơ trong hội đồng";
							$msg = "Hồ sơ đã được xác nhận từ chối đánh giá trong hội đồng";
							$content_email = 'Chúng tôi thông báo rằng, hồ sơ nhiệm vụ: "'.$data['mission_name'].'" bị từ chối đánh giá trong hội đồng với lý do: "'.$data['reason'].'".';
						}

						$new_data = $topic->get()[0];

						//* Create logs *//
			      		$arr = [
				          'admin_id' 	 => Auth::guard('web')->user()->id,
				          'content'    => $action,
				          'old_data'   => json_encode($old_data),
				          'new_data'   => json_encode($new_data),
				          'table_name' => $data['table_name'],
				          'record_id'  => $data['id']
				        ];
			      		ApplyLog::createLog($arr);
						//* End

						//* Send email
						if ($data['checkbox'] == 'true') {
							$profile = Profile::find($id_profile);
					      	$to = $profile->email;
					      	$subject = "Kết quả đánh giá hồ sơ đưa vào xét duyệt trong hội đồng";
					      	$view = "emails.status_file";
					      	$parameter = [
					      		'name'	=>	!empty($profile->representative) ? $profile->representative : "bạn",
					      		'content'	=>	$content_email 
					      	];
					      	$type = 2;
					      	$status = 2;
					      	$numb = 0;
					      	Email::createEmailLog($to, $subject, $view, $parameter, $type, $status, $numb);
						}
						//* End
						DB::commit();

				    return $result = [
				        'error' => false,
				        'message' => $msg
				    ];
			//
				} catch (Exception $e) {
			//
				    DB::rollback();

				    Log::info($e->getMessage());

				    return $result = [
				        'error' => true,
				        'message' => $e->getMessage()
				    ];
				}
			} else {
			//
				return $result = [
					'error' => true,
					'message' => 'Không tìm thấy bản ghi, vui lòng liên hệ phòng IT và thử lại sau!',
				];
			}
		} else {

			return $result = [
				'error' => true,
				'message' => 'Có lỗi không xác định xảy ra, vui lòng liên hệ phòng IT và thử lại sau!'
			];
		}
	}


	public static function viewDetail($arr){
		if (!empty($arr['id']) && !empty($arr['model'])) {
			$stechs = $arr['model']::find($arr['id'])->values;

			$columns = MissionScienceTechnologyAttribute::all();

			$data = array();

			foreach ($stechs as $key => $value) {
				foreach ($columns as $key => $column) {
					if ($value->mission_science_technology_attribute_id == $column->id && !empty($value->value)) {
						$data[$column->column] = $value->value;
					}
				}

			}

			$data['expected_fund'] = !empty($data['expected_fund']) ? number_format(Crypt::decrypt($data['expected_fund'])). " VNĐ" : 0;
		}
		return $data;
	}


	public static function addCouncil($data) {

		if ($data['council_id'] == null || $data['mission_id'] == null) {
          return $result = [
            'error' =>  true,
            'message' =>  'Vui lòng chọn đầy đủ thông tin',
          ]; 
      }
      else {
        try {
          DB::beginTransaction();

          $mission_council = $data['mission_council']::where('mission_id', $data['mission_id'])->where('group_council_id', $data['group_council_id'])->get();

          if ($mission_council->count() >= 1) {

          	$mission_council = $mission_council->first();

          	$mission_council->council_id = $data['council_id'];

          	$mission_council->group_council_id = $data['group_council_id'];

          	$mission_council->save();

          	DB::commit();

          	return $result = [
              'error' =>  false,
              'message' =>  'Cập nhật thành công',
          ];

          }
          else {
          		$data['mission_council']::create([
		            'council_id' => $data['council_id'], 
		            'mission_id' => $data['mission_id'], 
		            'group_council_id' => $data['group_council_id'], 
		            'type'	=>	0
		        ]);

          		DB::commit();

          		return $result = [
	              'error' =>  false,
	              'message' =>  'Thêm hội đồng thành công',
	          ];
          }

        }

         catch(Exception $e) {
            DB::rollback();

          return $result = [
            'error' =>  true,
            'message'   =>  $e->getMessage()
          ];
         }
      }
    }

	public static function submitAssign($data) {
		DB::beginTransaction();

      	try {
	        UserHandleFile::create([
	          'admin_id'  =>  $data['admin_id'],
	          'user_id'   =>  $data['user_id'],
	          'mission_id'  =>  $data['mission_id'],
	          'mission_table' =>  $data['mission_table'],
	          'deadline'  =>  $data['deadline'],
	          'note'  =>  $data['note']
	        ]);

	        $mission = $data['model']::find($data['mission_id']);
	        $old_data = $mission;

	        $mission->update([
	          'is_assign' =>  1
	        ]);

	        $new_data = $mission;

	        $arr = [
	           'content'  =>  'Giao hồ sơ cho chuyên viên kiểm tra hợp lệ',
	           'admin_id' => $data['admin_id'],
	           'old_data' =>  json_encode($old_data),
	           'new_data' =>  json_encode($new_data),
	           'table_name' =>  'mission_science_technologies',
	           'record_id'  =>  $data['mission_id']
	         ];
	      
	        ApplyLog::createLog($arr);

	        DB::commit();

	        return response()->json([
	          'error' =>  false,
	          'msg'   =>  'Giao thành công !'
	        ]);
      	} catch (Exception $e) {
	        DB::rollback();

	        return response()->json([
	          'error' =>  true,
	          'msg'   =>  $e->getMessage()
	        ]);
      	}

	}


	public static function evaluationDoc($data) {

		$evaluation_form = EvaluationForm::where('user_id', $data['user_id'])
										->where('mission_id', $data['mission_id'])
										->where('table_name', $data['table_name'])->orderBy('id', 'Desc')->get();


		DB::beginTransaction();
	      try {

	      	if ($evaluation_form->count() >= 1) {
	      		$evaluation_form = $evaluation_form->first();
	      		$evaluation_form->content = $data['content'];
	      		$evaluation_form->save();
	      		DB::commit();

	      		return $result = [
	      			'status'	=>	1,
		          'error' =>  false,
		          'message' =>  'Cập nhật phiếu đánh giá thành công',
		        ];
	      	}
	      	else {
	      		$evaluation_form = EvaluationForm::create(['user_id'  => $data['user_id'], 'mission_id' => $data['mission_id'], 'table_name'  =>  $data['table_name']]);

		        $evaluation_form->content = $data['content'];
		        $evaluation_form->save();


		        DB::commit();

		        return $result = [
		        	'status'	=>	2,
		          'error' =>  false,
		          'message' =>  'Đánh giá thành công',
		        ];
	      	}
	        
	      }
	      catch(Exception $e) {
	        // Log::info('Can not update hard Copy submit: Council = ' .$result->id );
	        DB::rollack();
	        return $result = [
	          'error' => true,
	          'message' => 'Internal Server Error:'. $e->getMessage() . 'OK'
	        ];
	    }
	}


	public static function giveBackHardCopy($data){

		DB::beginTransaction();

      	try {

	        $mission = $data['model']::find($data['id']);
	        $old_data = $mission;

	        $mission->update([
	          'is_submit_hard_copy' =>  0,
	          'time_submit_hard_copy'	=>	null,
	          'code'					=>	null,
	          'order_submit_hard_copy'	=>	0
	        ]);

	        $new_data = $mission;

	        $arr = [
	           'content'  =>  'Trả lại bản cứng',
	           'admin_id' =>  Auth::guard('web')->user()->id,
	           'old_data' =>  json_encode($old_data),
	           'new_data' =>  json_encode($new_data),
	           'table_name' =>  $data['mission_table'],
	           'record_id'  =>  $data['id']
	         ];
	      
	        ApplyLog::createLog($arr);

	        DB::commit();

	        return response()->json([
	          'error' =>  false,
	          'msg'   =>  'Trả bản cứng thành công !'
	        ]);
      	} catch (Exception $e) {
	        DB::rollback();

	        return response()->json([
	          'error' =>  true,
	          'msg'   =>  $e->getMessage()
	        ]);
      	}
	}


	public static function checkEvaluationDone($data) {
		$flag = false;
		$council_mission = $data['mission']::where('type', 0)->where('mission_id', $data['mission_id'])->first();

		$evaluation_form = EvaluationForm::where('table_name', $data['table_name'])->where('mission_id', $data['mission_id'])->count();
		if ($council_mission != null) {
			$council_id = $council_mission->council_id;
			$council_users = CouncilUser::where('council_id', $council_id)->count();
			if ($evaluation_form == $council_users) {
				$flag = true;
			}


		}

		return $flag;
	}
}
