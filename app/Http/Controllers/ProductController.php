<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display product catalog / home page.
     */
    public function index(Request $request): View
    {
        $categories = Category::withCount('products')->get();
        $query = Product::with('category')->where('in_stock', true);

        // Filter by category
        $activeCategory = $request->query('category', 'all');
        if ($activeCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($activeCategory) {
                $q->where('slug', $activeCategory);
            });
        }

        // Search
        $search = $request->query('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        // Sorting
        $activeSort = $request->query('sort', 'populares');
        match ($activeSort) {
            'menor-precio' => $query->orderBy('price', 'asc'),
            'mayor-precio' => $query->orderBy('price', 'desc'),
            default => $query->orderBy('rating', 'desc')->orderBy('reviews_count', 'desc'),
        };

        $products = $query->get();

        return view('home', compact('products', 'categories', 'activeCategory', 'activeSort', 'search'));
    }

    /**
     * Display a specific product detail page.
     */
    public function show(string $slug): View
    {
        $product = Product::with(['category', 'variants', 'images'])->where('slug', $slug)->firstOrFail();

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->limit(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('id', '!=', $product->id)->limit(4)->get();
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
