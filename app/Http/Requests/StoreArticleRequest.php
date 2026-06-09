<?php

namespace App\Http\Requests;

use App\Helpers\ImageHelper;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:100000',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'thumbnail' => ImageHelper::VALIDATION_RULES(),
            'status' => 'nullable|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
