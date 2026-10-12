<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
   
  public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => ['required', 'exists:products,id'],
                'reviewer_name' => ['nullable', 'string', 'max:255'],
                'customer_name' => ['nullable', 'string', 'max:255'],
                'rating' => ['required', 'integer', 'min:1', 'max:5'],
                'comment' => ['required', 'string', 'max:1000'],
            ]);

            $reviewerName = trim($validated['reviewer_name'] ?? $validated['customer_name'] ?? '');
            if ($reviewerName === '' && $request->user()) {
                $reviewerName = $request->user()->name;
            }
            if ($reviewerName === '') {
                $reviewerName = 'Mteja / Customer';
            }

            $review = Review::create([
                'product_id' => $validated['product_id'],
                'user_id' => $request->user()?->id,
                'reviewer_name' => $reviewerName,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Maoni yako yametumwa na kuhifadhiwa kwa mafanikio!',
                'data' => [
                    'id' => $review->id,
                    'reviewer_name' => $review->reviewer_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at?->format('d M Y') ?? 'Hivi sasa',
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tafadhali jaza nafasi zote kwa usahihi.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Kulitokea tatizo wakati wa kuhifadhi maoni. Tafadhali jaribu tena.',
            ], 500);
        }
    }
    
    public function fetchReviews(Request $request, $productId)
    {
        try {
            $product = Product::findOrFail($productId);

            $reviews = Review::where('product_id', $product->id)
                ->latest()
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $reviews->items(),
                'current_page' => $reviews->currentPage(),
                'has_more' => $reviews->hasMorePages(),
                'total' => $reviews->total(),
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Imeshindikana kupata maoni. Tafadhali jaribu tena.',
            ], 500);
        }
    }
}
