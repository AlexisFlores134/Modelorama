<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Categoria;
class CategoriaPolicy
{
      /**
     * Create a new policy instance.
     */
    public function update(User $user, Categoria $categoria)
{
    return $user->can('Editar categorias');
}
    public function delete(User $user, Categoria $categoria){
        return $user->id === $categoria->user_id;
    }
}
