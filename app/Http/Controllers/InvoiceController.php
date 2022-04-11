<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationException;
use App\Models\Booking;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Transformers\InvoiceTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Spatie\Fractalistic\Exceptions\InvalidTransformation;
use Spatie\Fractalistic\Exceptions\NoTransformerSpecified;
use InvalidArgumentException;
use UnexpectedValueException;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     *
     * @param Booking $booking
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws BadRequestException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws ValidationException
     * @throws InvalidTransformation
     * @throws NoTransformerSpecified
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function create(Booking $booking)
    {
        $data['amount'] = request()->get('amount');
        $data['expiry'] = request()->get('expiry');

        $gcashPaymentRequestResponse = $this->invoiceService->createGcashPaymentRequest($booking, $data);

        $serviceData['amount'] = $data['amount'];
        $serviceData['payment_request_log'] = $gcashPaymentRequestResponse;
        $serviceData['gcash_checkout_url'] = Arr::get($gcashPaymentRequestResponse, 'data.checkouturl');
        $serviceData['reference_id'] = Arr::get($gcashPaymentRequestResponse, 'data.code');
        $serviceData['hash'] = Arr::get($gcashPaymentRequestResponse, 'data.hash');

        $invoice = $this->invoiceService->create($booking, $serviceData);

        return fractal($invoice, new InvoiceTransformer())->respond();
    }
}
