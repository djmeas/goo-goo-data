<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaretakerInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caretaker_invites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->integer('child_id');
            $table->string('role');
            $table->tinyInteger('is_admin');
            $table->tinyInteger('full_access');
            $table->tinyInteger('has_accepted')->default(0);
            $table->dateTime('accepted_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caretaker_invites');
    }
}
