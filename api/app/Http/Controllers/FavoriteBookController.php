<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FavoriteBookService;
use App\Http\Requests\FavoriteRequest;

class FavoriteBookController extends Controller
{
    private $favoriteBookService;

    public function __construct(FavoriteBookService $favoriteBookService)
    {
        $this->favoriteBookService = $favoriteBookService;
    }

    public function addToLibrary($id, FavoriteRequest $request)
    {
        return $this->favoriteBookService->addToLibrary($id, $request->all());
    }

    public function deleteFromLibrary($id, FavoriteRequest $request)
    {
        return $this->favoriteBookService->deleteFromLibrary($id, $request->all());
    }
}
