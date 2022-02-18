<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

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

    public function getAll()
    {
        $timeSlots = $this->userService->getAll();

        return fractal($timeSlots, new UserTransformer)->respond();
    }
}
