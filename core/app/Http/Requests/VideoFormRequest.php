<?php

namespace App\Http\Requests;

class VideoFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        $rules['page_id'] = 'filled|integer|exists:pages,id';
        $rules['title'] = 'filled|max:191';
        $rules['url'] = 'filled|url|max:191';
        $rules['script'] = 'filled';
        $rules['seo_title'] = 'nullable|max:191';
        $rules['seo_keywords'] = 'nullable|max:191';
        $rules['seo_description'] = 'nullable|max:191';
        $rules['image'] = 'nullable|max:2048|mimes:gif,jpeg,jpg,bmp,png,webp';

        return $rules;
    }

}
