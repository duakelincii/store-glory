<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'gambar', 'is_active'];

    public function uploadGambar($file)
    {
        try {
            $oldFile = str_replace("storage", "public", $this->attributes['gambar']);
            if (Storage::exists($oldFile)) {
                Storage::delete($oldFile);
            }
            $ext = $file->extension();
            $filename = Str::random(30) . "." . $ext;
            $fullPath = "banner/gambar-{$filename}";
            $file->public_path("public", $fullPath);
            $this->update(['gambar' => "storage/$fullPath"]);
            $this->touch();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
