<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnGenderTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }            
            if (Schema::hasColumn('users', 'birthday')) {
                $table->dropColumn('birthday');
            }            
            if (Schema::hasColumn('users', 'mobile')) {
                $table->dropColumn('mobile');
            }            
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
