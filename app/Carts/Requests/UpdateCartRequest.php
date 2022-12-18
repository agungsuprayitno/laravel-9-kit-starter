<?php

namespace App\Carts\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
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
            'item_id' => '',
            'qty' => '',
        ];
    }

    public function allowed() {
        return [
            'item_id',
            'qty'
        ];
    }
}
