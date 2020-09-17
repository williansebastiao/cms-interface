<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function list(Request $request)
    {
        return $this->bookService->list($request->all());
    }

    public function recent(Request $request)
    {
        return $this->bookService->recent($request->all());
    }

    public function detail($id, Request $request)
    {
        return $this->bookService->detail($id, $request->all());
    }

    public function popular(Request $request)
    {
        return $this->bookService->popular($request->all());
    }

    public function content($id, Request $request)
    {
        return $this->bookService->content($id, $request->all());
    }

    public function listAdmin(Request $request)
    {
        return $this->bookService->listAdmin($request->all());
    }

    public function detailAdmin($id)
    {
        return $this->bookService->detailAdmin($id);
    }

    public function delete($id)
    {
        return $this->bookService->delete($id);
    }

    public function create(BookRequest $request)
    {
        return $this->bookService->create($request);
    }

    public function update($id, BookRequest $request)
    {
        return $this->bookService->update($id, $request->all());
    }
}
