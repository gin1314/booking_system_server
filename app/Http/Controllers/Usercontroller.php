<?php

namespace App\Http\Controllers;

use App\Mail\SurveyProcessing;
use App\Mail\SurveyReceiving;
use App\Models\Booking;
use App\Models\User;
use App\Services\UserService;
use App\Transformers\BookingTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Usercontroller extends Controller
{
    /**
     *
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create()
    {
        $user = $this->userService->create();

        return fractal($user, new UserTransformer())->respond();
    }

    public function update(User $user)
    {
        $user = $this->userService->update($user);

        return fractal($user, new UserTransformer())->respond();
    }

    public function getAll(Request $request)
    {
        $timeSlots = $this->userService->getAll($request);

        return fractal($timeSlots, new UserTransformer)->respond();
    }

    public function delete(User $user)
    {
        $user = $this->userService->delete($user);

        return fractal($user, new UserTransformer())->respond();
    }

    public function sendEmailSurveyProcessing(Booking $booking)
    {
        Mail::to($booking->email)->queue(
            new SurveyProcessing($booking)
        );

        return fractal($booking, new BookingTransformer)->respond();
    }

    public function sendEmailSurveyReceiving(Booking $booking)
    {
        Mail::to($booking->email)->queue(
            new SurveyReceiving($booking)
        );

        return fractal($booking, new BookingTransformer)->respond();
    }
}
