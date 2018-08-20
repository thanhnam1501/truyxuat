<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMobileTableCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'mobile')) {
                $table->string('mobile',50)->nullable()->comment('Số điện thoại');
            }
            if (!Schema::hasColumn('companies', 'representative')) {
                $table->string('representative',50)->nullable()->comment('Người liên hệ');
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
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'mobile')) {
                $table->dropColumn('mobile');
            }
            if (Schema::hasColumn('companies', 'representative')) {
                $table->dropColumn('representative');
            }
        });
    }
}
