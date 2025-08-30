<?php

namespace App\Services;

class DiscountService
{
     public function calculateDiscount($rate, $percentage)
    {
        if ($percentage < 0 || $percentage > 100) {
            throw new \InvalidArgumentException("Percentage must be between 0 and 100.");
        }

        $discount = ($rate * $percentage) / 100;
        $final = $rate - $discount;

        return [
            'original' => $rate,
            'percentage' => $percentage,
            'discount' => $discount,
            'final' => $final,
        ];
    }
}
