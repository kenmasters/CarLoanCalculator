<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Calculator;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    const ANNUAL_INTEREST_RATE = 0.06; // Annual interest 6%
    const LOAN_TERM_IN_YEARS = 5;       // Length of loan (5 YEARS)
    const MONTHS_IN_YEAR = 12;

    public function calculate(Request $request, Calculator $calculator)
    {
        // validate that `amount` must not be numeric and greater than zero.
        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);

        $loanAmount = $request->input("amount");

        $interestCost = $calculator->calculate($loanAmount, self::ANNUAL_INTEREST_RATE, self::LOAN_TERM_IN_YEARS);

        $monthlyRepayment = ($loanAmount + $interestCost) / (self::LOAN_TERM_IN_YEARS * self::MONTHS_IN_YEAR);

        $response = [
            "principal" => number_format($loanAmount, 2, '.', ','),
            "interest" => number_format($interestCost, 2, '.', ','),
            "rate" => self::ANNUAL_INTEREST_RATE * 100,
            "termInYear" => self::LOAN_TERM_IN_YEARS,
            "termInMonth" => self::LOAN_TERM_IN_YEARS * self::MONTHS_IN_YEAR,
            "monthlyRepayment" => number_format($monthlyRepayment, 2, '.', ','),
        ];

        return response()->json($response);
    }

    public function compounding(Request $request)
    {
        // validate that $principal must not be numeric and greater than zero.
        // $request->validate([
        //     'amount' => 'required|numeric|gt:0',
        // ]);

        // Formula
        /**
         * A = P * ((r * pow(1 + r, n)) / (pow(1+r, n) - 1))
         */
        // Payment Frequency:: Monthly
        // Total Interest Due:
        $principal = $request->input("amount");
        $P = $principal; // Loan Amount:
        $r = .06 / 12; // 6% is the Annual Interest Rate
        $n = 5 * 12;
        $A  = $P * (($r * pow(1+$r, $n)) / (pow(1+$r, $n) - 1)); // Periodic Payment (per month)
        $result_of_first_month_interest_payment = 10000 * $r;

        $response = [
            'periodicPayment' => number_format($A, 2),
            'result_of_first_month_interest_payment' => $A - $result_of_first_month_interest_payment
        ];

        return response()->json($response);
    }
}
