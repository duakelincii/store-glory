<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $data['cart'] = Cart::where('user_id',Auth::user()->id)->get();
        $data['setting'] = Setting::first();
        return view('user.transaction.cart',$data);
    }

    public function modal($id)
    {
        $item = Product::findOrFail($id);
        return view('components.cart',compact('item'));
    }

    public function update(Request $request , $id)
    {
        $prodcut = Product::findOrFail($id);
        $check = Cart::where('product_id',$prodcut->id)->first();
        if(!empty($check->id) == $prodcut->id ){
            return redirect()->back()->with("errors", "Product Sudah Ada dikeranjang");
        }else{
            $cart = Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $prodcut->id,
                'qty' => $request->qty
            ]);
        }
        return redirect(route('app.cart'));
    }

    public  function quantity(Request $request){
        DB::table('carts')->where('product_id',$request->product_id)->update(
        ['qty'=> $request->quantity]
        );
        return response()->json([$request->all(),200]);
    }

    public function delete($id)
    {
        $item = Cart::where('product_id',$id)->delete();
        return redirect()->back()->withSuccess("Product telah Berhasil Dihapus!");
    }
}
