<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{

    public function index(){
        // Product::factory(5)->create();
        
        $products = Product::all(); // for test we can use all here
    
        return view('products.index',compact('products'));
    }

    public function create(Request $request) {
        return view('products.create');
    }

    public function store(StoreProductRequest $request) {

        Product::create($request->validated());

        return redirect(route('products.index'));
    }
}
