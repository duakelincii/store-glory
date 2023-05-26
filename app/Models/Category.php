<?php

namespace App\Models;

use App\SearchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SearchTrait;
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];
}
