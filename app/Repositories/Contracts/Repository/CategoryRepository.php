<?php

namespace App\Repositories\Contracts\Repository;

use App\Models\Category;
use App\Repositories\Contracts\RepositoryInterface\CategoryRepositoryInterface;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * @return void
     */
    public function getModel()
    {
        return Category::class;
    }
}
