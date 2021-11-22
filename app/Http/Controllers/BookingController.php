<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingService;
use App\Transformers\BookingTransformer;
use Illuminate\Http\Request;

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
        return fractal($booking, new BookingTransformer);
    }

    public function create()
    {
        $booking = $this->bookingService->create();

        return fractal($booking, new BookingTransformer)->respond();
    }
}
