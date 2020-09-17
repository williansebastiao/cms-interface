<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CategoryRepository;
use App\Entities\Category;
use App\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function list()
    {
        return $this->model->select('id', 'name', 'description')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function listAdmin()
    {
        return $this->model->selectRaw("categories.id, categories.name, categories.description, count(book_categories.id) as books")
            ->orderBy('categories.name', 'asc')
            ->leftJoin('book_categories', 'book_categories.category_id', '=', 'categories.id')
            ->groupBy('categories.id')
            ->get();
    }
    
}
