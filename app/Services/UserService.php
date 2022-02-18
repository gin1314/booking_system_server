<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{
    public function __construct()
    {
    }

    public function create()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'name' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'email'],
            'phone_no' => ['required'],
            'role' => ['required'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        try {
            // $d = json_encode($data['requirements']);
            unset($data['requirements']);
            $user = User::create($data);
            $user->password = Hash::make($data['password']);
            // $user->uuid = Str::uuid();
            $user->save();
        } catch (QueryException $e) {
            throw new ValidationException($e->getMessage());
        }

        return $user;
    }

    public function getAll()
    {
        $bookings = QueryBuilder::for(User::class)
            ->allowedSorts(['schedule_date', 'id', 'created_at', 'updated_at'])
            ->allowedFilters(['user_id'])
            ->paginate(request()->get('per_page'));

        return $bookings;
    }
}
