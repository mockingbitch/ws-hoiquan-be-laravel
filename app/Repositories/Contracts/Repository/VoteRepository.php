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

    /**
     * @param integer $userId
     * 
     * @return void
     */
    public function checkIfExistVote(int $userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }
    
    /**
     * @param integer $filmId
     * 
     * @return void
     */
    public function count(int $filmId)
    {
        $votes = $this->model->where('film_id', $filmId)->get();
        
        return count($votes);
    }

    /**
     * @param integer $filmId
     * 
     * @return void
     */
    public function calculatePercent(int $filmId)
    {
        $sum = 0;
        $votes = $this->model->where('film_id', $filmId)->get();
        foreach ($votes as $vote) {
            $sum += $vote->percent;
        }
        $percent = $sum / count($votes);
        
        return $percent;
    }
}
