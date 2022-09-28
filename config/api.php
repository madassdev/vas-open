<?php

if(env("APP_ENV") === "production"){

    return [
        'balanceTestApi' => [
            'hash' => env('BALANCE_TEST_API_HASH', '06ef1e0d2b1c02f53f920dc9c1eb79bc6d1d17b5309209f6bf7b0d43fa179283'),
            'url' => env('BALANCE_TEST_API_URL', 'http://196.46.20.114:8003/api/hopebank/balance'),
        ],
    
        'bankAccountVerification' => [
            'url' => env('BANK_ACCOUNT_VERIFICATION_URL', 'http://196.46.20.114:8003/api/hopebank/validateaccount')
        ],
    
        'bankOtpVerification' => [
            'url' => env('BANK_OTP_VERIFICATION_URL', 'http://196.46.20.114:8003/api/hopebank/validateotp')
        ],
    
        'vasCustomerRegistration' => [
            'url' => env('VAS_CUSTOMER_REGISTRATION_URL', 'http://196.46.20.114:8003/api/vasreseller/register'),
            'hash' => env('VAS_CUSTOMER_REGISTRATION_HASH', 'D7CE5CA3-2FE9-4FF1-86DF-1B406F66F6C9')
        ]
    ];

}else{

    return [
        'balanceTestApi' => [
            'hash' => env('BALANCE_TEST_API_HASH', '06ef1e0d2b1c02f53f920dc9c1eb79bc6d1d17b5309209f6bf7b0d43fa179283'),
            'url' => env('BALANCE_TEST_API_URL', 'http://196.46.20.20:8002/api/hopebank/balance'),
        ],
    
        'bankAccountVerification' => [
            'url' => env('BANK_ACCOUNT_VERIFICATION_URL', 'http://196.46.20.20:8002/api/hopebank/validateaccount')
        ],
    
        'bankOtpVerification' => [
            'url' => env('BANK_OTP_VERIFICATION_URL', 'http://196.46.20.20:8002/api/hopebank/validateotp')
        ],
    
        'vasCustomerRegistration' => [
            'url' => env('VAS_CUSTOMER_REGISTRATION_URL', 'http://196.46.20.20:8002/api/vasreseller/register'),
            'hash' => env('VAS_CUSTOMER_REGISTRATION_HASH', 'D7CE5CA3-2FE9-4FF1-86DF-1B406F66F6C9')
        ]
    ];
}
