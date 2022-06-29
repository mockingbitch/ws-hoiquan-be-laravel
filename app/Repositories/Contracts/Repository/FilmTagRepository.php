<?php

namespace App\Repositories\Contracts\Repository;

use App\Models\FilmTag;
use App\Repositories\Contracts\RepositoryInterface\FilmTagRepositoryInterface;
use App\Repositories\BaseRepository;

class FilmTagRepository extends BaseRepository implements FilmTagRepositoryInterface
{
    /**
     * @return void
     */
    public function getModel()
    {
        return FilmTag::class;
    }

    /**
     * @param integer $film_id
     * @param integer $tag_id
     * 
     * @return void
     */
    public function checkIfExist(int $film_id, int $tag_id)
    {
        if (! $filmTag = $this->model->where(['film_id' => $film_id, 'tag_id' => $tag_id])->first()) {
            return false;
        }

        return true;
    }

    /**
     * @param integer $film_id
     * 
     * @return void
     */
    public function getAllIdFilmTags(int $film_id)
    {
        if (! $filmTags = $this->model->where('film_id', $film_id)->get()) {
            return false;
        }

        if (! count($filmTags) > 0) {
            return false;
        }
        
        foreach ($filmTags as $filmTag) {
            $id[] = $filmTag->tag_id; 
        }

        return $id;
    }

    /**
     * @param integer $film_id
     * @param integer $tag_id
     * 
     * @return void
     */
    public function deleteTag(int $film_id, int $tag_id)
    {
        if (! $this->model->where(['film_id' => $film_id, 'tag_id' => $tag_id])->delete()) {
            return false;
        }

        return true;
    }
}
