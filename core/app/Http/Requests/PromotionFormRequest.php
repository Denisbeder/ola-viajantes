<?php

namespace App\Http\Requests;

class PromotionFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        $rules['title'] = 'filled|max:191|unique:promotions,title,' . $id;   
        $rules['slug'] = 'max:191';
        $rules['published_at'] = 'nullable|date|size:19';
        $rules['unpublished_at'] = 'nullable|date|after_or_equal:published_at|size:19';
        $rules['image'] = 'nullable|max:2048|mimes:gif,jpeg,jpg,bmp,png,webp';

        return $rules;
    }

}
