<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $bookTypes = ['text','audio','video','mixed'];
        $productTypes = ['paid','free'];

        return [
            'title' => 'required',
            'description' => '',
            'content' => 'required',
            'book_type' => 'required|in:' . implode(',',$bookTypes),
            'product_type' => 'required|in:' . implode(',',$productTypes),
            'product_price' => 'required|numeric',
            'product_google_id' => 'required',
            'product_apple_id' => 'required',
            'time' => 'required|numeric',
            'downloaded' => 'required|boolean',
            'file_url' => 'url',
            'image_url' => 'url',
            'categories' => 'required|array'
        ];
    }
}
