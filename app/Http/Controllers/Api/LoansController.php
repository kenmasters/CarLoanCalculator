<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    const ANNUAL_INTEREST_RATE = 0.06; // Annual interest 6%
    const LOAN_TERM_IN_YEARS = 5;       // Length of loan (5 YEARS)
    const MONTHS_IN_YEAR = 12;

    public function index()
    {
    }

    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'title' => 'required|max:255',
        //     'description' => 'required'
        // ]);
        // $todo = Todo::create($data);
        // return Response::json($todo);
    }
    public function calculate(Request $request)
    {
        // validate that $principal must not be numeric and greater than zero.
        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);

        $principal = $request->input("amount");

        // I = P x R x T
        $interest = $principal * self::ANNUAL_INTEREST_RATE * self::LOAN_TERM_IN_YEARS;

        $monthlyRepayment = ($principal + $interest) / (self::LOAN_TERM_IN_YEARS * self::MONTHS_IN_YEAR);

        $response = [
            "principal" => number_format($principal, 2, '.', ','),
            "interest" => number_format($interest, 2, '.', ','),
            "rate" => self::ANNUAL_INTEREST_RATE * 100,
            "termInYear" => self::LOAN_TERM_IN_YEARS,
            "termInMonth" => self::LOAN_TERM_IN_YEARS * self::MONTHS_IN_YEAR,
            "monthlyRepayment" => number_format($monthlyRepayment, 2, '.', ','),
        ];

        return response()->json($response);
    }
}
