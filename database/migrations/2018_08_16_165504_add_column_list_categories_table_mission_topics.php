<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnListCategoriesTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics', 'list_categories')) {
                $table->string('list_categories')->nullable()->comment('Quyết định danh mục nhiệm vụ được thực hiện');
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
        Schema::table('mission_topics', function (Blueprint $table) {
            if (Schema::hasColumn('mission_topics', 'list_categories')) {
                $table->dropColumn('list_categories');
            }
        });
    }
}
