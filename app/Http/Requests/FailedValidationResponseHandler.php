<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationResponseHandler
{
    /**
     * @param Validator $validator
     * @return mixed
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
