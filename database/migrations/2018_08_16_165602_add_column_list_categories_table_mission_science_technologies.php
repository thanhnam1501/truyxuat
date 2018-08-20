<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnListCategoriesTableMissionScienceTechnologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_science_technologies', 'list_categories')) {
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
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            if (Schema::hasColumn('mission_science_technologies', 'list_categories')) {
                $table->dropColumn('list_categories');
            }

        });
    }
}
