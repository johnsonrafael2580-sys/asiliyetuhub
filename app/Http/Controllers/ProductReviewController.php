<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; 
use App\Models\Product;

class ProductReviewController extends Controller
{
  
    public function store(Request $request, $productId)
    {
      
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        
        $product = Product::findOrFail($productId);

       
        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(), 
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

       
        return back()->with('success', 'Asante! Maoni yako yamewasilishwa kwa mafanikio.');
    }
}
