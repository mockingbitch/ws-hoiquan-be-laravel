<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Category;

class Film extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'films';

    /**
     * @var array
     */
    protected $fillable = [
        'name_vi',
        'name_en',
        'description_vi',
        'description_en',
        'vote',
        'percent'
    ];
}
