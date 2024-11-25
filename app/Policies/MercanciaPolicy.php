<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Mercancia;

class MercanciaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, Mercancia $mercancia)
    {
        return $user->id === $mercancia->user_id;
    }
    public function delete(User $user, Mercancia $mercancia){
        return $user->id === $mercancia->user_id;
    }
}
