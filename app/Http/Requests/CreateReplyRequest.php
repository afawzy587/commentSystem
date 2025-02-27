<?php

namespace App\Http\Requests;

use Illuminate\Validation\{Rule};
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class CreateReplyRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * This method is called before the validation rules are applied.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'comment_id' => Crypt::decrypt($this->comment_id),
            'user_id' => auth()->id(),
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment_id' => ['required',Rule::exists('comments', 'id')],
            'reply_text' => ['required','string','min:3','max:255'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated($key, $default);
        $validatedData['user_id'] = $this->input('user_id');
        return $validatedData;
    }
}
