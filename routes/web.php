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

Route::get('test/{tps}', function ($tps){
  $tps = str_split($tps);
  $rs = "";
  $max = sizeof($tps);
  try {
   $i= 0;
   while ($i < $max)
   {
    $trs = $tps[$i] ."". $tps[$i + 1];
    if ($trs == "l2")
    {
      $rs = $rs . "0";
    }
    if ($trs == "x8")
    {
      $rs = $rs . "1";
    }
    if ($trs == "n4")
    {
      $rs = $rs. "2";
    }
    if ($trs == "k9")
    {
      $rs = $rs . "3";
    }
    if ($trs == "o7")
    {
      $rs = $rs . "4";
    }
    if ($trs == "p1")
    {
      $rs = $rs . "5";
    }
    if ($trs == "y3")
    {
      $rs = $rs . "6";
    }
    if ($trs == "z0")
    {
      $rs = $rs . "7";
    }
    if ($trs == "a5")
    {
      $rs = $rs . "8";
    }
    if ($trs == "c6")
    {
      $rs = $rs . "9";
    }
    $i = $i + 2;
  }
} catch (Exception $e) {
  return "0";
}
  // $str = str_split($numbers);
  // $max = sizeof($str);
  //   $rs = "";
  // for ($i = 0; $i < $max; $i++) {
  //   if ($str[$i] == 0) {
  //     $rs = $rs . "l2";
  //   }
  //   if ($str[$i] == 1) {
  //     $rs = $rs . "x8";
  //   }
  //   if ($str[$i] == 2) {
  //     $rs = $rs . "n4";
  //   }
  //   if ($str[$i] == 3) {
  //     $rs = $rs . "k9";
  //   }
  //   if ($str[$i] == 4) {
  //     $rs = $rs . "o7";
  //   }
  //   if ($str[$i] == 5) {
  //     $rs = $rs . "p1";
  //   }
  //   if ($str[$i] == 6) {
  //     $rs = $rs . "y3";
  //   }
  //   if ($str[$i] == 7) {
  //     $rs = $rs . "z0";
  //   }
  //   if ($str[$i] == 8) {
  //     $rs = $rs . "a5";
  //   }
  //   if ($str[$i] == 9) {
  //     $rs = $rs . "c6";
  //   }           
  // }
return($rs);
});

Route::middleware('revalidate')->group(function () {

    //* Admin
  Route::prefix('admin')->group(function () {
    Route::middleware('auth')->group(function () {

    //  Route::get('qr-code', function () {
    //   return QrCode::size(500)->generate('Welcome to kerneldev.com!');
    // });
            //* Quản lý doanh nghiệp
     Route::group(['prefix' => 'doanh-nghiep'], function () {
      Route::get('get-list', 'CompanyController@getlist')->name('company.getList');
      Route::get('/', 'CompanyController@index')->name('company.index');
      Route::get('tao-moi', 'CompanyController@getFormCreate')->name('company.ShowFormCreate');
      Route::post('create', 'CompanyController@create')->name('company.create');
      Route::get('cap-nhat-thong-tin-doanh-nghiep/{id}', 'CompanyController@edit')->name('company.edit');
      Route::post('update-thong-tin-doanh-nghiep', 'CompanyController@update')->name('company.update');
      Route::post('xoa-doanh-nghiep','CompanyController@delete')->name('company.delete');
    });
     Auth::routes();
     Route::get('/', 'UserController@home')->name('admin.index');

            //* Quản lý quản trị viênus
     Route::group(['prefix' => 'quan-tri-vien'], function () {
      Route::get('get-list', 'UserController@getlist')->name('user.getList');
      Route::get('/', 'UserController@index')->name('admin.user.index');
      Route::get('tao-moi', 'UserController@getFormCreate')->name('user.ShowFormCreate');
      Route::post('create', 'UserController@store')->name('user.create');
      Route::get('cap-nhat-thong-tin-quan-tri-vien/{id}', 'UserController@edit')->name('user.edit');
      Route::post('update-thong-tin-quan-tri-vien', 'UserController@update')->name('user.update');
      Route::post('xoa-quan-tri-vien','UserController@destroy')->name('user.delete');
    });
            //* End

            //* Quản lý người dùng
     Route::group(['prefix' => 'nguoi-dung'], function () {
      Route::get('get-list', 'AdminProfileController@getlist')->name('profile.getList');
      Route::get('/', 'AdminProfileController@index')->name('profile.index');
      Route::get('tao-moi', 'AdminProfileController@getFormCreate')->name('profile.ShowFormCreate');
      Route::post('create', 'AdminProfileController@store')->name('profile.create');
      Route::get('cap-nhat-thong-tin-nguoi-dung/{id}', 'AdminProfileController@edit')->name('profile.edit');
      Route::post('update-thong-tin-nguoi-dung', 'AdminProfileController@update')->name('profile.update');
      Route::post('xoa-nguoi-dung','AdminProfileController@destroy')->name('profile.delete');
    });
            //* End

            //* Quản lý sản phẩm
     Route::group(['prefix' => 'san-pham'], function () {
      Route::get('get-list', 'AdminProductController@getlist')->name('product.getList');
      Route::get('/', 'AdminProductController@index')->name('product.index');
      Route::get('tao-moi', 'AdminProductController@getFormCreate')->name('product.ShowFormCreate');
      Route::post('create', 'AdminProductController@store')->name('product.create');
      Route::get('cap-nhat-thong-tin-san-pham/{id}', 'AdminProductController@edit')->name('product.edit');
      Route::post('update-thong-tin-san-pham', 'AdminProductController@update')->name('product.update');
      Route::post('xoa-san-pham','AdminProductController@destroy')->name('product.delete');
      Route::get('xem-chi-tiet/{id}', 'AdminProductController@show')->name('product.show');
    });
            //* End

       //* Quản lý các node
     Route::group(['prefix' => 'node'], function () {
      Route::get('get-list', 'AdminNodeController@getlist')->name('node.getList');
      Route::get('/', 'AdminNodeController@index')->name('node.index');
      Route::get('tao-moi', 'AdminNodeController@getFormCreate')->name('node.ShowFormCreate');
      Route::post('create', 'AdminNodeController@store')->name('node.create');
      Route::get('cap-nhat-thong-tin-node/{id}', 'AdminNodeController@edit')->name('node.edit');
      Route::post('update-node', 'AdminNodeController@update')->name('node.update');
      Route::post('xoa-node','AdminNodeController@destroy')->name('node.delete');


    });
        //*end
   });

        //* End Quản lý doanh nghiệp

        //* Quản lý logs hệ thống
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.log');
        //* End



      //* Auth Admin
Auth::routes();
Route::post('login', 'Auth\LoginController@login')->name('admin.login.submit');
Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('change-password', 'UserController@showLinkChangePassword')->name('user.change-password');
Route::post('change-password', 'UserController@ChangePassword')->name('user.post.change-password');
      //* End

      //* Quản lý lịch sử
Route::group(['prefix' => 'lịch-su-nguoi-dung'], function () {
  Route::get('get-list', 'User_HistoryController@getlist')->name('history.getList');
  Route::get('/', 'User_HistoryController@index')->name('admin.history.index');

});
            //* End

});
    //* End Prefix Admin

    // ========================================================================== //

    //* profile
    // Route::get('/', function(){
    //     $data = bcrypt('123456');
    //     return $data;
    // });

Route::get('/', 'ProductController@index')->name('user.index');
Route::get('/home', 'ProductController@index')->name('user.index');
Route::get('check/{id}', 'HomeController@show');


Route::get('/qrcode', function(){
  $message = '<h1>Chào mừng quý khách đến với <span style="color: red">S</span>martCheck</h1>'; 
  return $message;
 // // $url = url('/check/24');
 // // return view('qrcode', ['url' => $url]);
});

      // //* Thay đổi ảnh đại diện
      //   Route::post('change-avatar', 'ProfileController@postUpload')->name('profile.change-avatar');
      // //* End

      //* Auth
Route::get('login', 'AuthProfile\LoginController@showLoginForm')->name('profile.login');
Route::post('login', 'AuthProfile\LoginController@login')->name('profile.login.submit');
Route::get('logout', 'AuthProfile\LoginController@logout')->name('profile.logout');
Route::get('register', 'AuthProfile\RegisterController@showRegistrationForm')->name('profile.register');
Route::post('register', 'AuthProfile\RegisterController@register')->name('profile.register.submit');
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

//* Quản lý người dùng
Route::group(['prefix' => 'nguoi-dung'], function () {
  Route::get('get-list', 'ProfileController@getlist')->name('user.profile.getList');
  Route::get('/', 'ProfileController@index')->name('user.profile.index');
  Route::get('tao-moi', 'ProfileController@getFormCreate')->name('user.profile.ShowFormCreate');
  Route::post('create', 'ProfileController@store')->name('user.profile.create');
  Route::get('cap-nhat-thong-tin-nguoi-dung/{id}', 'ProfileController@edit')->name('user.profile.edit');
  Route::post('update-thong-tin-nguoi-dung', 'ProfileController@update')->name('user.profile.update');
  Route::post('xoa-nguoi-dung','ProfileController@destroy')->name('user.profile.delete');
});
            //* End

        //* Quản lý sản phẩm
Route::group(['prefix' => 'san-pham'], function () {
  Route::get('get-list', 'ProductController@getlist')->name('user.product.getList');
  Route::get('/', 'ProductController@index')->name('user.product.index');
  Route::get('tao-moi', 'ProductController@getFormCreate')->name('user.product.ShowFormCreate');
  Route::post('create', 'ProductController@store')->name('user.product.create');
  Route::get('cap-nhat-thong-tin-san-pham/{id}', 'ProductController@edit')->name('user.product.edit');
  Route::post('update-thong-tin-san-pham', 'ProductController@update')->name('user.product.update');
  Route::post('xoa-san-pham','ProductController@destroy')->name('user.product.delete');
  Route::get('xem-chi-tiet/{id}', 'ProductController@show')->name('user.product.show');

});
            //* End

        //* Quản lý lịch sử
Route::group(['prefix' => 'lich-su-nguoi-dung'], function () {
  Route::get('get-list', 'User_HistoryController@getlist')->name('user.history.getList');
  Route::get('/', 'User_HistoryController@index')->name('user.history.index');

});
            //* End

       //* Quản lý các node
Route::group(['prefix' => 'node'], function () {
  Route::get('get-list', 'NodeController@getlist')->name('user.node.getList');
  Route::get('/', 'NodeController@index')->name('user.node.index');
  Route::get('tao-moi', 'NodeController@getFormCreate')->name('user.node.ShowFormCreate');
  Route::post('create', 'NodeController@store')->name('user.node.create');
  Route::get('cap-nhat-thong-tin-node/{id}', 'NodeController@edit')->name('user.node.edit');
  Route::post('update-node', 'NodeController@update')->name('user.node.update');
  Route::post('xoa-node','NodeController@destroy')->name('user.node.delete');
  Route::get('tao-moi-buoc', 'NodeController@ShowFormCreateOne')->name('user.node.ShowFormCreateOne');
  Route::post('createOne', 'NodeController@create')->name('user.node.createOne');


});
            //* End

Route::post('change-password', 'ProfileController@ChangePassword')->name('user.profile.change_password');
Route::get('change-password', 'ProfileController@ShowFormChangePassword')->name('user.profile.ShowFormChangePassword');


});


