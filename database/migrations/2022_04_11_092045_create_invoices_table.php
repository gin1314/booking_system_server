<?php

use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->float('amount', 8, 2);
            $table->string('reference_id');
            $table->string('hash')->nullable();
            $table->string('gcash_checkout_url')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->enum('status', Invoice::STATUS)->default('pending');
            $table->enum('gateway_name', ['gcash', 'paymaya'])->default('gcash');
            $table->json('webhook_log')->default("{}");
            $table->json('payment_request_log')->default("{}");
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
        Schema::dropIfExists('invoices');
    }
}
