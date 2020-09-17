<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Repositories\BookCategoryRepository;

class BookService
{
    private $bookRepository;
    private $bookCategoryRepository;

    public function __construct(BookRepository $bookRepository, BookCategoryRepository $bookCategoryRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->bookCategoryRepository = $bookCategoryRepository;
    }

    public function list($filters)
    {
        return $this->bookRepository->list($filters);
    }

    public function recent($filters)
    {
        return $this->bookRepository->recent($filters);
    }

    public function detail($id, $filters)
    {
        return $this->bookRepository->detail($id, $filters);
    }

    public function popular($filters)
    {
        return $this->bookRepository->popular($filters);
    }

    public function content($id, $filters)
    {
        return $this->bookRepository->content($id, $filters);
    }

    public function listAdmin($filters)
    {
        return $this->bookRepository->listAdmin($filters);
    }

    public function detailAdmin($id)
    {
        return $this->bookRepository->detailAdmin($id);
    }

    public function delete($id)
    {
        try{
            $book = $this->bookRepository->find($id);
            if(!$book) {
                throw new Exception("Livro não encontrado", 404);
            }
            if(!$book->delete()) {
                throw new Exception("Erro ao excluir o livro", 500);
            }
            return ['error' => false];

        }catch(Exception $e) {
            abort($e->getCode() ? $e->getCode() : 500, $e->getMessage());
        }
    }
    
    public function create($fields)
    {
        try{
            $book = $this->bookRepository->create([
                'title' => $fields['title'],
                'description' => $fields['description'],
                'content' => $fields['content'],
                'book_type' => $fields['book_type'],
                'product_type' => $fields['product_type'],
                'product_price' => $fields['product_price'],
                'product_google_id' => $fields['product_google_id'],
                'product_apple_id' => $fields['product_apple_id'],
                'time' => $fields['time'],
                'downloaded' => $fields['downloaded'],
                'file_url' => $fields['file_url'],
                'image_url' => $fields['image_url']
            ]);
            if(!$book) {
                throw new Exception("Livro não cadastrado", 500);
            }
            $categories = [];
            foreach($fields['categories'] as $category)
            {
                $categories[] = $this->bookCategoryRepository->create(['book_id' => $book->id, 'category_id' => $category]);
            }
            $book->categories = $categories;
            return $book;

        }catch(Exception $e) {
            abort($e->getCode() ? $e->getCode() : 500, $e->getMessage());
        }
    }

    public function update($id, $fields)
    {
        try{
            $book = $this->bookRepository->find($id)->update([
                'title' => $fields['title'],
                'description' => $fields['description'],
                'content' => $fields['content'],
                'book_type' => $fields['book_type'],
                'product_type' => $fields['product_type'],
                'product_price' => $fields['product_price'],
                'product_google_id' => $fields['product_google_id'],
                'product_apple_id' => $fields['product_apple_id'],
                'time' => $fields['time'],
                'downloaded' => $fields['downloaded'],
                'file_url' => $fields['file_url'],
                'image_url' => $fields['image_url']
            ]);
            if(!$book) {
                throw new Exception("Livro não cadastrado", 500);
            }
            foreach($fields['categories'] as $category)
            {
                $this->bookCategoryRepository->updateOrCreate(
                    ['book_id' => $id, 'category_id' => $category], 
                    ['book_id' => $id, 'category_id' => $category]);
            }
            $this->bookCategoryRepository->deleteNotInArray($id, $fields['categories']);
            return ['error' => false];

        }catch(Exception $e) {
            abort($e->getCode() ? $e->getCode() : 500, $e->getMessage());
        }
    }
}