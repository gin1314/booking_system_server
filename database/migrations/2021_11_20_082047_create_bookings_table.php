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
            $table->timestamps();
            $table
                ->enum('survey_type', ['resurvey', 'sub_divide', 'for_titling'])
                ->nullable();
            $table
                ->enum('status', ['pending', 'completed'])
                ->default('pending');
            $table->dateTime('schedule_date');
            $table->string('land_location')->nullable();
            $table->string('appoinment_notes');

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
