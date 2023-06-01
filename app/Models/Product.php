<?php

namespace App\Models;

use App\SearchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SearchTrait;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'desc',
        'gambar',
        'harga'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function uploadGambar($file)
    {
        try {
            $oldFile = str_replace("storage", "public", $this->attributes['gambar']);
            if (Storage::exists($oldFile)) {
                Storage::delete($oldFile);
            }
            $ext = $file->extension();
            $filename = Str::random(30) . "." . $ext;
            $fullPath = "product/gambar-{$filename}";
            $file->public_path("public", $fullPath);
            $this->update(['gambar' => "storage/$fullPath"]);
            $this->touch();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
