<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function list()
    {
        return $this->categoryRepository->list();
    }

    public function listAdmin()
    {
        return $this->categoryRepository->listAdmin();
    }

    public function create($fields)
    {
        return $this->categoryRepository->create([
            'name' => $fields['name'],
            'description' => isset($fields['description']) ? $fields['description'] : null,
            'image_url' => isset($fields['image_url']) ? $fields['image_url'] : null
        ]);
    }
}