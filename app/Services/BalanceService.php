<?php

namespace App\Services;

use App\Exceptions\ApiCallException;
use App\Models\Business;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;

class BalanceService
{

    private $implementation;
    private $user;
    private $url;

    public function __construct($user = null)
    {
        $this->user = $user;
    }
    public function getBalance(string $client_id)
    {
        // git remote add live-heroku  https://git.heroku.com/vasreseller-admin-live.git

        $account = $client_id;
        $hash = config('api.balanceApi.hash');
        $url = config('api.balanceApi.url');
        // $payload = ["Account" => $account];
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'hash' => $hash,
            ])->post($url.'/'. $account)->json();

            if (!$response['success']) {
                $balance = "Balance unavailable.";
                return $balance;
            }
            $balance = $response['data'];
            return $balance;
        } catch (Exception $e) {

            // throw new ApiCallException($e->getMessage(), 400);
            $balance = "Balance unavailable.". $e->getMessage();
            return $balance;
        }
    }

    public function validateAccount($account_number, $bank_code)
    {
        // $account = "1020000589";
        $hash = config('api.balanceTestApi.hash');
        $url = config('api.bankAccountVerification.url');
        $payload = ["Account" => $account_number, "BankCode" => $bank_code];
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'hash' => $hash,
            ])->post($url, $payload)->json();

            return $response;
        } catch (Exception $e) {
            throw new ApiCallException($e->getMessage, 400);
        }
    }

    public function validateOtp($account_number, $otp, $reference_id)
    {
        $account = "1020000589";
        $hash = config('api.balanceTestApi.hash');
        $url = config('api.bankOtpVerification.url');
        $payload = ["Account" => $account_number, "Otp" => $otp, "ReferenceId" => $reference_id];
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'hash' => $hash,
            ])->post($url, $payload)->json();

            return $response;
        } catch (Exception $e) {
            throw new ApiCallException($e->getMessage, 400);
        }
    }

    public function registerVasCustomer(Business $business)
    {
        $hash = config('api.vasCustomerRegistration.hash');
        $url = config('api.vasCustomerRegistration.url');
        // return $url;
        $payload = [
            "Name" => $business->name,
            "Email" => $business->email,
            "PhoneNumber" => $business->phone,
            "IsBank" => (bool)@$business->is_bank,
            "Address" => $business->address,
            "AccountNumber" => $business->account_number,
            "AccountName" => $business->account_name,
        ];
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'hash' => hash('sha256',$hash),
            ])->post($url, $payload)->json();

            return $response;
        } catch (Exception $e) {
            throw new ApiCallException($e->getMessage, 400, $e->getTrace());
        }
    }
}
