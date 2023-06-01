<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
  {
    $setting = Setting::first();
    return view('admin.master.setting.index', compact('setting'));
  }

  public function post(Request $request)
  {
    $settings = Setting::first();

    if ($request->file('logo')) {
      $file = $request->file('logo');
      $extension = $file->getClientOriginalExtension(); // you can also use file name
      $fileName = 'logo.' . $extension;
      $file->move(public_path('/uploads/setting'), $fileName);

      $settings->name = $request->name;
      $settings->no_wa = $this->gantiformat($request->no_wa);
      $settings->logo = '/uploads/setting/' . $fileName;
      File::delete($settings->logo);
    }

    $settings->save();
    return redirect()->back()->withSuccess("Pengaturan berhasil diubah!");
  }

  private function gantiformat($nomorhp)
  {
    //Terlebih dahulu kita trim dl
    $nomorhp = trim($nomorhp);
   //bersihkan dari karakter yang tidak perlu
    $nomorhp = strip_tags($nomorhp);
   // Berishkan dari spasi
   $nomorhp= str_replace(" ","",$nomorhp);
   // bersihkan dari bentuk seperti  (022) 66677788
    $nomorhp= str_replace("(","",$nomorhp);
   // bersihkan dari format yang ada titik seperti 0811.222.333.4
    $nomorhp= str_replace(".","",$nomorhp);

    //cek apakah mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($nomorhp))){
        // cek apakah no hp karakter 1-3 adalah +62
        if(substr(trim($nomorhp), 0, 3)=='+62'){
            $nomorhp= trim($nomorhp);
        }
        // cek apakah no hp karakter 1 adalah 0
       elseif(substr($nomorhp, 0, 1)=='0'){
            $nomorhp= '+62'.substr($nomorhp, 1);
        }
    }
    return $nomorhp;
    }
}
