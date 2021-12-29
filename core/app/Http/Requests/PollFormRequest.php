<?php

namespace App\Http\Requests;

class PollFormRequest extends FormRequest
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
        $rules['published_at'] = 'nullable|date|size:19';
        $rules['unpublished_at'] = 'nullable|date|after_or_equal:published_at|size:19';

        return $rules;
    }
}
