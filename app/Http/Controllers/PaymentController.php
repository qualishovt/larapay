<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGatewayContract;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, PaymentGatewayContract $paymentGateway)
    {
        try {
            $inputs = $paymentGateway->getInputs($request);

            $payment = Payment::firstWhere(
                [
                    'gateway' =>  $paymentGateway->getName(),
                    'gateway_payment_id' =>  $inputs['gateway_payment_id']
                ]
            );
            if ($payment) {
                $payment->status = $inputs['status'];
                $payment->save();
                return response()->json(['message' => __('Successful update')]);
            } else {
                Payment::create(
                    [
                        'gateway' =>  $paymentGateway->getName(),
                        'gateway_payment_id' =>  $inputs['gateway_payment_id'],
                        'order_id' => rand(0, 100000),
                        'status' => $inputs['status'],
                        'amount' => $inputs['amount'],
                        'amount_paid' => $inputs['amount_paid'],
                        'input_data' => $inputs['input_data'],
                    ]
                );
                return response()->json(['message' => __('Successful creation')]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
