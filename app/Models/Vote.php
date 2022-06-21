<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Film;
use App\Models\User;

class Vote extends Model
{
    use HasFactory;

       /**
     * @var string
     */
    protected $table = 'votes';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'film_id',
        'percent',
        'comment'
    ];

    /**
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return void
     */
    public function film() {
        return $this->belongsTo(Film::class, 'film_id');
    }
}
