<?php

namespace App\Http\Requests\Conversion;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source' => 'required',
            'destination' => 'required|different:source',
            'amount' => 'required|integer|min:1'
        ];
    }
}
