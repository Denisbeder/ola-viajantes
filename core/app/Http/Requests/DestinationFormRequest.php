<?php

namespace App\Http\Requests;

class DestinationFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        $rules['title'] = 'filled|max:191';   
        $rules['slug'] = 'max:191';
        $rules['images.*'] = 'nullable|max:2048|mimes:gif,jpeg,jpg,bmp,png,webp';

        return $rules;
    }
}
