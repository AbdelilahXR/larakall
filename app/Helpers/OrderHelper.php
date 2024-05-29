<?php

namespace App\Helpers;
use Illuminate\Support\Str;

class OrderHelper
{
    public static function formatPhoneNumber($phone)
    {
        if (empty($phone)) {
            return null;
        }

        if (strlen($phone) < 10 && preg_match('/^[5-7]/', $phone)) {
            $phone = '0' . $phone;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^(\+|212)/', '0', $phone);
        return $phone;
    }

    public static function generateReference()
    {
        $today = date('j');
        $month = date('n');
        $year = date('y');
        $reference = 'O-' . $year . $month . $today . strtoupper(Str::random(4));

        return $reference;
    }
}