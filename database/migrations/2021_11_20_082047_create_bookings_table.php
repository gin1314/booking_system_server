<?php

use App\Models\Booking;
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
            $table->uuid('uuid')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('client_street');
            $table->string('client_city');
            $table->string('client_region');
            $table->string('client_postal_code');
            $table->string('land_street');
            $table->string('land_city');
            $table->string('land_region');
            $table->string('land_postal_code');
            // $table->string('address');
            $table->string('phone_no');
            $table->string('email');
            $table->json('requirements')->default("{}");
            $table->enum('survey_type', Booking::SURVEY_TYPES);
            $table
                ->enum('status', ['pending', 'completed'])
                ->default('pending');
            $table->date('schedule_date');
            $table->string('appointment_notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('time_slot_id');
            $table->timestamps();

            $table->index(['schedule_date', 'uuid']);
            $table->unique(['schedule_date', 'time_slot_id']);
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
