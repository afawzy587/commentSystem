<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
{
    use FailedValidationResponseHandler;
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
            'comment' =>['required','string','min:3','max:255']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * This method is called before the validation rules are applied.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }

    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated($key, $default);
        $validatedData['user_id'] = $this->input('user_id');
        return $validatedData;
    }
}
