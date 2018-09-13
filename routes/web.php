<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'admin'], function() {
        Route::get('mission-science-technologys/export-excel', 'AdminMissionScienceTechnologyController@exportExcelGetData')->name('admin.mission-science-technologys.exportExcel');

    Route::get('mission-topics/export-excel', 'AdminMissionTopicController@exportExcelGetData')->name('admin.mission-topics.exportExcel');
    });
});
Route::middleware('revalidate')->group(function () {

    //* Admin
    Route::prefix('admin')->group(function () {
        Route::middleware('auth')->group(function () {
            //* Thay đổi ảnh đại diện
            Route::post('change-avatar', 'UserController@postUpload')->name('users.change-avatar');
            //* End

            //* Quản lý vai trò
            Route::resource('roles', 'RoleController');
            Route::get('/get-list-role', 'RoleController@getListRole');
            Route::post('roles/permissions', 'RoleController@postPermissions')->name('user.update-role-permissions');
            Route::get('roles/{name}/list-permissions', 'RoleController@getPermissions')->name('user.role-permissions');
            Route::get('roles/list-permissions/{name}', 'RoleController@getListPermission')->name('user.role-list-permissions');
            //* End

            //* Quản lý tài khoản admin
            Route::resource('account-users', 'UserController');
            Route::post('account-users/get-list', 'UserController@list')->name('users.getList');
            Route::post('account-users/lock', 'UserController@lockAccount')->name('users.lockAccount');
            Route::post('account-users/roles', 'UserController@postRoles')->name('user.update-roles');
            Route::get('account-users/check-email/{email}', 'UserController@checkEmail')->name('users.checkEmail');
            Route::get('account-users/{id}/roles', 'UserController@getRoles')->name('user.roles');
            Route::post('account-user/get-list', 'UserController@list')->name('users.getList');
            //* End

            //* Quản lý tài khoản cá nhân
            Route::resource('account-profiles', 'AdminProfileController');
            Route::post('account-profiles/get-list', 'AdminProfileController@list')->name('profiles.getList');
            Route::post('account-profiles/lock', 'AdminProfileController@lockAccount')->name('profiles.lockAccount');
            Route::get('account-profiles/check-email/{email}', 'AdminProfileController@checkEmail')->name('profiles.checkEmail');
            Route::post('account-profiles/send-email', 'AdminProfileController@sendEmail')->name('profiles.sendEmail');
            //* End

            //* Quản lý đợt thu hồ sơ
            Route::resource('round-collections', 'RoundCollectionController');
            Route::post('round-collections/get-list','RoundCollectionController@list')->name('round-collection.getList');
            Route::post('round-collections/lock','RoundCollectionController@hide')->name('round-collection.hide');
            //* End

            //* Quản lý nhóm hội đồng
            Route::resource('group-councils', 'GroupCouncilController');
            Route::post('group-councils/get-list','GroupCouncilController@list')->name('group-councils.getList');
            Route::post('group-councils/lock','GroupCouncilController@hide')->name('group-councils.hide');
            //* End

            Auth::routes();
            Route::get('/', 'UserController@home');

            //* Quản lý quyền hạn
            Route::group(['prefix' => 'permissions'], function () {
               Route::post('get-list', 'Permission\PermissionController@getList')->name('permissions.getList');
               Route::get('/', 'Permission\PermissionController@index')->name('permissions.index');

            });

            Route::post('roles/permissions', 'RoleController@postPermissions')->name('user.update-role-permissions');
            Route::get('roles/{name}/list-permissions', 'RoleController@getPermissions')->name('user.role-permissions');

            Route::get('roles/list-permissions/{name}', 'RoleController@getListPermission')->name('user.role-list-permissions');


        //     Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.log');
        // });

    	    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.log');

            //Quản lý dự án SXTN
            Route::resource('mission-sxtns', 'AdminMissionSxtnController');
            Route::post('mission-sxtns/get-list','AdminMissionSxtnController@list')->name('mission-sxtns.getList');
            Route::get('mission-sxtns/detail/{key}', 'AdminMissionSxtnController@detail')->name('admin-mission-sxtns.detail');

            Route::post('mission-sxtns/destroy', 'AdminMissionSxtnController@delete')->name('admin-mission-sxtns.delete');

            Route::get('/mission-sxtns/edit/{key}', 'AdminMissionSxtnController@edit')->name('admin-mission-sxtns.edit');

            Route::post('/mission-sxtns/edit', 'AdminMissionSxtnController@update')->name('admin-mission-sxtns.update');

            //Quản lý dự án khoa học công nghệ
            
            Route::resource('mission-science-technologys', 'AdminMissionScienceTechnologyController');
            Route::post('mission-science-technologys/get-list','AdminMissionScienceTechnologyController@list')->name('mission-science-technologys.getList');

            Route::get('mission-science-technologys/detail/{key}', 'AdminMissionScienceTechnologyController@show')->name('admin.mission-science-technologys.detail');

            Route::get('mission-science-technologys/get-round-collection/{id}','AdminMissionScienceTechnologyController@getRoundCollection')->name('mission-science-technologys.getRoundCollection');

            Route::post('mission-science-technologys/get-list-council','AdminMissionScienceTechnologyController@getListCouncil')->name('mission-science-technologys.getListCouncil');


            Route::post('mission-science-technologys/add-council','AdminMissionScienceTechnologyController@addCouncil')->name('mission-science-technologys.addCouncil');

            Route::get('mission-science-technologys/evaluation/{key}','AdminMissionScienceTechnologyController@evaluation')->name('mission-science-technologys.evaluation');

            Route::get('mission-science-technologys/evaluation-detail/{key}','AdminMissionScienceTechnologyController@evaluationDetail')->name('mission-science-technologys.evaluation-detail');

            Route::get('mission-science-technologys/evaluation-print/{key}','AdminMissionScienceTechnologyController@evaluationPrint')->name('mission-science-technologys.evaluation-print');

            Route::post('mission-science-technologys/evaluation/store','AdminMissionScienceTechnologyController@storeEvaluation')->name('mission-science-technologys.storeEvaluation');
            
            Route::get('position-councils/get-list', 'PositionCouncilController@getList')->name('position-councils.get-list');

            Route::resource('position-councils', 'PositionCouncilController');

            Route::prefix('position-councils')->group(function() {
                Route::post('store', 'PositionCouncilController@store')->name('position-councils.store');

                Route::post('lock', 'PositionCouncilController@hide')->name('position-councils.hide');

                Route::post('update', 'PositionCouncilController@update')->name('position-councils.update');
            });

            //Đề tài hoặc đề án
            Route::group(['prefix' => 'mission-topics'], function() {
                Route::post('/get-list-submit-ele-copy', 'AdminMissionTopicController@getSubmitEleList')->name('admin.mission-topics.getSubmitEleList');

                Route::post('/submit-hard-copy', 'AdminMissionTopicController@submitHardCopy')->name('admin.mission-topics.submitHardCopy');

                Route::post('/approve-mission', 'AdminMissionTopicController@approveMission')->name('admin.mission-topics.approveMission');

                Route::post('/upload-list-categories', 'AdminMissionTopicController@uploadListCategories')->name('admin.mission-topics.uploadListCategories');

                Route::post('/submit-valid', 'AdminMissionTopicController@submitValid')->name('admin.mission-topics.submitValid');

                Route::post('/submit-judged', 'AdminMissionTopicController@submitJudged')->name('admin.mission-topics.submitJudged');

                Route::post('/judge', 'AdminMissionTopicController@judgeCouncilStore');

                Route::get('/judge/{key}', 'AdminMissionTopicController@judgeCouncilView')->name('admin.mission-topics.judged');

                Route::get('/judge-detail/{key}', 'AdminMissionTopicController@judgeCouncilDetail')->name('admin.mission-topics.judged-detail');

                Route::get('/judge-print/{key}', 'AdminMissionTopicController@judgeCouncilPrint')->name('admin.mission-topics.judged-print');

                Route::post('/get-list-council','AdminMissionTopicController@getListCouncil')->name('admin.mission-topics.getListCouncil');

                Route::post('/add-council','AdminMissionTopicController@addCouncil')->name('admin.mission-topics.addCouncil');

                Route::get('/get-round-collection/{id}','AdminMissionTopicController@getRoundCollection')->name('admin.mission-topics.getRoundCollection');

                Route::get('/detail/{key}', 'AdminMissionTopicController@detail')->name('admin.mission-topics.detail');

                Route::get('/edit/{key}', 'AdminMissionTopicController@edit')->name('admin.mission-topics.edit');

                Route::post('update', 'AdminMissionTopicController@update')->name('admin.mission-topics.update');
                
                

                Route::get('/', 'AdminMissionTopicController@index')->name('admin.mission-topics.index');

                Route::get('/get-name-missions', 'AdminMissionTopicController@getNameMissions')->name('admin.mission-topics.getNameMissions');

            });


            /* START COUNCILS */
            Route::group(['prefix' => 'council'], function() {
                Route::resource('councils', 'CouncilController');

                Route::get('index', 'CouncilController@index')->name('council.index');

                Route::get('list', 'CouncilController@list')->name('council.list');

                Route::post('store', 'CouncilController@store')->name('council.store');

                Route::post('councils/lock','CouncilController@hide')->name('council.hide');

                Route::delete('destroy/{id}', 'CouncilController@destroy')->name('council.destroy');

                Route::get('view-member/{id}', 'CouncilController@viewMember')->name('council.view-member');

                Route::get('list-member/{id}', 'CouncilController@listMember')->name('council.list-member');

                Route::post('add-member', 'CouncilController@addMember')->name('council.add-member');

                Route::post('edit-member', 'CouncilController@editMember')->name('council.edit-member');

                Route::post('update-member', 'CouncilController@updateMember')->name('council.update-member');

                Route::post('delete-member', 'CouncilController@deleteMember')->name('council.delete-member');

            });
            /* END COUNCILS */

            Route::get('/get-profile-name', function() {
                $arr_name = \app\Helpers\AdminMission::getProfileName();
                return response()->json(['arr_name' =>  $arr_name]);
            });
        });

        Auth::routes();

        Route::post('login', 'Auth\LoginController@login')->name('admin_login.submit');
        Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

        Route::post('password/reset', 'Auth\ResetPasswordController@reset');


        //* End

        //* Quản lý logs hệ thống
          Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.log');
        //* End

        //* Vị trí hội đồng
        Route::get('position-councils/get-list', 'PositionCouncilController@getList')->name('position-councils.get-list');
        Route::resource('position-councils', 'PositionCouncilController');

        Route::prefix('position-councils')->group(function() {
            Route::post('store', 'PositionCouncilController@store')->name('position-councils.store');
            Route::post('lock', 'PositionCouncilController@hide')->name('position-councils.hide');
            Route::post('update', 'PositionCouncilController@update')->name('position-councils.update');
        });
        //* End

        //* Quản lý đề tài hoặc đề án
        Route::group(['prefix' => 'mission-topics'], function() {
            Route::post('/get-list-submit-ele-copy', 'AdminMissionTopicController@getSubmitEleList')->name('admin.mission-topics.getSubmitEleList');

            Route::post('/get-submit-hard-list', 'AdminMissionTopicController@getSubmitHardList')->name('admin.mission-science-technologies.getSubmitHardList');
            
            Route::post('/submit-hard-copy', 'AdminMissionTopicController@submitHardCopy')->name('admin.mission-topics.submitHardCopy');

            Route::post('/get-list-invalid-topic', 'AdminMissionTopicController@getInvalidTopic')->name('admin.mission-topics.getInvalidTopic');

            Route::post('/approve-mission', 'AdminMissionTopicController@approveMission')->name('admin.mission-topics.approveMission');

            Route::post('/upload-list-categories', 'AdminMissionTopicController@uploadListCategories')->name('admin.mission-topics.uploadListCategories');

            Route::post('/submit-assign', 'AdminMissionTopicController@submitAssign')->name('admin.mission-topics.submitAssign');

            Route::get('/', 'AdminMissionTopicController@index')->name('admin.mission-topics.index');
            Route::post('/give-back-hard-copy', 'AdminMissionTopicController@giveBackHardCopy')->name('admin.mission-topics.giveBackHardCopy');

            Route::get('/list-member-council/{id}', 'AdminMissionTopicController@listMemberCouncil')->name('missionTopic.listMemberCouncil');

            //danh sách hồ sơ được thêm của hội đồng
            Route::get('/list-evaluation', 'AdminMissionTopicController@listEvaluation')->name('missionTopic.listEvaluation');

            Route::post('/get-list-evaluation', 'AdminMissionTopicController@getListEvaluation')->name('missionTopic.getListEvaluation');

        });
        //* End

        //* Quản lý dự án khoa học và công nghệ
        Route::group(['prefix' => 'mission-science-technologies'], function() {
            Route::get('/', 'AdminMissionScienceTechnologyController@index')->name('admin.mission-science-technologies.index');
            Route::post('/get-list', 'AdminMissionScienceTechnologyController@getSubmitEleList')->name('admin.mission-science-technologies.getSubmitEleList');

            Route::post('/get-submit-hard-list', 'AdminMissionScienceTechnologyController@getSubmitHardList')->name('admin.mission-science-technologies.getSubmitHardList');

            Route::post('/get-list-invalid-topic', 'AdminMissionScienceTechnologyController@getInvalidTopic')->name('admin.mission-science-technologies.getInvalidTopic');

            Route::post('/submit-hard-copy', 'AdminMissionScienceTechnologyController@submitHardCopy')->name('admin.mission-science-technologies.submitHardCopy');
            Route::post('/submit-valid', 'AdminMissionScienceTechnologyController@submitValid')->name('admin.mission-science-technologies.submitValid');
            Route::post('/submit-judged', 'AdminMissionScienceTechnologyController@submitJudged')->name('admin.mission-science-technologies.submitJudged');
            Route::post('/approve-mission', 'AdminMissionScienceTechnologyController@approveMission')->name('admin.mission-science-technologies.approveMission');
            Route::post('/upload-list-categories', 'AdminMissionScienceTechnologyController@uploadListCategories')->name('admin.mission-science-technologies.uploadListCategories');
            Route::post('/view-detail', 'AdminMissionScienceTechnologyController@viewDetail')->name('admin.mission-science-technologies.viewDetail');
            Route::post('/submit-assign', 'AdminMissionScienceTechnologyController@submitAssign')->name('admin.mission-science-technologies.submitAssign');
            Route::post('/give-back-hard-copy', 'AdminMissionScienceTechnologyController@giveBackHardCopy')->name('admin.mission-science-technologies.giveBackHardCopy');
            Route::get('/list-member-council/{id}', 'AdminMissionScienceTechnologyController@listMemberCouncil')->name('admin.mission-science-technologies.listMemberCouncil');

            //danh sách hồ sơ được thêm của hội đồng
            Route::get('/list-evaluation', 'AdminMissionScienceTechnologyController@listEvaluation')->name('admin.mission-science-technologies.listEvaluation');

            Route::post('/get-list-evaluation', 'AdminMissionScienceTechnologyController@getListEvaluation')->name('admin.mission-science-technologies.getListEvaluation');

            Route::get('/edit/{key}', 'AdminMissionScienceTechnologyController@edit')->name('adminMissionScienceTechnology.edit');

            Route::post('update', 'AdminMissionScienceTechnologyController@update')->name('adminMissionScienceTechnology.update');

            Route::get('/get-name-missions', 'AdminMissionScienceTechnologyController@getNameMissions')->name('adminMissionScienceTechnology.getNameMissions');
        });
        //* End


      //* Auth Admin
        Auth::routes();
        Route::post('login', 'Auth\LoginController@login')->name('admin_login.submit');
        Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
        Route::get('change-password', 'UserController@showLinkChangePassword')->name('user.change-password');
        Route::post('change-password', 'UserController@ChangePassword')->name('user.post.change-password');
      //* End

        //* Vị trí hội đồng

        Route::resource('position-councils', 'PositionCouncilController');

        Route::prefix('position-councils')->group(function() {

            Route::post('store', 'PositionCouncilController@store')->name('position-councils.store');

            Route::post('lock', 'PositionCouncilController@hide')->name('position-councils.hide');

            Route::post('update', 'PositionCouncilController@update')->name('position-councils.update');

            Route::get('/get-list', 'PositionCouncilController@getList')->name('position-councils.get-list');
        });
        //* End

    });
    //* End Prefix Admin

    // ========================================================================== //

    //* profile
        Route::get('/', 'ProfileController@index');

      //* Thay đổi ảnh đại diện
        Route::post('change-avatar', 'ProfileController@postUpload')->name('profile.change-avatar');
      //* End

      //* Auth
        Route::get('login', 'AuthProfile\LoginController@showLoginForm')->name('profile.login');
        Route::post('login', 'AuthProfile\LoginController@login')->name('profile.login.submit');
        Route::post('logout', 'AuthProfile\LoginController@logout')->name('profile.logout');
        // Route::get('register', 'AuthProfile\RegisterController@showRegistrationForm')->name('profile.register');
        // Route::post('register', 'AuthProfile\RegisterController@register')->name('profile.register.submit');
        Route::get('password/reset', 'AuthProfile\ForgotPasswordController@showLinkRequestForm')->name('profile.password.request');
        Route::post('password/email', 'AuthProfile\ForgotPasswordController@sendResetLinkEmail')->name('profile.password.email');
        Route::get('password/reset/{token}', 'AuthProfile\ResetPasswordController@showResetForm')->name('profile.password.reset');
        Route::post('password/reset', 'AuthProfile\ResetPasswordController@reset');
        Route::get('confirm-register/{email}/{code}', 'AuthProfile\RegisterController@confirmRegister')->name('confirm-register')->middleware('confirm.register.profile');
        Route::get('change-password', 'ProfileController@showLinkChangePassword')->name('profile.change-password');
        Route::post('change-password', 'ProfileController@ChangePassword')->name('profile.post.change-password');
      //* End

        Route::get('profile', 'ProfileController@index')->name('profile');
        Route::post('get-info-profile', 'OrganizationController@getDetail');
    //* End

    //* Mission topic
    Route::group(['prefix'  =>  'mission-topics'], function () {
        Route::post('get-list', 'MissionTopicController@getList')->name('missionTopic.getList');
        Route::post('store', 'MissionTopicController@store')->name('missionTopic.store');
        Route::post('update', 'MissionTopicController@update')->name('missionTopic.update');
        Route::post('viewFile', 'MissionTopicController@viewFile')->name('missionTopic.viewFile');
        Route::post('uploadFile', 'MissionTopicController@uploadFile')->name('mission-sxtn.uploadFile');
        Route::get('/detail/{key}/{print?}', 'MissionTopicController@detail')->name('missionTopic.detail');
        Route::get('/edit/{key}', 'MissionTopicController@edit')->name('missionTopic.edit');
        Route::get('/delete/{id}', 'MissionTopicController@destroy')->name('missionTopic.destroy');
        Route::get('/submit_ele_copy', 'MissionTopicController@submitEleCopy')->name('missionTopic.submitEleCopy');

    });
    //* End

    //* Mission science technology
    Route::group(['prefix' => 'mission-science-technology'], function () {
        Route::post('store', 'MissionScienceTechnologyController@store')->name('missionScienceTechnology.store');
        Route::get('/edit/{key}', 'MissionScienceTechnologyController@edit')->name('missionScienceTechnology.edit');
        Route::post('update', 'MissionScienceTechnologyController@update')->name('missionScienceTechnology.update');
        Route::get('show/{key}', 'MissionScienceTechnologyController@show')->name('missionScienceTechnology.show');
        Route::post('get-list', 'MissionScienceTechnologyController@getList')->name('missionScienceTechnology.getList');
        Route::get('print/{key}', 'MissionScienceTechnologyController@print')->name('missionScienceTechnology.print');
        Route::post('destroy', 'MissionScienceTechnologyController@destroy')->name('missionScienceTechnology.destroy');
        Route::post('viewFile', 'MissionScienceTechnologyController@viewFile')->name('missionScienceTechnology.viewFile');
        Route::post('uploadFile', 'MissionScienceTechnologyController@uploadFile')->name('missionScienceTechnology.uploadFile');
        Route::get('/submit_ele_copy', 'MissionScienceTechnologyController@submitEleCopy')->name('missionScienceTechnology.submitEleCopy');
    });
    //* End

    //* Danh sách nhiệm vụ
    //
    Route::get('/missions', 'ProfileController@listMissions')->name('home.list-missions');
    //* End
});


//* ============================= Trash =======
//Quản lý dự án SXTN
// Route::resource('mission-sxtns', 'AdminMissionSxtnController');
// Route::post('mission-sxtns/get-list','AdminMissionSxtnController@list')->name('mission-sxtns.getList');
// Route::get('mission-sxtns/detail/{key}', 'AdminMissionSxtnController@detail')->name('admin-mission-sxtns.detail');
//
// Route::post('mission-sxtns/destroy', 'AdminMissionSxtnController@delete')->name('admin-mission-sxtns.delete');
//
// Route::get('/mission-sxtns/edit/{key}', 'AdminMissionSxtnController@edit')->name('admin-mission-sxtns.edit');
//
// Route::post('/mission-sxtns/edit', 'AdminMissionSxtnController@update')->name('admin-mission-sxtns.update');

//Quản lý dự án khoa học công nghệ
// Route::resource('mission-science-technologys', 'AdminMissionScienceTechnologyController');
// Route::post('mission-science-technologys/get-list','AdminMissionScienceTechnologyController@list')->name('mission-science-technologys.getList');

// Route::get('/', 'MissionTopicController@index')->name('missionTopic.index');


    // Route::group(['prefix' => 'mission-sxtn'] ,function() {
    //
    //     Route::get('/', 'MissionSxtnController@index')->name('mission-sxtn.index');
    //
    //     Route::get('get-list', 'MissionSxtnController@getList');
    //
    //     Route::post('add-mission-sxtn', 'MissionSxtnController@store')->name('mission-sxtn.create');
    //
    //     Route::get('edit-mission-sxtn/{key}', 'MissionSxtnController@edit')->name('mission-sxtn.edit');
    //
    //     Route::post('edit-mission-sxtn', 'MissionSxtnController@update')->name('mission-sxtn.update');
    //
    //     Route::get('/{key}', 'MissionSxtnController@detail')->name('mission-sxtn.detail');
    //
    //     Route::get('/print/{key}', 'MissionSxtnController@print')->name('mission-sxtn.print');
    //
    //     Route::post('destroy', 'MissionSxtnController@destroy')->name('mission-sxtn.destroy');
    //
    //     Route::post('viewFile', 'MissionSxtnController@viewFile')->name('mission-sxtn.viewFile');
    //
    //     Route::post('uploadFile', 'MissionSxtnController@uploadFile')->name('mission-sxtn.uploadFile');
    // });

        // Route::get('/', 'MissionScienceTechnologyController@index')->name('missionScienceTechnology.index');
        // 
        // 

