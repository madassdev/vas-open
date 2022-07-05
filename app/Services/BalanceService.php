<?php

namespace App\Services;

use App\Exceptions\ApiCallException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;

class BalanceService
{

    private $implementation;
    private $user;
    private $url;

    public function __construct($user)
    {
        $this->user = $user;
    }
    public function getBalance(User $user)
    {
        // git remote add live-heroku  https://git.heroku.com/vasreseller-admin-live.git

        $account = "1020000589";
        $hash = config('api.balanceTestApi.hash');
        $url = config('api.balanceTestApi.url');
        $payload = ["Account" => $account];
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'hash' => $hash,
            ])->post($url, $payload)->json();

            if (!$response['success']) {
                $balance = "Balance unavailable.";
                return $balance;
            }
            $balance = $response['data'];
            return $balance;
        } catch (Exception $e) {
            throw new ApiCallException($e->getMessage, 400);
        }
    }
}
