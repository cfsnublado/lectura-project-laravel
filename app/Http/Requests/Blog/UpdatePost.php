<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Note: return true if authorization handled elsewhere (e.g., policy).
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
            'name' => 'required|iunique:posts,name,' . $this->id,
            'description' => '',
            'content' => 'required',
        ];
    }
}
