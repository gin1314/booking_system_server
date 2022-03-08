<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
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

    public function getAll(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            throw new AuthorizationException(
                'This action is unauthorized.',
                403
            );
        }

        $newRequest = $this->getQueryBuilderParams($request, auth()->user());

        $bookings = QueryBuilder::for(User::class, $newRequest)
            ->allowedSorts(['id', 'role', 'name', 'phone_no', 'address', 'email', 'created_at', 'updated_at'])
            ->allowedFilters([AllowedFilter::exact('id'), 'role', 'name', 'phone_no', 'address', 'email'])
            ->paginate(request()->get('per_page'));

        return $bookings;
    }

    public function getQueryBuilderParams(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            // force to only include dock receipts of users' department
            $newFilter = array_merge($request->filter ?? [], [
                'role' => 'engineer'
            ]);
            $request = $request->merge([
                'filter' => $newFilter
            ]);

            return $request;
        }

        return $request;
    }

    public function update(User $user)
    {
        $data = request()->all();
        $validator = Validator::make($data, [
            'name' => ['string'],
            'email' => ['email', 'unique:users,email'],
            'role' => ['string'],
            'address' => ['string'],
            'phone_no' => ['string'],
            'password' => ['confirmed'],
            'password_confirmation' => ['string']
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        foreach ($data as $key => $value) {
            if (in_array($key, ['role', 'password_confirmation', 'password'])) {
                continue;
            }
            $user->{$key} = $value;
        }

        if (isset($data['password']) && $data['password']) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return $user;
    }
}
