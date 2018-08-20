<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpirationTimeToRoundCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('round_collections', function (Blueprint $table) {
            if (!Schema::hasColumn('round_collections','expiration_time')) {
                $table->timestamp('expiration_time')->nullable();
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
        Schema::table('round_collections', function (Blueprint $table) {
            if (Schema::hasColumn('round_collections','expiration_time')) {
                $table->dropColumn('expiration_time');
            }
        });
    }
}
