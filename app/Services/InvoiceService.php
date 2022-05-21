<?php


namespace App\Services;

use App\Exceptions\ValidationException;
use App\Mail\InvoiceCreated;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InvoiceService
{
    public function __construct(Invoice $invoice)
    {
         $this->invoice = $invoice;
    }

    public function create(Booking $booking, $data)
    {
        if (auth()->user()->role !== 'admin') {
            throw new AuthorizationException(
                'This action is unauthorized.',
                403
            );
        }

        $validator = Validator::make($data, [
            'booking_id' => ['exists:bookings,id'],
            'amount' => ['required', 'numeric'],
            'reference_id' => ['required'],
            'hash' => ['required'],
            'gcash_checkout_url' => ['required'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $requestLog = $data['payment_request_log'] ?? [];

        $invoice = Invoice::create([
            'booking_id' => $booking->id,
            'amount' => $data['amount'],
            'reference_id' => $data['reference_id'],
            'hash' => $data['hash'],
            'gcash_checkout_url' => $data['gcash_checkout_url'],
            'payment_request_log' => json_encode($requestLog),
        ]);

        $invoice->save();

        $booking = Booking::find($booking->id);

        // $adminsEmail = User::where('role', 'admin')->get()->pluck('email');

        Mail::to($booking->email)->queue(
            new InvoiceCreated($booking)
        );

        return $invoice;
    }

    public function createGcashPaymentRequest(Booking $booking, $data)
    {

        $gcashUrl = config('gcash.api_base_url');

        $customerFullname = "{$booking->first_name} {$booking->last_name}";


        $response = Http::asForm()->post($gcashUrl, [
            'x-public-key' => config('gcash.public_key'),
            'amount' => 10,//$data['amount'],
            'expiry' => $data['link_expiry'] ?? config('gcash.link_expiry'),
            'description' => 'Payment for JBS Land Surveying Services',
            'customername' => $customerFullname,
            'customermobile' => $booking->phone_no,
            'customeremail' => $booking->email,
            'webhooksuccessurl' => $data['gcash_webhook_success_url'] ?? config('gcash.webhooksuccessurl'),
            'webhookfailurl' => $data['gcash_webhook_fail_url'] ?? config('gcash.webhookfailurl')
        ]);

        if ($response->ok()) {
            return $response->json();
        } else {
            throw new ValidationException([
                'gcash_payment_request' => [
                    'GCash Payment Request failed'
                ],
            ]);
        }

        return [];
    }
}