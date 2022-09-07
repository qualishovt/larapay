<?php

namespace App\Billing;

use Illuminate\Http\Request;

interface PaymentGatewayContract
{
    public function getName();

    public function getValidationRules();

    public function validateSignature(Request $request);

    public function getInputs(Request $request);
}
