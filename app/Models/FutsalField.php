<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutsalField extends Model
{
    use HasFactory;

    protected $table = 'futsal_fields';

    protected $fillable = [
        'field_type_id', 
        'name', 
        'price', 
        'width', 
        'height',
        'image', 
        'is_available'
    ];

    public function field_type()
    {
        return $this->belongsTo(FieldType::class, 'field_type_id', 'id');
    }

    // Helper
    public function available()
    {
        return $this->attributes['is_available'] < 1 ? false : true;
    }
}
