<?php

namespace App\Http\Requests;

class SettingFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        $rules['data'] = 'required';

        return $rules;
    }
}
