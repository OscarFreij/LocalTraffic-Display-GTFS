<?php

namespace App\Http\Requests;

use App\Models\Screen;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScreenRequest extends FormRequest
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
            'long_name' => [
                'string',
                'required',
                Rule::unique(Screen::class)->ignore($this->id)],
            'timezone' => 'int|required|max:12|min:-12'
        ];
    }
}
