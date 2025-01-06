<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::all();
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        return view('products.show', compact('product'));
    }
}
