<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100|unique:job_types,title,'.\Request()->id,
            'slug'  => 'max:100|unique:job_types,slug,'.\Request()->id,
        ];
    }
}
