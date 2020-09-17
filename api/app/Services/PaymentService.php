<?php

namespace App\Services;

use Exception;
use App\Repositories\BookRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\DeviceRepository;

class PaymentService
{
    private $paymentRepository;
    private $bookRepository;
    private $deviceRepository;

    public function __construct(PaymentRepository $paymentRepository, 
        BookRepository $bookRepository,
        DeviceRepository $deviceRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->bookRepository = $bookRepository;
        $this->deviceRepository = $deviceRepository;
    }

    public function unlock($id, $fields)
    {
        try{
            $book = $this->bookRepository->getBook($fields);
            if(!$book) {
                throw new Exception("Livro não encontrado", 404);
            }
            $device = $this->deviceRepository->find($id);
            if(!$device) {
                throw new Exception("Usuário não encontrado", 404);
            }
            $payment = $this->paymentRepository->findWhere(['device_id' => $id, 'book_id' => $book->id]);
            if(count($payment)) {
                throw new Exception("Você já possui esse livro", 401);
            }
            return $this->paymentRepository->create([
                'device_id' => $id,
                'book_id' => $book->id,
                'product_id_apple' => $book->product_apple_id,
                'product_id_google' => $book->product_google_id
            ]);
        }catch(Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function restore($id, $fields)
    {
        try{
            $books = [];
            foreach($fields as $field) {
                $book = $this->bookRepository->getBook($field);
                if(!$book) {
                    throw new Exception("Livro não encontrado", 404);
                }
                $device = $this->deviceRepository->find($id);
                if(!$device) {
                    throw new Exception("Usuário não encontrado", 404);
                }
                $payment = $this->paymentRepository->findWhere(['device_id' => $id, 'book_id' => $book->id]);
                if(count($payment)) {
                    throw new Exception("Você já possui esse livro", 401);
                }
                $books[] = $this->paymentRepository->create([
                    'device_id' => $id,
                    'book_id' => $book->id,
                    'product_id_apple' => $book->product_apple_id,
                    'product_id_google' => $book->product_google_id
                ]);
            }
            return $books;
        }catch(Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}