<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Companies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('scientists')) {
            Schema::rename('scientists', 'companies');
        }
        if (Schema::hasTable('companies')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->renameColumn('company_name', 'organization_id');
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
