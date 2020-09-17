<?php

namespace App\Services;

use App\Repositories\BookCategoryRepository;

class BookCategoryService
{
    private $bookCategoryRepository;

    public function __construct(BookCategoryRepository $bookCategoryRepository)
    {
        $this->bookCategoryRepository = $bookCategoryRepository;
    }
}