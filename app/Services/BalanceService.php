<?php
namespace App\Services;

use App\Models\User;

class BalanceService{

    private $implementation;

    public static function getBalance(User $user)
    {
        $balance = "Work in progress";
        return $balance;
    }
}