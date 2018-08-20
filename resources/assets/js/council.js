/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
        /******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
        /******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
        /******/ 			i: moduleId,
        /******/ 			l: false,
        /******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
        /******/ 		if(!__webpack_require__.o(exports, name)) {
                /******/ 			Object.defineProperty(exports, name, {
                        /******/ 				configurable: false,
                        /******/ 				enumerable: true,
                        /******/ 				get: getter
                /******/ 			});
        /******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
        /******/ 		var getter = module && module.__esModule ?
        /******/ 			function getDefault() { return module['default']; } :
        /******/ 			function getModuleExports() { return module; };
        /******/ 		__webpack_require__.d(getter, 'a', getter);
        /******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 18);
/******/ })
/************************************************************************/
/******/ ({

        /***/ 18:
        /***/ (function(module, exports, __webpack_require__) {

                module.exports = __webpack_require__(19);


        /***/ }),

        /***/ 19:
        /***/ (function(module, exports) {

                $(function () {
                        $('#council').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: app_url + 'admin/council/list',
                                ordering: false,
                                columns: [
                                { data: 'DT_Row_Index', searchable: false }, 
                                { data: 'name', name: 'name' }, 
                                { data: 'group_council_id', name: 'group_council_id' }, 
                                { data: 'created_at', name: 'created_at', className: 'text-center' }, 
                                { data: 'status', name: 'status', className: 'text-center' }, 
                                { data: 'round_collection_id', name: 'round_collection_id', className: 'text-center' }, 
                                { data: 'action', name: 'action', className: 'text-center', searchable: false }]
                        });
                });
                
                $.validator.addMethod("valueNotEquals", function (value, element, arg) {
                        return arg !== value;
                }, "Value must not equal arg.");

                $(function () {

                        $('#addCouncil').on('click', function () {
                                $('#create-council-mdl').modal('show');        
                        });

        $('#create-council-frm').validate({ // initialize the plugin
                errorElement: "span",
                rules: {
                        name: {
                                required: true,
                                minlength: 10
                        },
                        round_collection_id: {
                                valueNotEquals: "-1"
                        },
                        group_council_id: {
                                valueNotEquals: "-1"
                        }

                },
                messages: {
                        name: {
                                required: "(*) Vui lòng nhập tên hội đồng",
                                minlength: "(*) Độ dài phải lớn hơn 10 ký tự"
                        },
                        round_collection_id: {
                                valueNotEquals: '(*) Vui lòng chọn đợt gọi hồ sơ'
                        },
                        group_council_id: {
                                valueNotEquals: '(*) Vui lòng chọn nhóm hội đồng'
                        }
                }
        });

        $('#edit-council-frm').validate({ // initialize the plugin
                errorElement: "span",
                rules: {
                        name_council: {
                                required: true,
                                minlength: 10
                        },
                        round_collection_id_council: {
                                valueNotEquals: "-1"
                        },
                        group_council_id_council: {
                                valueNotEquals: "-1"
                        }

                },
                messages: {
                        name_council: {
                                required: "(*) Vui lòng nhập tên hội đồng",
                                minlength: "(*) Độ dài phải lớn hơn 10 ký tự"
                        },
                        round_collection_id_council: {
                                valueNotEquals: '(*) Vui lòng chọn đợt gọi hồ sơ'
                        },
                        group_council_id_council: {
                                valueNotEquals: '(*) Vui lòng chọn nhóm hội đồng'
                        }
                }
        });

        //Thêm mới
        $('#create-council-btn').on('click', function (e) {

                e.preventDefault();

                $check = $('#create-council-frm').valid();
                if (!$check) {
                        return;
                } else {
                        $.ajax({
                                url: app_url + 'admin/council/store',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                        name: $('#name').val(),
                                        round_collection_id: $('#round_collection_id').val(),
                                        group_council_id: $('#group_council_id').val(),
                                        status: $('#status').val(),
                                },
                                success: function success(res) {
                                        $('#create-council-mdl').modal('hide');
                                        if (!res.error) {

                                                toastr.success(res.message);
                                                $('#council').DataTable().ajax.reload();
                                        } else {

                                                toastr.error(res.message);
                                        }
                                },
                                error: function error(xhr, ajaxOptions, thrownError) {
                                        //toastr.error(thrownError);
                                        toastr.error("Lỗi! Không thể đăng ký! <br>Vui lòng thử lại hoặc liên lạc với IT");
                                }
                        });
                }
        });

        //Sửa
        $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                        url: app_url + "admin/council/councils/" + id,
                        type: 'get',
                        success: function success(res) {
                                if (res.err != true) {
                                        $('#edit-council-mdl').modal('show');
                                        $('#edit-council-btn').attr('data-id', id);
                                        $('#name_council').val(res.data.name);
                                        $('#round_collection_id_council').val(res.data.round_collection_id);
                                        $('#group_council_id_council').val(res.data.group_council_id);
                                }
                        },
                        error: function error(jqXHR, textStatus, errorThrown) {}
                });
        });

        $('#edit-council-btn').click(function (e) {
                var id = $(this).attr('data-id');
                e.preventDefault();
                $.ajax({
                        url: app_url + "admin/council/councils/" + id,
                        type: 'put',
                        data: {
                                'name': $('#name_council').val(),
                                'round_collection_id': $('#round_collection_id_council').val(),
                                'group_council_id': $('#group_council_id_council').val(),
                        },
                        success: function success(res) {
                                if (res.err != true) {
                                        $('#council').DataTable().ajax.reload();
                                        $('#edit-council-mdl').modal('hide');
                                        toastr.success('Đã cập nhật hội đồng');
                                }
                        },
                        error: function error(jqXHR, textStatus, errorThrown) {
                                if (jqXHR.responseJSON.errors.name !== undefined) {
                                        $('#edit-name-error-custom').text(jqXHR.responseJSON.errors.name[0]);
                                }
                        }
                });
        });

        //Ẩn/hiện trạng thái
        $(document).on('change', '.hide-council', function () {

                var status = 0;
                var id = $(this).attr('data-id');
                console.log(id);
                if ($(this).is(':checked')) {
                        status = 1;
                }

                $.ajax({
                        type: "POST",
                        url: app_url + "admin/council/councils/lock",
                        data: {
                                status: status,
                                id: id
                        },
                        success: function success(res) {
                                if (!res.error) {

                                        toastr.success(res.message);
                                        $('#council').DataTable().ajax.reload();
                                } else {

                                        toastr.error(res.message);
                                }
                        },
                        error: function error(xhr, ajaxOptions, thrownError) {
                                toastr.error(thrownError);
                        }
                });
        });

        //Xóa
        $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                swal({
                        title: "Bạn chắc chắn muốn xóa?",
                        icon: "warning",
                        buttons: ['Hủy', 'Xóa'],
                        dangerMode: true
                }).then(function (willDelete) {
                        if (willDelete) {
                                $.ajax({
                                        url: app_url + "admin/council/destroy/" + id,
                                        type: 'delete',
                                        success: function success(res) {
                                                if (res.err != true) {
                                                        $('#council').DataTable().ajax.reload();
                                                        toastr.success('Đã xoá hội đồng');
                                                }
                                        },
                                        error: function error(jqXHR, textStatus, errorThrown) {}
                                });
                        }
                });
        });

        //Xem chi tiết
        $(document).on('click', '.btn-view', function (e) {
                
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                        url: app_url + "admin/council/councils/" + id,
                        type: 'get',
                        success: function success(res) {
                                if (res.err != true) {
                                        // console.log(res);
                                        var status = "";
                                        if (res.data.status == 1) {
                                                status = "Hiển thị";
                                                $('#lock-icon').attr('class', 'fa fa-unlock-alt');
                                        } else {
                                                status = "Ẩn";
                                                $('#lock-icon').attr('class', 'fa fa-lock');
                                        }
                                        $('#detail-council-mdl').modal('show');
                                        $('#edit-collection-btn').attr('data-id', id);
                                        $('#detail-name').text("Tên: " + res.data.name);
                                        $('#detail-status').text("Trạng thái: " + status);
                                        $('#detail-created_at').text("Ngày tạo: " + res.data.created_at);
                                        $('#detail-round_collection_id').text("Đợt gọi hồ sơ: " + res.roundCollection);
                                        $('#detail-group_council_id').text("Nhóm hội đồng: " + res.group_council_id);
                                }
                        },
                        error: function error(jqXHR, textStatus, errorThrown) {}
                });
        });

        $(document).on('click', '.btn-view-member', function(e) {
                
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                        url: app_url + 'admin/council/view-member/' + id,
                        type: 'get',
                        success:function(res) {
                                $('#flag').empty();

                                $('#list-member-mdl').modal('show');
                                $('#council_id').val(id);
                                $('#e_council_id').val(id);

                                if (res.data.name != '') {
                                        $('#council_name').html(res.data.name); 
                                }
                                else {
                                        $('#council_name').hmtl('Đang cập nhật');
                                }
                                
                                if (res.group_council_id != '') {
                                        $('#group_council_name').html(res.group_council_id);
                                }
                                else {
                                        $('#group_council_name').hmtl('Đang cập nhật');
                                }

                                if (res.roundCollection != '') {
                                        $('#year').html(res.roundCollection);
                                }
                                else {
                                        $('#year').hmtl('Đang cập nhật');
                                }   
                                
                                $('#council_member').DataTable().destroy();
                                
                                $('#council_member').DataTable({
                                        ajax: app_url + 'admin/council/list-member/' + id,
                                        ordering: false,
                                        searching: false,
                                        paginate: false,
                                        columns: [
                                        { data: 'DT_Row_Index', searchable: false, width: '30px'}, 
                                        { data: 'user_name', name: 'user_name', width: '150px' }, 
                                        { data: 'email', name: 'email', width: '150px' }, 
                                        { data: 'phone', name: 'phone', className: 'text-center', width: '100px' }, 
                                        { data: 'position_council', name: 'position_council', className: 'text-center', width : '200px' }, 
                                        { data: 'action', name: 'action', width: '130px', className: 'text-center', searchable: false }] 
                                });
                                // var council_user_arr = res.council_user_arr;

                                

                                // if (council_user_arr.length > 0) {
                                //       for (var i = 0; i < council_user_arr.length; i++) {
                                //                 var html = "<tr>"+
                                //                       "<td>"+(i+1)+"</td>"+
                                //                       "<td>"+council_user_arr[i].user_name+"</td>"+
                                //                       "<td>"+council_user_arr[i].email+"</td>"+
                                //                       "<td>01696461667</td>"+
                                //                       "<td>"+council_user_arr[i].position_council+"</td>"+

                                //                       "<td style='text-align: center'>"+
                                //                         "<a class='btn btn-warning btn-xs' data-id=''><i class='fa fa-pencil'></i></a>"+
                                //                         "<a class='btn btn-danger btn-xs' data-id=''><i class='fa fa-trash-o'></i></a>"+
                                //                       "</td>"
                                                      
                                //                   "</tr>";
                                //                 $('#flag').append(html);
                                //         }  
                                          
                                // }     
                                // else {
                                //         $('#flag').append("<tr><td colspan='6' style='text-align:center'>(Không có thành viên nào)</td></tr>");
                                // }   
                                
                        }
                });
                
                
        })
        
        $.validator.addMethod("valueNotEquals", function(value, element, arg){
          return arg !== value;
         }, "Value must not equal arg.");

        // $('#add-council-member').validate({ // initialize the plugin
        //       errorElement: "span",
        //       rules: {
        //         user_id : {
        //                 required: true,
        //            valueNotEquals: "-1",
                  
        //         },
        //          position_council_id: { 
        //            valueNotEquals: "-1" 
        //         },

        //       },
        //       messages: {
        //         user_id : {
        //                 required:" Vui lòng chọn chuyên gia",
        //           valueNotEquals : " Vui lòng chọn chuyên gia",

        //         },
        //         position_council_id : {
        //           valueNotEquals: ' Vui lòng chọn vị trí hội đồng'
        //         }
        //       }
        // });

        $('#position_council_id').on('change', function() {
                $('#position_council_id_msg').html('');
        })

        $('#user_id').on('change', function() {
                $('#user_id_msg').html('');
        })

        $('#add-council-member').on('submit', function(e) {
                e.preventDefault();
                var check = true;
                if($('#user_id').val() == -1) {
                        $('#user_id_msg').html('Vui lòng chọn chuyên gia');
                        check = false;
                }
                if ($('#position_council_id').val() == -1) {
                        $('#position_council_id_msg').html('Vui lòng chọn vị trí trong hội đồng');
                        check = false;
                }
                
                if (!check) { 
                        return ;
                }
                else {
                        var data = $(this).serialize();
                        $.ajax({
                                url: app_url + 'admin/council/add-member',
                                type: 'POST',
                                data: data,
                                success: function(res) {
                                        if (!res.error) {
                                                toastr.success(res.message);
                                                $('#council_member').DataTable().ajax.reload();
                                                $('#add-member-mdl').modal('hide');
                                                // $('#user_id').val('');
                                                $('.user_id').select('refresh');
                                                $('#position_council_id').val('-1');
                                        }
                                        else {
                                                toastr.error(res.message);
                                        }
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                        toastr.error('Lỗi! Không thể đăng ký! <br>Vui lòng thử lại hoặc liên lạc với IT');
                                }
                        });
                }
        
                
        })

        $(document).on('click', '.delete-member' , function (e) {
                e.preventDefault();
                var user_id=$(this).attr('data-userid');
                var council_id=$(this).attr('data-councilid');
                swal({
                title: "Bạn chắc chắn muốn xóa?",
                icon: "warning",
                buttons: ['Hủy','Xóa'],
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                      url: app_url + "admin/council/delete-member",
                      type: 'post',
                      data: {
                        'user_id' : user_id,
                        'council_id' : council_id
                      },
                      success: function(res){
                        if (!res.error) {
                          $('#council_member').DataTable().ajax.reload();
                          toastr.success(res.message);
                        }
                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                    });

              }
            });
        });


        $(document).on('click', '.update-member' ,function(e) {
                e.preventDefault();
                var user_id = $(this).data('userid');
                var council_id = $(this).data('councilid');

                $('#e_user_id').val(user_id);

                $.ajax({
                        url: app_url + 'admin/council/edit-member',
                        type: 'post',
                        
                        data: {
                                user_id: user_id, 
                                council_id: council_id
                        },

                        success:function(res) {

                                var user = res.user;
                                $('#user_name').html(user.name);
                                $('#email').html(user.email);
                                $('#mobile').html((user.mobile != null) ? user.mobile : 'Chưa cập nhật');
                        
                                $('#e_position_council_id').val(res.position_council_id);
                        }
                });
                
                $('#update-member-mdl').modal('show');
        });


        $('#update-council-member').on('submit', function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                        url: app_url + '/admin/council/update-member',
                        type: 'post',
                
                        data: data,

                        success: function(res) {
                                if (!res.error) {
                                        toastr.success(res.message);
                                        $('#council_member').DataTable().ajax.reload();
                                        $('#update-member-mdl').modal('hide');
                                }
                        }
                });
                
        })
});

/***/ })

/******/ });