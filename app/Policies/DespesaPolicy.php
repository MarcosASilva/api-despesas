<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Despesa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DespesaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Despesa  $despesa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Despesa $despesa)
    {
        if ($user->id === $despesa->user_id)
            return Response::allow();
        return Response::deny("Não Autorizado a visulizar");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Despesa  $despesa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Despesa $despesa)
    {
        if ($user->id === $despesa->user_id)
            return Response::allow();
        return Response::deny("Não Autorizado a atualizar");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Despesa  $despesa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Despesa $despesa)
    {
        if ($user->id === $despesa->user_id)
            return Response::allow();
        return Response::deny("Não Autorizado a deletar");
    }
}
