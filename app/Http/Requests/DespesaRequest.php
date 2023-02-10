<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DespesaRequest extends FormRequest
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
            'descricao' => ['required', 'max:191'],
            'valor' => ['required', "integer", "gte:0"],
            'datadespesa' => ['required', 'before_or_equal:today'],
            'user_id' => ['required', 'exists:App\Models\User,id']
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
