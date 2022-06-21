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
        'name',
        'description',
        'tag_id',
        'category_id',
        'vote'
    ];

    /**
     * @return void
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return void
     */
    public function tag() {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
