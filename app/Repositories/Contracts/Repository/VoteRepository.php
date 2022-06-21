<?php

namespace App\Repositories\Contracts\Repository;

use App\Models\Vote;
use App\Repositories\Contracts\RepositoryInterface\VoteRepositoryInterface;
use App\Repositories\BaseRepository;

class VoteRepository extends BaseRepository implements VoteRepositoryInterface
{
    /**
     * @return void
     */
    public function getModel()
    {
        return Vote::class;
    }
}
