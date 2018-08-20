<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeKeyColumnToMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtns', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_sxtns', 'key')) {
                $table->string('key',60)->nullable()->comment('số hồ sơ md5(id+company_id+now+"SXTN")');
            }
            if (!Schema::hasColumn('mission_sxtns','code')) {
              $table->string('code')->nullable()->comment('Mã số hồ sơ sinh ra sau khi thu bản cứng');
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
        Schema::table('mission_sxtns', function (Blueprint $table) {
            if (Schema::hasColumn('mission_sxtns', 'key')) {
                $table->dropColumn('key');
            }
            if (Schema::hasColumn('mission_sxtns', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
}
