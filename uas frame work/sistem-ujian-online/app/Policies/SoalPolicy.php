<?php

namespace App\Policies;

use App\Models\Soal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SoalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Soal  $soal
     * @return bool
     */
    public function manageSoal(User $user, Soal $soal)
    {
        return $user->id === $soal->user_id;
    }
}