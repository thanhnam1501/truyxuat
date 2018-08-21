<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminIdDeadlineNoteToUserHandleFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_handle_files', function (Blueprint $table) {
            if (!Schema::hasColumn('user_handle_files', 'admin_id')) {
                # code...
                $table->tinyInteger('admin_id')->nullable();
            }

            if (!Schema::hasColumn('user_handle_files', 'deadline')) {
                # code...
                $table->timestamps('deadline')->nullable();
            }

            if (!Schema::hasColumn('user_handle_files', 'note')) {
                # code...
                $table->string('note')->nullable();
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
        Schema::table('user_handle_files', function (Blueprint $table) {
            //
        });
    }
}
