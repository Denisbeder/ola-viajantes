<?php

namespace App\Http\Requests;

class BannerFormRequest extends FormRequest
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
        $rules['position'] = 'filled';
        $rules['started_at'] = 'nullable|date|size:19';
        $rules['finished_at'] = 'nullable|date|after_or_equal:started_at|size:19';
        
        if (is_null($id)) {
            $rules['size'] = 'required_without:script';
            $rules['file'] = 'required_without:script|max:600|mimes:zip,gif,jpeg,jpg,bmp,png,webp,mp4';
        }

        return $rules;
    }
}
