<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeColumnToGroupCouncilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_councils', function (Blueprint $table) {
            if (!Schema::hasColumn('group_councils', 'type')) {
                $table->integer('type')->comment('loại của nhóm hội đồng (đánh giá, thuyết minh ..., lấy value từ OptionValues')->nullable();
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
        Schema::table('group_councils', function (Blueprint $table) {
            if (Schema::hasColumn('group_councils', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
}
