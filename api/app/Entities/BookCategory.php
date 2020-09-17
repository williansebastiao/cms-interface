<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BookCategory.
 *
 * @package namespace App\Entities;
 */
class BookCategory extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['book_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

}
