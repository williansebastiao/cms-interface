<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserCreateRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function list(Request $request)
    {
        return $this->userService->list($request->all());
    }

    public function create(UserCreateRequest $request)
    {
        return $this->userService->create($request->all());
    }

    public function delete($id)
    {
        return $this->userService->delete($id);
    }
}
