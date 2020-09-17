<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BookCategoryRepository;
use App\Entities\BookCategory;
use App\Validators\BookCategoryValidator;

/**
 * Class BookCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookCategoryRepositoryEloquent extends BaseRepository implements BookCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BookCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function deleteNotInArray($id, $categories)
    {
        $this->model->where('book_id', $id)
            ->whereNotIn('category_id', $categories)
            ->delete();
    }
    
}
