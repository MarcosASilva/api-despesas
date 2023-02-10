<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {

        $dataToLogin = $request->all();

        $validator = Validator::make(
            $dataToLogin,
            [
                'password' => ['required'],
                'email' => ["required", "email"],
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'message' => 'Verifique os dados!!',
                'details' => $errors->messages(),

            ], 422);
        }
        if (Auth::attempt($dataToLogin)) {
            $request->session()->regenerate();
            $user = User::find($request->user()->id);
            $token =$user->createToken("Api")->plainTextToken;
            $token = explode("|", $token);
            // return $token[1];
            return response()->json([
                'api-token' => $token[1]

            ]);
        } else {
            return response()->json([
                'message' => 'Email e/ou senha errado(s)!!'

            ], 422);
        }
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        if (!is_null($user)) {
            $user->tokens()->delete();
            auth()->logout();
            return response()->json([
                'message' => 'Logout com Sucesso'

            ]);
        }else{
            return response()->json([
                'message' => 'Nenhum usuario autenticado'

            ]);
        }
    }
}
