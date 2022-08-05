<?php

// namespace App\Services;

// use Illuminate\Support\Facades\Http;

// class BankService
// {
//     public function validateAccount($account_number, $bank_code)
//     {
//         $payload = ["Account" => $account_number, "BankCode" => $bank_code];
//         try {
//             $response = Http::withHeaders([
//                 'Content-Type' => 'application/json',
//                 'Accept' => 'application/json',
//                 'hash' => $hash,
//             ])->post($url, $payload)->json();

//             if (!$response['success']) {
//                 $balance = "Balance unavailable.";
//                 return $balance;
//             }
//             $balance = $response['data'];
//             return $balance;
//         } catch (Exception $e) {
//             throw new ApiCallException($e->getMessage, 400);
//         }
//     }
// }
