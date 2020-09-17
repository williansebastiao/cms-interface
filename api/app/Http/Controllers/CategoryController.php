<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function list()
    {
        return $this->categoryService->list();
    }

    public function listAdmin()
    {
        return $this->categoryService->listAdmin();
    }

    public function create(CategoryStoreRequest $request)
    {
        return $this->categoryService->create($request->all());
    }
}
