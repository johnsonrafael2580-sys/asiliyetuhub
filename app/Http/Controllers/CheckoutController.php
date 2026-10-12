<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    
    public function index(): RedirectResponse
    {
        return redirect()->route('cart.index');
    }
}
