<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $q = request()->q;
        $banners = Banner::when($q, function ($query) use ($q) {
            return $query->search($q);
        })->orderByDesc("updated_at")->paginate(6);
        $setting = Setting::first();
        return view('admin.master.banner.index', compact('banners','setting'));
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
                'title' => 'required|string',
                'gambar' => 'mimes:png,jpg',
                'is_active' => 'required'
            ]);

            if ($request->file('gambar')) {
                $file = $request->file('gambar');
                $extension = $file->getClientOriginalExtension(); // you can also use file name
                $fileName = time().'.'. $extension;
                $file->move(public_path('/uploads/banner'), $fileName);
            }
            Banner::create([
                'title' => $request->title,
                'gambar' => '/uploads/banner/' . $fileName,
                'is_active' => $request->is_active
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'gambar' => 'mimes:png,jpg',
                'is_active' => 'required'
            ]);
            if ($request->file('gambar')) {
                $file = $request->file('gambar');
                $extension = $file->getClientOriginalExtension(); // you can also use file name
                $fileName = time().'.'. $extension;
                $file->move(public_path('/uploads/banner'), $fileName);

                $inputdata = [
                    'title' => $request->title,
                    'gambar' => '/uploads/banner/' . $fileName,
                    'is_active' => $request->is_active
                ];
            }else{
                $inputdata = [
                    'title' => $request->title,
                    'is_active' => $request->is_active
                ];
            }
            $banner->update($inputdata);
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
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }

    public function json(Banner $banner)
    {
        return response()->json(['success' => true, 'data' => $banner]);
    }
}
