<?php

namespace App\Http\Requests;

use App\Enums\ProductEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,webp', 'max:2048'],
            'price_per_unit' => ['required', 'numeric', 'min:1'],
            'unit' => ['required', Rule::enum(ProductEnum::class)],
        ];
    }
}
