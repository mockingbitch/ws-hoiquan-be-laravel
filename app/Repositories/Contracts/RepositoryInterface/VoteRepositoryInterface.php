<?php

namespace App\Repositories\Contracts\RepositoryInterface;

use App\Repositories\BaseRepositoryInterface;

interface VoteRepositoryInterface extends BaseRepositoryInterface
{
    public function checkIfExistVote(int $userId, int $filmId);

    public function count(int $filmId);

    public function calculatePercent(int $filmId);
}
