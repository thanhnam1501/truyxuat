<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerificationCodeToScientistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scientists', function (Blueprint $table) {
            if (!Schema::hasColumn('scientists', 'verification_code')) {
                $table->string('verification_code')->nullable();
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
