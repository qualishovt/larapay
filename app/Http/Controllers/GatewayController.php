<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class GatewayController extends Controller
{

    public function gateway1()
    {
        $merchant_id  = 6;
        $merchant_key = 'KaTf5tZYHx4v7pgZ';

        $statuses = ['new', 'pending', 'completed', 'expired', 'rejected'];
        $amount = rand(1000, 100000);

        $data = [
            'merchant_id' => $merchant_id,
            'payment_id' => rand(1, 1000),
            'status' => $statuses[array_rand($statuses)],
            'amount' => $amount,
            'amount_paid' => $amount,
            'timestamp' => time()
        ];

        ksort($data);

        $data['sign'] = hash('sha256', implode(':', $data) . $merchant_key);

        return view('gateway1', $data);
    }

    public function gateway2()
    {
        $app_id  = 816;
        $app_key = 'rTaasVHeteGbhwBx';

        $statuses = ['created', 'inprogress', 'paid', 'expired', 'rejected'];
        $amount = rand(1000, 100000);

        $data = [
            'project' => $app_id,
            'invoice' => rand(1, 1000),
            'status' => $statuses[array_rand($statuses)],
            'amount' => $amount,
            'amount_paid' => $amount,
            'rand' => Str::random()
        ];

        ksort($data);

        $data['sign'] = md5(implode('.', $data) . $app_key);

        return view('gateway2', $data);
    }
}
