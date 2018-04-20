<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('company', 100);
            $table->timestamps();
            $table->dateTime('clock_in_time');
            $table->dateTime('clock_out_time')->nullable();
            $table->integer('duration_in_minutes')->nullable();
            $table->string('note', 140)->nullable();
            $table->float('amount_to_pay', 5, 2)->nullable();
            $table->boolean('has_been_paid');
            $table->boolean('is_deleted');
            $table->string('reason_for_deletion', 140)->nullable(); // Make this work with the current system.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
