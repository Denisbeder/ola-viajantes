<?php

namespace App\Http\Requests;

class GalleryFormRequest extends FormRequest
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
        $rules['seo_title'] = 'nullable|max:191';
        $rules['seo_description'] = 'nullable|max:191';
        $rules['seo_keywords'] = 'nullable|max:191';
        
        if (is_null($id)) {
            $rules['images.*'] = 'required|max:2048|mimes:gif,jpeg,jpg,bmp,png,webp';
        } 

        return $rules;
    }
}
