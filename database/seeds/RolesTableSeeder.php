<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Role::truncate();

      Role::create([
          'name' => 'super-admin',
          'display_name' => 'Super Admin',
      ]);

      Role::create([
          'name' => 'chuyen-vien-khoi-tao-dot-thu-ho-so',
          'display_name' => 'Chuyên viên khởi tạo đợt thu hồ sơ',
          'description' =>  'Có nhiệm vụ khởi tạo đợt thu, gọi hồ sơ đăng ký nhiệm vụ của đơn vị'
      ]);

      Role::create([
          'name' => 'chuyen-vien-van-thu',
          'display_name' => 'Chuyên viên (Văn thư)',
          'description' =>  'Có nhiệm vụ thu hồ sơ bản cứng và chuyển trạng thái nộp hồ sơ bản cứng cho đơn vị'
      ]);

      Role::create([
          'name' => 'chuyen-vien-truong-phong',
          'display_name' => 'Chuyên viên (Trưởng phòng)',
          'description' =>  'Có nhiệm vụ chọn hồ sơ và giao cho chuyên viên chuyên môn kiểm tra hồ sơ có hợp lệ hay không'
      ]);

      Role::create([
          'name' => 'chuyen-vien-chuyen-mon',
          'display_name' => 'Chuyên viên (Chuyên môn)',
          'description' =>  'Có nhiệm vụ nhận hồ sơ từ Trưởng phòng, và kiểm tra xem hồ sơ có hợp lệ hay không, sau đó chuyển trạng thái cho hồ sơ đã được kiểm tra'
      ]);

      Role::create([
          'name' => 'ban-chu-nhiem',
          'display_name' => 'Ban chủ nhiệm',
          'description' =>  'Có nhiệm vụ xem danh sách hồ sơ đã được kiểm tra hợp lệ theo đợt, sau đó chọn ra các hồ sơ được đánh giá, các hồ sơ bị từ chối kèm theo lý do'
      ]);

      Role::create([
          'name' => 'chuyen-vien-cap-nhat-danh-gia-ho-so',
          'display_name' => 'Chuyên viên cập nhật đánh giá hồ sơ',
          'description' =>  'Có nhiệm vụ dựa theo danh sách các hồ sơ được chọn đánh giá từ ban chủ nhiệm, chuyển trạng thái cho hồ sơ của đơn vị đăng ký, nếu bị từ chối phải kèm theo lý do'
      ]);

      Role::create([
          'name' => 'chuyen-vien-lap-hoi-dong',
          'display_name' => 'Chuyên viên lập hội đồng đánh giá',
          'description' =>  'Có nhiệm vụ lập hội đồng khoa học. ( Từ 7 đến 9 thành viên, gồm 1 chủ tịch, 1 phó chủ tịch, 2 ủy viên phản biện, 3 đến 5 ủy viên thường)'
      ]);

      Role::create([
          'name' => 'chuyen-vien-chon-hoi-dong-danh-gia-ho-so',
          'display_name' => 'Chuyên viên chọn hội đồng đánh giá cho từng hồ sơ',
          'description' =>  'Có nhiệm vụ chọn hội đồng đánh giá cho 1 hồ sơ (1 hội đồng có thể đánh giá nhiều hồ sơ )'
      ]);

      Role::create([
          'name' => 'hoi-dong',
          'display_name' => 'Hội đồng',
          'description' =>  'Có nhiệm vụ đánh giá hồ sơ trên hệ thống qua các form B1, B2, B3'
      ]);

      Role::create([
          'name' => 'chuyen-vien-cap-nhat-phe-duyet-ho-so',
          'display_name' => 'Chuyên viên cập nhật phê duyệt hồ sơ',
          'description' =>  'Có nhiệm vụ dựa theo quyết định phê duyệt hồ sơ từ cá nhân có quyền hạn, cập nhật trạng thái phê duyệt cho hồ sơ, nếu hồ sơ bị từ chối phê duyệt thì phải có lý do'
      ]);
    }
}
