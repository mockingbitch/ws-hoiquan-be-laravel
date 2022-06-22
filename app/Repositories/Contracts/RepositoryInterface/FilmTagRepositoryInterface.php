<?php

namespace App\Repositories\Contracts\RepositoryInterface;

use App\Repositories\BaseRepositoryInterface;

interface FilmTagRepositoryInterface extends BaseRepositoryInterface
{
    public function checkIfExist(int $film_id, int $tag_id);

    public function getAllIdFilmTags(int $film_id);

    public function deleteTag(int $film_id, int $tag_id);
}
