<?php

namespace App\Http\Requests;

class PostFormRequest extends FormRequest
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
        $rules['hat'] = 'nullable|max:191';
        $rules['description'] = 'nullable|max:191';
        $rules['seo_title'] = 'nullable|max:191';
        $rules['seo_description'] = 'nullable|max:191';
        $rules['seo_keywords'] = 'nullable|max:191';
        $rules['author'] = 'nullable|max:191';
        $rules['source'] = 'nullable|max:191';
        $rules['published_at'] = 'nullable|date|size:19';
        $rules['unpublished_at'] = 'nullable|date|after_or_equal:published_at|size:19';
        $rules['images.*'] = 'nullable|max:2048|mimes:gif,jpeg,jpg,bmp,png,webp';

        if (is_null($this->input('draft'))) {
            $rules['title'] = 'filled|max:191';
            $rules['title_short'] = 'max:191';
            // $rules['body'] = 'filled';
        }

        return $rules;
    }
}
