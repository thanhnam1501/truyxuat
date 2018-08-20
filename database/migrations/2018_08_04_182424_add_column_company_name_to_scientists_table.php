<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCompanyNameToScientistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scientists', function (Blueprint $table) {
            if (!Schema::hasColumn('scientists', 'company_name')) {
                $table->string('company_name')->nullable()->comment('Ten don vi so huu tai khoan nay');
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
