<?php

namespace App\Http\Controllers\Admin\Master;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

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
        return view('admin.master.product.index', compact('products', 'category'));
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
                'gambar' => 'mimes:png,jpg'
            ]);
            $product = Product::create($validated);
            $id = $product->id;
            $product->uploadGambar($validated['gambar']);
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
        //
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
                'category_id' => 'required|integer',
                'desc' => 'string',
                'gambar' => 'mimes:png,jpg'
            ]);
            $gambar = $validated['gambar'];
            unset($validated['gambar']);
            $product->update($validated);
            if (!empty($gambar)) {
                $product->uploadGambar($gambar);
            }
            return redirect()->back()->withSuccess("Kategori telah diperbarui!");
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
