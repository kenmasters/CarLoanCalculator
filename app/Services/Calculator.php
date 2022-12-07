<?php namespace App\Services;

class Calculator {

     /**
     * Simple Interest
     * I = P x R x T
     */
    public function calculate($amount, $rate, $term): float {
        return $amount * $rate * $term;
    }
}
