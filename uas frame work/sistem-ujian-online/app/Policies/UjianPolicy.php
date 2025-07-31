<?php

namespace App\Policies;

use App\Models\Ujian;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UjianPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ujian  $ujian
     * @return bool
     */
    public function manageUjian(User $user, Ujian $ujian)
    {
        return $user->id === $ujian->user_id;
    }
}