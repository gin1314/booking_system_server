<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccess;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhooksController extends Controller
{
    public function gcashSuccess()
    {
        $data = request()->all();

        Log::info('gcash success payment');
        Log::info($data);

        $invoice = Invoice::where('hash', $data['request_id'])->first();

        $invoice->status = 'paid';

        $invoice->payment_date = date('Y-m-d H:i:s');

        $invoice->webhook_log = json_encode($data);

        $invoice->save();
        $booking = Booking::find($invoice->booking_id);

        Mail::to($booking->email)->queue(
            new PaymentSuccess($booking)
        );

        return response()->json(['ok']);
    }

    public function gcashFail()
    {
        $data = request()->all();

        Log::info('gcash failed payment');
        Log::info($data);

        $invoice = Invoice::where('hash', $data['request_id'])->first();

        $invoice->status = 'failed';

        $invoice->webhook_log = json_encode($data);

        $invoice->save();

        return response()->json(['ok']);
    }
}
