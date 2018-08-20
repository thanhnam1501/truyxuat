<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnGenderTableScientists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scientists', function (Blueprint $table) {
            if (Schema::hasColumn('scientists', 'gender')) {
                $table->dropColumn('gender');
            }            
            if (Schema::hasColumn('scientists', 'birthday')) {
                $table->dropColumn('birthday');
            }            
            if (Schema::hasColumn('scientists', 'mobile')) {
                $table->dropColumn('mobile');
            }            
            if (Schema::hasColumn('scientists', 'address')) {
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
        Schema::table('scientists', function (Blueprint $table) {
            //
        });
    }
}
