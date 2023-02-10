<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return User::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $dataToInsert = $request->all();
        $dataToInsert["password"] = Hash::make($dataToInsert["password"]);
        $user = User::create($dataToInsert);
        return response()->json([
            'message' => 'user criado com sucesso',
            'details' => $user,

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        //Validaçao dos dados
        $dataToBeUpdated = $request->all();
        $validator = Validator::make(
            $dataToBeUpdated,
            [
                'name' => ['max:255'],
                'email' => ["email", 'max:255', 'unique:users,email'],
                'password' => ['max:255']
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'message' => 'Verifique os dados!!',
                'details' => $errors->messages(),

            ], 422);
        }

        
        //Verificacao do dados passados
        if ($request->filled("name")) $user->name = $request->name;
        if ($request->filled("email")) $user->email = $request->email;
        if ($request->filled("password")) {
            $dataToBeUpdated["password"] = Hash::make($dataToBeUpdated["password"]);
            $user->password = $dataToBeUpdated["password"];
        }

        //Update d usuario
        $user->save();

        return response()->json([
            'message' => 'Atualizado com Sucesso',
            'details' => $user,

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return response()->json([
            'message' => 'Deletado com Sucesso'

        ]);
    }
  

}
