<?php

namespace App\Mail;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     * @var Booking
     */
    protected $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $bookingSchedule =  (new Carbon($this->booking->schedule_date))->format('F j, Y');
        $invoiceNo = Str::padLeft($this->booking->invoice->id, 10, '0');
        $amount = $this->booking->invoice->amount;
        $dueDate =  (new Carbon($this->booking->invoice->created_at))->format('F j, Y');
        $metadata = json_decode($this->booking->metadata, true);

        return $this->subject("Payment for invoice #{$invoiceNo} is due today")
            ->view('invoice-created')
            ->with([
                'booking' => $this->booking,
                'bookingSchedule' => $bookingSchedule,
                'gcashLink' => $this->booking->invoice->gcash_checkout_url,
                'invoiceNo' => $invoiceNo,
                'amount' => $amount,
                'dueDate' => $dueDate,
                'metadata' => $metadata
            ]);
    }
}
