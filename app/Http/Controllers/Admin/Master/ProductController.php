<?php

namespace App\Http\Controllers\Admin\Master;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = request()->q;
        $products = Product::when($q, function ($query) use ($q) {
            return $query->search($q);
        })->orderByDesc("updated_at")->paginate(6);
        $category = Category::latest()->get();
        $setting = Setting::first();
        return view('admin.master.product.index', compact('products', 'category','setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'category_id' => 'required|integer',
                'desc' => 'string',
                'gambar' => 'mimes:png,jpg',
                'harga' => 'required'
            ]);
            if ($request->file('gambar')) {
                $file = $request->file('gambar');
                $extension = $file->getClientOriginalExtension(); // you can also use file name
                $fileName = time().'.'. $extension;
                $file->move(public_path('/uploads/product'), $fileName);
            }
            Product::create([
                'name' => $request->name,
                'gambar' => '/uploads/product/' . $fileName,
                'category_id' => $request->category_id,
                'desc' => $request->desc,
                'harga' => $request->harga
            ]);
            return redirect()->back()->withSuccess("Produk berhasil ditambah!");
        } catch (Exception $th) {
            return redirect()->back()->with("errors", $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $category = Category::all();
        return view('admin.master.product.edit',compact('item','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {

            $validated = $request->validate([
                'name' => 'required|string',
                'category_id' => 'integer',
                'desc' => 'string',
                'gambar' => 'mimes:png,jpg',
                'harga' => 'string'
            ]);

            if ($request->file('gambar')) {
                $file = $request->file('gambar');
                $extension = $file->getClientOriginalExtension(); // you can also use file name
                $fileName = time().'.'. $extension;
                $file->move(public_path('/uploads/product'), $fileName);

                $inputdata = [
                    'name' => $request->name,
                    'gambar' => '/uploads/product/' . $fileName,
                    'category_id' => $request->category_id,
                    'desc' => $request->desc,
                    'harga' => $request->harga
                ];
            }else{
                $inputdata = [
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'desc' => $request->desc,
                    'harga' => $request->harga
                ];
            }
            // dd($inputdata);
            $product->update($inputdata);
            return redirect()->back()->withSuccess("Product telah diperbarui!");
        } catch (Exception $th) {
            return redirect()->back()->with("errors", $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }

    public function json(Product $product)
    {
        return response()->json(['success' => true, 'data' => $product]);
    }
}
