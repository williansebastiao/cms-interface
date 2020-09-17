<?php

namespace App\Repositories;

use App\Entities\Book;
use App\Validators\BookValidator;
use Illuminate\Support\Facades\DB;
use App\Repositories\BookRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookRepositoryEloquent extends BaseRepository implements BookRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function list($filters)
    {
        $query = $this->model->selectRaw("
            books.id, 
            books.title, 
            books.time, 
            books.image_url, 
            (CASE favorite_books.device_id WHEN '{$filters['device_id']}' THEN true ELSE false END) favorite,
            (CASE WHEN count(payments.id) > 0 THEN 0 ELSE books.locked END) as locked")
            ->leftJoin('favorite_books', 'favorite_books.book_id', '=', 'books.id')
            ->leftJoin('payments', 'payments.book_id', '=', 'books.id')
            ->leftJoin('devices', function($q) use ($filters) {
                $q->on('payments.device_id', '=', 'devices.id');
                $q->where('payments.device_id', '=', $filters['device_id']);
            });
        if (isset($filters['query']) && $filters['query'] != '') {
            $query = $query->where('books.title','like',"%{$filters['query']}%");
        }

        if (isset($filters['category_id']) && $filters['category_id'] != '') {
            $query = $query->where('books.category_id', $filters['category_id']);
        }

        if (isset($filters['book_type']) && $filters['book_type'] != '') {
            $query = $query->where('books.book_type', $filters['book_type']);
        }

        if (isset($filters['locked']) && $filters['locked'] != '') {
            $query = $query->where(function($q) use ($filters) {
                $q = $q->where('books.locked', $filters['locked']);
                if($filters['locked']) {
                    $q = $q->whereNull('payments.id');
                } else {
                    $q = $q->orWhereNotNull('payments.id');
                }
            });
        }

        $query = $query->with(['bookCategories' => function($q) {
            $q->select('id', 'book_id', 'category_id');
            $q->with(['category' => function($q) {
                $q->select('id', 'name');
            }]);
        }]);

        return $query->groupBy('books.id')->paginate(config('instorinhas.paginate'));
    }

    public function popular($filters)
    {
        return $this->model->selectRaw("
                count(favorite_books.id) favorites,
                books.id,
                books.title,
                books.time,
                books.image_url,
                books.locked,
                (CASE favorite_books.device_id WHEN '{$filters['device_id']}' THEN true ELSE false END) favorite,
                (CASE WHEN count(payments.id) > 0 THEN 0 ELSE books.locked END) as locked
            ")
            ->leftJoin('favorite_books', 'favorite_books.book_id', '=', 'books.id')
            ->leftJoin('payments', 'payments.book_id', '=', 'books.id')
            ->leftJoin('devices', function($q) use ($filters) {
                $q->on('payments.device_id', '=', 'devices.id');
                $q->where('payments.device_id', '=', $filters['device_id']);
            })
            ->groupBy('books.id')
            ->orderBy('favorites', 'desc')
            ->with(['bookCategories' => function($q) {
                $q->select('id', 'book_id', 'category_id');
                $q->with(['category' => function($q) {
                    $q->select('id', 'name');
                }]);
            }])
            ->paginate(config('instorinhas.paginate'));

    }

    public function recent($filters)
    {
        $query = $this->model->selectRaw("
            books.id,
            books.title,
            books.time,
            books.image_url,
            (CASE favorite_books.device_id WHEN '{$filters['device_id']}' THEN true ELSE false END) favorite,
            (CASE WHEN count(payments.id) > 0 THEN 0 ELSE books.locked END) as locked
            
        ")
        ->leftJoin('favorite_books', 'favorite_books.book_id', '=', 'books.id')
        ->leftJoin('payments', 'payments.book_id', '=', 'books.id')
        ->leftJoin('devices', function($q) use ($filters) {
            $q->on('payments.device_id', '=', 'devices.id');
            $q->where('payments.device_id', '=', $filters['device_id']);
        });

        if (isset($filters['query']) && $filters['query']) {
            $query = $query->where('title','like',"%{$filters['query']}%");
        }

        if (isset($filters['category_id']) && $filters['category_id']) {
            $query = $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['book_type']) && $filters['book_type']) {
            $query = $query->where('book_type', $filters['book_type']);
        }

        if (isset($filters['locked']) && $filters['locked'] != '') {
            $query = $query->where(function($q) use ($filters) {
                $q = $q->where('books.locked', $filters['locked']);
                if($filters['locked']) {
                    $q = $q->whereNull('payments.id');
                } else {
                    $q = $q->orWhereNotNull('payments.id');
                }
            });
        }

        $query = $query->with(['bookCategories' => function($q) {
            $q->select('id', 'book_id', 'category_id');
            $q->with(['category' => function($q) {
                $q->select('id', 'name');
            }]);
        }]);

        return $query->orderBy('books.created_at', 'desc')
            ->groupBy('books.id')
            ->paginate(config('instorinhas.paginate'));
    }

    public function detail($id, $filters)
    {
        return $this->model->selectRaw("
                books.id,
                books.title,
                books.description,
                books.book_type,
                books.product_type,
                books.product_price,
                books.product_google_id,
                books.product_apple_id,
                books.time,
                books.downloaded,
                books.file_url,
                books.image_url,
                books.likes,
                books.created_at,
                books.updated_at,
                (CASE favorite_books.device_id WHEN '{$filters['device_id']}' THEN true ELSE false END) favorited,
                (CASE WHEN count(payments.id) > 0 THEN 0 ELSE books.locked END) as locked
            ")
            ->leftJoin('favorite_books', 'favorite_books.book_id', '=', 'books.id')
            ->leftJoin('payments', 'payments.book_id', '=', 'books.id')
            ->leftJoin('devices', function($q) use ($filters) {
                $q->on('payments.device_id', '=', 'devices.id');
                $q->where('payments.device_id', '=', $filters['device_id']);
            })
            ->with(['bookCategories' => function($q) {
                $q->select('id', 'book_id', 'category_id');
                $q->with(['category' => function($q) {
                    $q->select('id', 'name');
                }]);
            }])
            ->where('books.id', $id)
            ->first();
    }

    

    public function getBook($filters)
    {
        $query = $this->model;

        if (isset($filters['book_id']) && $filters['book_id'] != '') {
            $query = $query->where('id',  $filters['book_id']);
        }
        if (isset($filters['product_id_apple']) && $filters['product_id_apple'] != '') {
            $query = $query->where('product_apple_id',  $filters['product_id_apple']);
        }
        if (isset($filters['product_id_google']) && $filters['product_id_google'] != '') {
            $query = $query->where('product_google_id',  $filters['product_id_google']);
        }

        return $query->first();
    }

    public function content($id, $filters)
    {
        return $this->model->selectRaw("
                books.content,
                books.file_url
            ")
            ->where('books.id', $id)
            ->first();
    }

    public function listAdmin($filters)
    {
        $query = $this->model->selectRaw("
            books.id, 
            books.title, 
            books.created_at");

        if (isset($filters['query']) && $filters['query'] != '') {
            $query = $query->where('books.title','like',"%{$filters['query']}%");
        }

        if (isset($filters['category_id']) && $filters['category_id'] != '') {
            $query = $query->where('
            .category_id', $filters['category_id']);
        }

        if (isset($filters['book_type']) && $filters['book_type'] != '') {
            $query = $query->where('books.book_type', $filters['book_type']);
        }

        if (isset($filters['product_type']) && $filters['product_type'] != '') {
            $query = $query->where('books.product_type', $filters['product_type']);
        }

        if (isset($filters['from_date']) && $filters['from_date'] != '' && isset($filters['to_date']) && $filters['to_date']) {
            $query = $query->whereBetween('books.created_at',[$filters['from_date'], $filters['to_date']]);
        }

        $query = $query->with(['bookCategories' => function($q) {
            $q->select('id', 'book_id', 'category_id');
            $q->with(['category' => function($q) {
                $q->select('id', 'name');
            }]);
        }]);

        return $query->groupBy('books.id')->paginate(config('instorinhas.paginate'));
    }

    public function detailAdmin($id)
    {
        return $this->model->selectRaw("
                books.id,
                books.title,
                books.description,
                books.book_type,
                books.product_type,
                books.product_price,
                books.product_google_id,
                books.product_apple_id,
                books.time,
                books.downloaded,
                books.file_url,
                books.image_url,
                books.likes,
                books.created_at,
                books.updated_at
            ")
            ->with(['bookCategories' => function($q) {
                $q->select('id', 'book_id', 'category_id');
                $q->with(['category' => function($q) {
                    $q->select('id', 'name');
                }]);
            }])
            ->where('books.id', $id)
            ->first();
    }
    
}
