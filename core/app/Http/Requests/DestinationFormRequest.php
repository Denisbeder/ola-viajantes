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
        
        if (!is_null($id)) {
            $rules['title'] = 'filled|max:191|unique:pages,title,' . $id;
            $rules['uri'] = 'filled|max:191|unique:pages,uri,' . $id;
        } else {
            $rules['title'] = 'filled|max:191';
            $rules['uri'] = 'filled|max:191';
        }        
        $rules['parent_id'] = 'nullable';
        $rules['images.*'] = 'nullable|max:2048|mimes:gif,jpeg,jpg,bmp,png,webp';

        return $rules;
    }
}
