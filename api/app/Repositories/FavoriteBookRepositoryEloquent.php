<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FavoriteBookRepository;
use App\Entities\FavoriteBook;
use App\Validators\FavoriteBookValidator;

/**
 * Class FavoriteBookRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FavoriteBookRepositoryEloquent extends BaseRepository implements FavoriteBookRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FavoriteBook::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
