<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscountService;

class ProductController extends Controller
{
    public function index()
    {
        return view('discount.form');
    }

    public function calculate(Request $request, DiscountService $discountService)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $result = $discountService->calculateDiscount(
            $request->rate,
            $request->percentage
        );

        return view('discount.form', compact('result'));
    }
}
