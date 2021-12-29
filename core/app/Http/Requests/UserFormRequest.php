<?php

namespace App\Http\Requests;

class UserFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        $rules['name'] = 'filled|max:191';
        $rules['username'] = 'filled|max:20|unique:users,username,' . $id;
        $rules['email'] = 'filled|email|max:191|unique:users,email,' . $id;
        $rules['email'] = 'filled|email|max:191|unique:users,email,' . $id;

        $rules['writer.name'] = 'required_if:uses_writer,1';
        $rules['writer.email'] = 'nullable|email';
        $rules['writer.url'] = 'nullable|url';
        $rules['avatar'] = 'nullable|max:2048|mimes:gif,jpeg,jpg,bmp,png,webp';

        if (is_null($id)) {
            $rules['password'] = 'filled|confirmed|min:6';
        } else {
            $rules['password'] = 'confirmed';
        }

        return $rules;
    }

}
