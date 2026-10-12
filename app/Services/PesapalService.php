<?php

use Illuminate\Support\Facades\Http;

$baseUrl = config('services.pesapal.base_url');


$authResponse = Http::withoutVerifying()
    ->post("{$baseUrl}/Auth/RequestToken", [
        'consumer_key' => config('services.pesapal.consumer_key'),
        'consumer_secret' => config('services.pesapal.consumer_secret'),
    ]);

$token = $authResponse->json('token');


$ipnResponse = Http::withoutVerifying()
    ->withToken($token)
    ->post("{$baseUrl}/URLSetup/RegisterIPN", [
        'url' => config('services.pesapal.callback_url'),
        'ipn_notification_type' => 'GET', // Must be uppercase 'GET' or 'POST'
    ]);

$ipnId = $ipnResponse->json('ipn_id');
