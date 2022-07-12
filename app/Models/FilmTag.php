<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmTag extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'filmtags';

    /**
     * @var array
     */
    protected $fillable = [
        'film_id',
        'tag_id'
    ];

    /**
     * @return void
     */
    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

    /**
     * @return void
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
