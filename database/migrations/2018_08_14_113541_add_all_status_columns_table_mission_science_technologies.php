    <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllStatusColumnsTableMissionScienceTechnologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            
            if (!Schema::hasColumn('mission_science_technologies', 'is_submit_ele_copy')) {
                $table->tinyInteger('is_submit_ele_copy')->default(0)->comment('Nộp bản mềm - 0: chưa nộp, 1: đã nộp');
            }            
            if (!Schema::hasColumn('mission_science_technologies', 'is_submit_hard_copy')) {
                $table->tinyInteger('is_submit_hard_copy')->default(0)->comment('Nộp bản cứng - 0: chưa nộp, 1: đã nộp');
            }            
            if (!Schema::hasColumn('mission_science_technologies', 'is_receive')) {
                $table->tinyInteger('is_receive')->default(0)->comment('Thu bản cứng - 0: chưa thu, 1: đã thu');
            }            
            if (!Schema::hasColumn('mission_science_technologies', 'is_assign')) {
                $table->tinyInteger('is_assign')->default(0)->comment('Giao hồ sơ - 0: chưa giao, 1: đã giao');
            }            
            if (!Schema::hasColumn('mission_science_technologies', 'is_valid')) {
                $table->tinyInteger('is_valid')->default(0)->comment('Hồ sơ hợp lệ - 0: chưa kiểm tra, 1: hồ sơ hợp lệ');
            }            
            if (!Schema::hasColumn('mission_science_technologies', 'is_invalid')) {
                $table->tinyInteger('is_invalid')->default(0)->comment('Hồ sơ không hợp lệ - 0: chưa kiểm tra, 1: hồ sơ không hợp lệ');
            }            
            if (!Schema::hasColumn('mission_science_technologies', 'is_judged')) {
                $table->tinyInteger('is_judged')->default(0)->comment('Đánh giá hồ sơ - 0: chưa xử lý, 1: Được đánh giá');
            }            
            if (!Schema::hasColumn('mission_science_technologies', 'is_denied')) {
                $table->tinyInteger('is_denied')->default(0)->comment('Từ chối hồ sơ - 0: chưa xử lý, 1: Hồ sơ bị từ chối');
            }          
            if (!Schema::hasColumn('mission_science_technologies', 'is_invalid_reason')) {
                $table->string('is_invalid_reason')->nullable()->comment('Lý do hồ sơ không hợp lệ');
            }          
            if (!Schema::hasColumn('mission_science_technologies', 'is_denied_reason')) {
                $table->string('is_denied_reason')->nullable()->comment('Lý do từ chối hồ sơ');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            if (Schema::hasColumn('mission_science_technologies ', 'is_submit_ele_copy')) {
                $table->dropColumn('is_submit_ele_copy');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_submit_hard_copy')) {
                $table->dropColumn('is_submit_hard_copy');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_receive')) {
                $table->dropColumn('is_receive');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_assign')) {
                $table->dropColumn('is_assign');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_valid')) {
                $table->dropColumn('is_valid');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_invalid')) {
                $table->dropColumn('is_invalid');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_judged')) {
                $table->dropColumn('is_judged');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_denied')) {
                $table->dropColumn('is_denied');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_invalid_reason')) {
                $table->dropColumn('is_invalid_reason');
            }
            if (Schema::hasColumn('mission_science_technologies ', 'is_denied_reason')) {
                $table->dropColumn('is_denied_reason');
            }
        });
    }
}
