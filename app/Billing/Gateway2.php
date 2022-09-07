<?php

namespace App\Billing;

use Illuminate\Http\Request;

class Gateway2 implements PaymentGatewayContract
{
    const APP_ID = 816;

    const APP_KEY = 'rTaasVHeteGbhwBx';

    private $name;

    public function __construct()
    {
        $this->name = 'Gateway 2';
    }

    public function getName()
    {
        return $this->name;
    }

    public function validateSignature(Request $request)
    {
        $inputs = [];
        $inputs['project'] = $request->post('project');
        $inputs['invoice'] = $request->post('invoice');
        $inputs['status'] = $request->post('status');
        $inputs['amount'] = $request->post('amount');
        $inputs['amount_paid'] = $request->post('amount_paid');
        $inputs['rand'] = $request->post('rand');

        ksort($inputs);

        $authorization = $request->header('Authorization');
        if (!$authorization) {
            abort(401);
        }
        $sign = md5(implode('.', $inputs) . self::APP_KEY);

        if ($authorization == $sign) {
            return true;
        }

        return false;
    }

    public function getValidationRules()
    {
        return [
            "project" => "required|integer",
            "invoice" => "required|integer",
            "status" => "required|string",
            "amount" => "required|integer",
            "amount_paid" => "required|integer",
            "rand" => "required",
        ];
    }

    // Adapts inputs
    public function getInputs(Request $request)
    {
        $inputs = [];

        $inputs['gateway_payment_id'] = $request->post('invoice');
        $inputs['status'] = $request->post('status');
        $inputs['amount'] = $request->post('amount');
        $inputs['amount_paid'] = $request->post('amount_paid');
        $inputs['input_data'] = json_encode($request->post());

        return $inputs;
    }
}
