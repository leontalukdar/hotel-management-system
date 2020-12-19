<?php

namespace App\Http\Requests;

use App\Traits\RespondsWithHttpStatus;
use App\Utils\ResponseMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CheckoutRequest extends FormRequest
{
    use RespondsWithHttpStatus;

    /**
     * Determine if the user is authorized to make this request.
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
            'booking_id' => 'required',
            'final_payment' => 'required'
        ];
    }

    /**
     * Throws validation exception with custom api response.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse(ResponseMessage::INVALID_REQUEST, null, Response::HTTP_UNPROCESSABLE_ENTITY, false, $validator->errors()));
    }
}
