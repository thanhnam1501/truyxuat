<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();

        //quan ly tai khoan

        Permission::create([
            'name'=>'user-view',
            'display_name'=>'Xem danh sách tài khoản',
        ]);
        Permission::create([
            'name'=>'user-add',
            'display_name'=>'Thêm mới tài khoản',
        ]);
        Permission::create([
            'name'=>'user-detail',
            'display_name'=>'Xem chi tiết tài khoản',
        ]);
        Permission::create([
            'name'=>'user-roles',
            'display_name'=>'Quản lý vai trò tài khoản',
        ]);
        Permission::create([
            'name'=>'user-edit',
            'display_name'=>'Cập nhật tài khoản',
        ]);
        Permission::create([
            'name'=>'user-delete',
            'display_name'=>'Xóa tài khoản',
        ]);

        //quan ly vai tro
        Permission::create([
            'name'=>'roles-view',
            'display_name'=>'Xem danh sách vai trò',
        ]);
        Permission::create([
            'name'=>'roles-add',
            'display_name'=>'Thêm mới vai trò',
        ]);
        Permission::create([
            'name'=>'roles-permissions',
            'display_name'=>'Quản lý quyền hạn vài trò',
        ]);
        Permission::create([
            'name'=>'roles-edit',
            'display_name'=>'Cập nhật vài trò',
        ]);
        Permission::create([
            'name'=>'roles-delete',
            'display_name'=>'Xóa vài trò',
        ]);

        //quyen han
        Permission::create([
            'name'=>'permissions-view',
            'display_name'=>'Xem danh sách quyền hạn',
        ]);

        Permission::create([
            'name'=>'add-permissions',
            'display_name'=>'Thêm mới quyền',
        ]);

        //khoa tai khoan
        Permission::create([
            'name'=>'account-lock',
            'display_name'=>'Khóa tài khoản',
        ]);
        Permission::create([
            'name'=>'account-unlock',
            'display_name'=>'Mở khóa tài khoản',
        ]);
        // Thu hồ sơ
        Permission::create([
            'name'=>'round-collection-view',
            'display_name'=>'Xem danh sách thu hồ sơ',
        ]);
        Permission::create([
            'name'=>'round-collection-create',
            'display_name'=>'Thêm danh sách thu hồ sơ',
        ]);
        Permission::create([
            'name'=>'round-collection-edit',
            'display_name'=>'Sửa danh sách thu hồ sơ',
        ]);
        Permission::create([
            'name'=>'round-collection-delete',
            'display_name'=>'Xoá danh sách thu hồ sơ',
        ]);

        //Cập nhập trạng thái hồ sơ
        Permission::create([
            'name'=>'view-list',
            'display_name'=>'Xem danh sách hồ sơ',
        ]);

        Permission::create([
            'name'=>'view-detail',
            'display_name'=>'Xem chi tiết hồ sơ',
        ]);

        Permission::create([
            'name'=>'receive-hard-copy',
            'display_name'=>'Thu bản cứng hồ sơ',
        ]);

        Permission::create([
            'name'=>'return-hard-copy',
            'display_name'=>'Trả lại bản cứng hồ sơ',
        ]);
        Permission::create([
            'name'=>'judged-doc',
            'display_name'=>'Xác nhận hồ sơ được đánh giá',
        ]);
        Permission::create([
            'name'=>'denied-doc',
            'display_name'=>'Từ chối hồ sơ',
        ]);
        Permission::create([
            'name'=>'assign-doc',
            'display_name'=>'Giao hồ sơ cho cán bộ xử lý',
        ]);
        Permission::create([
            'name'=>'valid-doc',
            'display_name'=>'Xác nhận hồ sơ hợp lệ',
        ]);
        Permission::create([
            'name'=>'invalid-doc',
            'display_name'=>'Xác nhận hồ sơ không hợp lệ',
        ]);
        Permission::create([
            'name'=>'approve-doc',
            'display_name'=>'Xác nhận hồ sơ được phê duyệt thực hiện',
        ]);
        Permission::create([
            'name'=>'unapprove-doc',
            'display_name'=>'Xác nhận hồ sơ không được phê duyệt thực hiện',
        ]);
        Permission::create([
            'name'=>'assign-council',
            'display_name'=>'Chọn hội đồng đánh giá',
        ]);
        Permission::create([
            'name'=>'account-profile-menu',
            'display_name'=>'Hiển thị menu quản lý cá nhân/tổ chức',
        ]);
        Permission::create([
            'name'=>'mission-topics-menu',
            'display_name'=>'Hiển thị menu quản lý đề tài/đề án',
        ]);
        Permission::create([
            'name'=>'mission-science-technology-menu',
            'display_name'=>'Hiển thị menu quản lý dự án khoa học và công nghệ',
        ]);
        Permission::create([
            'name'=>'council-menu',
            'display_name'=>'Hiển thị menu quản lý hội đồng',
        ]);
        Permission::create([
            'name'=>'group-council-menu',
            'display_name'=>'Hiển thị menu quản lý nhóm hội đồng',
        ]);
        Permission::create([
            'name'=>'position-council-menu',
            'display_name'=>'Hiển thị menu quản lý vị trí trong hội đồng',
        ]);
        Permission::create([
            'name'=>'logs-menu',
            'display_name'=>'Hiển thị menu quản lý log',
        ]);
    }
}
