<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTaxCodeTableOrganizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {

            if (Schema::hasColumn('organizations', 'tax_code')) {
                $table->string('tax_code',15)->nullable()->unique()->comment('mã số thuế')->change();
            }
            if (Schema::hasColumn('organizations', 'name')) {
                $table->string('name')->nullable()->change();
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
        Schema::table('organizations', function (Blueprint $table) {

            if (Schema::hasColumn('organizations', 'tax_code')) {
                Schema::dropColumn('tax_code');
                $table->string('tax_code',15)->unique()->comment('mã số thuế')->change();
            }
            if (Schema::hasColumn('organizations', 'name')) {
                Schema::dropColumn('name');
                $table->string('name')->change();
            }
        });
    }
}
