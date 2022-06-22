<?php

namespace App\Repositories\Contracts\Repository;

use App\Models\FilmTag;
use App\Repositories\Contracts\RepositoryInterface\FilmRepositoryInterface;
use App\Repositories\BaseRepository;

class FilmTagRepository extends BaseRepository implements FilmRepositoryInterface
{
    /**
     * @return void
     */
    public function getModel()
    {
        return FilmTag::class;
    }
}
