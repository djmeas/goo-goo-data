<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCaretakersTableAddAdminField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caretakers', function (Blueprint $table) {
            $table->tinyInteger('is_admin')->after('child_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caretakers', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
