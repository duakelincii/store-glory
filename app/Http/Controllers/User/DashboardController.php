<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FutsalField;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('user.dashboard', compact('products'));
    }
}
