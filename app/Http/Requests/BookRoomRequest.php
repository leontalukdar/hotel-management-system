<?php

namespace App\Http\Requests;

use App\Traits\RespondsWithHttpStatus;
use App\Utils\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class BookRoomRequest extends FormRequest
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
            'room_id' => 'required',
            'arrival_time' => 'required|date_format:Y-m-d H:i:s|after:' . date('Y-m-d H:i:s', strtotime(Carbon::now())),
            'checkout_time' => 'required|date_format:Y-m-d H:i:s|after:' . date('Y-m-d H:i:s', strtotime($this->arrival_time)),
            'payment_amount' => 'required'
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
