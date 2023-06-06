<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index(){
        // Product::factory(5)->create();
        
        $products = Product::all(); // for test we can use all here
    
        return view('products.index',compact('products'));
    }
}
