<?php

namespace App\Services;

use Exception;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list($filters)
    {
        return $this->userRepository->paginate(config('instorinhas.paginate'));
    }

    public function create($filters)
    {
        return $this->userRepository->create([
            'name' => ucwords(strtolower($filters['name'])),
            'email' => strtolower($filters['email']),
            'password' => bcrypt($filters['password']),
            'access' => $filters['access'],
        ]);
    }

    public function delete($id)
    {
        try{
            $user = $this->userRepository->find($id);
            if(!$user) {
                throw new Exception("Usuário não encontrado", 404);
            }
            if(!$user->delete()) {
                throw new Exception("Erro ao excluir o usuário", 500);
            }
            return ['error' => false];

        }catch(Exception $e) {
            abort($e->getCode() ? $e->getCode() : 500, $e->getMessage());
        }
    }
}