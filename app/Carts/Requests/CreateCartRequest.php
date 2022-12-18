<?php

namespace App\Carts\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCartRequest extends FormRequest
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
        return [
            'items' => 'required',
            'customer_id' => 'required',
        ];
    }

    public function allowed() {
        return [
          'items',
          'customer_id' => 'required'
        ];
    }
}
