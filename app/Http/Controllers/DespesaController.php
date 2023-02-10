<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DespesaRequest;
use App\Models\Despesa;
use App\Models\User;
use App\Notifications\DespesaNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DespesaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Despesa::class, 'despesa');
    }
    /**
     * Mostra todas as despesas de um usuario
     *
     * @param Request $request
     * @return App\Models\Despesa $despesa
     */
    public function index(Request $request)
    {

        $user = $request->user();


        return $user->despesa()->get()->toJson();
    }
    /**
     * Mostra uma despesa especifica
     *
     * @param Despesa $despesa
     * @return App\Models\Despesa $despesa
     */
    public function show(Despesa $despesa)
    {

        return $despesa;
    }

    /**
     * Cria uma nova despesa
     *
     * @param DespesaRequest $request
     * @return response
     */
    public function store(DespesaRequest $request)
    {



        $despesa = Despesa::create($request->all());
        $userWhoCreate = $request->user();
        $userToBeSendDespesa = User::find($despesa->user_id);

        $userToBeSendDespesa->notify(new DespesaNotification($despesa, $userWhoCreate));
        return response()->json([
            'message' => 'Despesa criada com sucesso',
            'details' => $despesa,

        ]);
    }

    /**
     * Atualiza uma despesa existente
     *
     * @param integer $id
     * @param Request $request
     * @return response
     */
    public function update(Despesa $despesa, Request $request)
    {

        $data = $request->all();

        //Validaçao
        $validator = Validator::make(
            $data,
            [
                "descricao" => ["max:191"],
                "valor" => ["gte:0"],
                "datadespesa" => ['before_or_equal:today']
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'message' => 'Verifique os dados!!',
                'details' => $errors->messages(),

            ], 422);
        }

        //Verificacao dos campos passados
        if ($request->filled("descricao")) $despesa->descricao = $request->descricao;
        if ($request->filled("valor")) $despesa->valor = $request->valor;
        if ($request->filled("datadespesa")) $despesa->datadespesa = $request->datadespesa;

        //Update
        $despesa->save();

        return response()->json([
            'message' => 'Atualizado com Sucesso',
            'details' => $despesa,

        ], 200);
    }
    /**
     * Deletar uma despesa
     *
     * @param integer $id
     * @return response
     */
    public function destroy(Despesa $despesa)
    {

        Despesa::destroy($despesa->id);
        return response()->json([
            'message' => 'Deletado com Sucesso'

        ]);
    }
    
}
