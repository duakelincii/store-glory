<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\FutsalField;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $banners = Banner::all();
        $setting = Setting::first();
        return view('user.dashboard', compact('products','banners','setting'));
    }
}
