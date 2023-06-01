<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = request()->q;
        $datas = Category::when($q, function ($query) use ($q) {
            return $query->search($q);
        })->orderByDesc("updated_at")->paginate(6);
        $setting = Setting::first();
        return view('admin.master.kategori.index', compact('datas','setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
                'name' => 'required|string'
            ]);
            Category::create($validated);
            return redirect()->back()->withSuccess("Kategori berhasil ditambah!");
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
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string'
            ]);
            $category = Category::findorfail($id);
            $category->update($validated);
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
    public function destroy($id)
    {
        $category = Category::findorfail($id);
        $category->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }

    public function json(Category $kategori)
    {
        return response()->json(['success' => true, 'data' => $kategori]);
    }
}
