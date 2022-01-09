<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     * @var Booking
     */
    protected $booking;

    /**
     *
     * @var User
     */
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, User $user)
    {
        $this->booking = $booking;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $bookingSchedule =  (new Carbon($this->booking->schedule_date))->format('F j, Y');

        return $this->subject('Booking Complete')
            ->view('booking-complete')
            ->with([
                'booking' => $this->booking,
                'user' => $this->user,
                'bookingSchedule' => $bookingSchedule,
            ]);
    }
}
