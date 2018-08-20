<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameCompanyPasswordResetsToProfilePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('company_password_resets', function (Blueprint $table) {
        if (Schema::hasTable('company_password_resets')) {
          Schema::rename('company_password_resets', 'profile_password_resets');
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
        Schema::table('company_password_resets', function (Blueprint $table) {
          if (Schema::hasTable('profile_password_resets')) {
            Schema::rename('profile_password_resets', 'company_password_resets');
          }
        });
    }
}
