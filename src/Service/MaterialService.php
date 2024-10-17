<?php

namespace App\Service;

class MaterialService
{
    public static function calculateTTC(string $priceHT, string $tva): float
    {
        return round(floatval($priceHT) * (1 + floatval($tva)), 2);
    }
}
