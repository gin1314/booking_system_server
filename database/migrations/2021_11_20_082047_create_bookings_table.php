<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('full_name');
            $table->string('address');
            $table->string('phone_no');
            $table
                ->enum('survey_type', ['relocation_survey', 'sub_divide', 'for_titling']);
            $table
                ->enum('status', ['pending', 'completed'])
                ->default('pending');
            $table->dateTime('schedule_date');
            $table->string('land_location');
            $table->string('appointment_notes')->nullable();
            $table->timestamps();

            $table->index(['schedule_date', 'land_location']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
