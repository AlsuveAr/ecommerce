<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;

class LandingPageController extends Controller
{
    
    public function index() 
    {
    	$products = Product::inRandomOrder()->take(8)->get();

    	return view('web.landing-page', compact('products'));
    }
}
