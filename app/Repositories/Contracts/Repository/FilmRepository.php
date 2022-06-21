<?php

namespace App\Repositories\Contracts\Repository;

use App\Models\Film;
use App\Repositories\Contracts\RepositoryInterface\FilmRepositoryInterface;
use App\Repositories\BaseRepository;

class FilmRepository extends BaseRepository implements FilmRepositoryInterface
{
    /**
     * @return void
     */
    public function getModel()
    {
        return Film::class;
    }
}
