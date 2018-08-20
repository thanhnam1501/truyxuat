<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnEmailCompanyToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('companies', function (Blueprint $table) {
        //     $table->renameColumn('email_company', 'email');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('companies', function (Blueprint $table) {
        //     $table->renameColumn('email_company', 'email');
        // });
    }
}
