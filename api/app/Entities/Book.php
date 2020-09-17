<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Book.
 *
 * @package namespace App\Entities;
 */
class Book extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'book_type',
        'product_type',
        'product_price',
        'product_google_id',
        'product_apple_id',
        'time',
        'downloaded',
        'locked',
        'favorited',
        'file_url',
        'image_url',
        'likes'
    ];

    public function bookCategories()
    {
        return $this->hasMany(BookCategory::class, 'book_id','id');
    }

}
