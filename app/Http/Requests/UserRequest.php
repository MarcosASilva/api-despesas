<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','max:255'],
            'email' => ['required', "email",'max:255','unique:users,email'],
            'password' => ['required','max:255' ]
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Verifique os dados!!',
            'details' => $errors->messages(),

        ], 422);
        throw new HttpResponseException($response);
    }
}
