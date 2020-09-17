<?php

namespace App\Services;

use App\Repositories\FavoriteBookRepository;

class FavoriteBookService
{
    private $favoriteBookRepository;

    public function __construct(FavoriteBookRepository $favoriteBookRepository)
    {
        $this->favoriteBookRepository = $favoriteBookRepository;
    }


    public function addToLibrary($id, $fields)
    {
        return $this->favoriteBookRepository->updateOrCreate(['book_id' => $id, 'device_id' => $fields['device_id']]);
    }

    public function deleteFromLibrary($id, $fields)
    {
        return $this->favoriteBookRepository->deleteWhere(['book_id' => $id, 'device_id' => $fields['device_id']]);
    }

}