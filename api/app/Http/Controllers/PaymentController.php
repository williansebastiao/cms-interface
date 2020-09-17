<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Requests\PaymentUnlockRequest;
use App\Http\Requests\PaymentRestoreRequest;

class PaymentController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function unlock($id, PaymentUnlockRequest $request)
    {
        return $this->paymentService->unlock($id, $request->all());
    }

    public function restore($id, PaymentRestoreRequest $request)
    {
        return $this->paymentService->restore($id, $request->all());
    }
}
