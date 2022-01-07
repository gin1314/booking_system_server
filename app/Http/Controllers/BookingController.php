<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Services\BookingService;
use App\Transformers\BookingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     *
     * @var BookingService
     */
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function getBooking(Booking $booking)
    {
        $booking = $this->bookingService->getBooking($booking);
        return fractal($booking, new BookingTransformer());
    }

    public function getAll()
    {
        $bookings = $this->bookingService->getAllBooking();
        return fractal($bookings, new BookingTransformer())->respond();
    }

    public function create()
    {
        $booking = $this->bookingService->create();

        return fractal($booking, new BookingTransformer())->respond();
    }

    public function confirmBooking()
    {
        Mail::to('santosjohnnicolas@gmail.com')
            ->cc('eugene.santos13@gmail.com')
            ->queue(new BookingConfirmed());
    }
}
