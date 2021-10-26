<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable' , 'string', 'max:191', Rule::unique('products', 'slug')->ignore($this->product)],
            'description' => ['nullable', 'string', 'max:1000'],
            'price'  => ['required', 'numeric'],
            'qty' => ['required', 'integer'],
            'image' => ['nullable', 'file', 'mime:png,jpg,jpeg']
        ];
    }
}
