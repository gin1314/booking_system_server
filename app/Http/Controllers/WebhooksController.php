<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class WebhooksController extends Controller
{
    public function gcashSuccess()
    {
        $data = request()->all();

        Log::info('gcash success payment');
        Log::info($data);

        return response()->json(['ok']);
    }

    public function gcashFail()
    {
        $data = request()->all();

        Log::info('gcash failed payment');
        Log::info($data);
    }
}
