<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class BookingCancelled   extends Mailable
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

        $addressOfSurveyLand = implode(", ", [
            $this->booking->client_street,
            $this->booking->client_city,
            $this->booking->client_region,
            $this->booking->client_postal_code
        ]);

        $requirements = [];
        foreach (json_decode($this->booking->requirements, true) as $req => $value) {
            if ($value) {
                $reqReplaced = Str::replace("_", " ", $req);
                $reqReplaced = Str::ucfirst($reqReplaced);
                $requirements[] = $reqReplaced;
            }
        }

        $reqs = implode(", ", $requirements);

        return $this->subject('Booking Cancelled')
            ->view('booking-cancelled')
            ->with([
                'booking' => $this->booking,
                'user' => $this->user ,
                'bookingSchedule' => $bookingSchedule,
                'addressOfSurveyLand' => $addressOfSurveyLand,
                'requirements' => $reqs,
            ]);
    }
}
