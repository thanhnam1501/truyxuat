<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameCompanyIdColumnApplyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apply_logs', function (Blueprint $table) {
            if (Schema::hasColumn('apply_logs', 'company_id')) {
              $table->renameColumn('company_id', 'profile_id');
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
        Schema::table('apply_logs', function (Blueprint $table) {
          if (Schema::hasColumn('apply_logs', 'profile_id')) {
            $table->renameColumn('profile_id', 'company_id');
          }
        });
    }
}
