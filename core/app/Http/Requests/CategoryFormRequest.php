<?php

namespace App\Http\Requests;

class CategoryFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        $rules['title'] = 'filled|max:191|unique:categories,title,' . $id;
        $rules['page_id'] = 'filled|exists:pages,id';            
        $rules['slug'] = 'max:191';

        return $rules;
    }

}
