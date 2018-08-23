<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeColumnContentInEvaluationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_form', function (Blueprint $table) {
            if (Schema::hasColumn('content', 'evaluation_form')) {
                $table->text('content')->nullable()->change();
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
        Schema::table('evaluation_form', function (Blueprint $table) {
            if (Schema::hasColumn('content', 'evaluation_form')) {
                $table->text('content')->change();
            }
        });
    }
}
