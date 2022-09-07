<?php

namespace App\Billing;

use Illuminate\Http\Request;

class Gateway1 implements PaymentGatewayContract
{

    const MERCHANT_ID = 6;

    const MERCHANT_KEY = 'KaTf5tZYHx4v7pgZ';

    private $name;

    public function __construct()
    {
        $this->name = 'Gateway 1';
    }

    public function getName()
    {
        return $this->name;
    }

    public function validateSignature(Request $request)
    {
        $inputs = [];
        $inputs['merchant_id'] = $request->post('merchant_id');
        $inputs['payment_id'] = $request->post('payment_id');
        $inputs['status'] = $request->post('status');
        $inputs['amount'] = $request->post('amount');
        $inputs['amount_paid'] = $request->post('amount_paid');
        $inputs['timestamp'] = $request->post('timestamp');

        ksort($inputs);

        $sign = hash('sha256', implode(':', $inputs) . self::MERCHANT_KEY);
        if ($sign == $request->post('sign')) {
            return true;
        }

        return false;
    }

    public function getValidationRules()
    {
        return [
            "merchant_id" => "required|integer",
            "payment_id" => "required|integer",
            "status" => "required|string",
            "amount" => "required|integer",
            "amount_paid" => "required|integer",
            "timestamp" => "required|integer",
            "sign" => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->isSHA256($value)) {
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                },
            ],
        ];
    }

    private function isSHA256($hash)
    {
        if (preg_match("/^([a-f0-9]{64})$/", $hash) == 1) {
            return true;
        }
        return false;
    }

    // Adapts inputs
    public function getInputs(Request $request)
    {
        $inputs = [];

        $inputs['gateway_payment_id'] = $request->post('payment_id');
        $inputs['status'] = $request->post('status');
        $inputs['amount'] = $request->post('amount');
        $inputs['amount_paid'] = $request->post('amount_paid');
        $inputs['input_data'] = json_encode($request->post());

        return $inputs;
    }
}
