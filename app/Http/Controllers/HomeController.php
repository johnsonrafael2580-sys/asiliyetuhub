<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
      
        $query = Product::with('artisan');

      
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('artisan', function($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

       
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

       
        if ($request->input('sort') === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->input('sort') === 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($request->input('sort') === 'popular') {
            $query->latest(); // Replace with custom popularity metric if applicable
        } else {
            $query->latest(); // Default: Newest arrivals
        }

       
        $products = $query->paginate(12)->withQueryString();

        return view('welcome', compact('products'));
    }
}
