<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('position_councils', function (Blueprint $table) {
            if (!Schema::hasColumn('position_councils', 'name')) {
                $table->string('name', 255);
            }
            if (!Schema::hasColumn('position_councils', 'status')) {
                $table->tinyInteger('status')->default(1);
            }
            if (!Schema::hasColumn('position_councils', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('position_councils', 'deleted_at')) {
                $table->text('deleted_at')->nullable();
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
        Schema::table('position_councils', function (Blueprint $table) {
            if (Schema::hasColumn('position_councils', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('position_councils', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('position_councils', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('position_councils', 'deleted_at')) {
                $table->text('deleted_at');
            }
        });
    }
}
