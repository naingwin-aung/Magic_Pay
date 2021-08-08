<?php
namespace App\Helper;

use App\Models\Wallet;

class AccountNumberGenerate 
{
    public static function accountNumber()
    {
        $number = mt_rand(1000000000000000, 9999999999999999);

        if(Wallet::where('account_number', $number)->exists()) {
            return self::accountNumber();
        }

        return $number;
    }
}