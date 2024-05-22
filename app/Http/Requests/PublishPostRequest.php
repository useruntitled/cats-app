<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublishPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', Rule::exists('posts', 'id')],
            'title' => ['required', 'min:5', 'max:200'],
            'media.uuid' => ['required', Rule::exists('medias', 'uuid')],
        ];
    }

    public function messages()
    {
        return [
            'id' => 'This post is undefined.',
            'title' => 'Please provide a title.',
            'media.uuid' => 'Please provide a media.',
        ];
    }
}
