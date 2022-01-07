<?php

namespace App\ErrorCodes;

class Api
{
    const INVALID_TOKEN = [
        'code' => 100,
        'detail' => 'Invalid Token',
    ];

    const UNAUTHORIZED_ACCESS = [
        'code' => 101,
        'detail' => 'Unauthorized access',
    ];
}
