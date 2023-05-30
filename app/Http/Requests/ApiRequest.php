<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use ApiResponse;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiRequest extends FormRequest
{
  
    abstract public function rules();

    protected function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException($this->apiError(
            $validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
        ));
    }
    protected function failedAuthorization()
    {
      throw new HttpResponseException($this->apiError(
        null,
        Response::HTTP_UNAUTHORIZED
      ));   
    }

}
