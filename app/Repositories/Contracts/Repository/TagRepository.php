<?php

namespace App\Repositories\Contracts\Repository;

use App\Models\Tag;
use App\Repositories\Contracts\RepositoryInterface\TagRepositoryInterface;
use App\Repositories\BaseRepository;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * @return void
     */
    public function getModel()
    {
        return Tag::class;
    }
}
