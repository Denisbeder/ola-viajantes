<?php

namespace App\Http\Requests;

class MenuFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        /* $rules['email'] = 'filled|email|max:191';
        $rules['page_id'] = 'filled|exists:pages,id'; */
        $rules = [];            

        return $rules;
    }

}
