<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommentRequest extends FormRequest
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
        $rules = [
            'post_id' => ['required', Rule::exists('posts', 'id')],
            'text' => ['required', 'max:400'],
        ];

        if (request()->get('comment_id') != null && request()->get('reply_id') != null) {
            $rules['comment_id'] = [Rule::exists('comments', 'id')];
            $rules['reply_id'] = [Rule::exists('comments', 'id')];
        }

        return $rules;
    }
}
