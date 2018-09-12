<?php

namespace App\Policies;

use App\Paper;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaperPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given task.
     *
     * @param  User $user
     * @param  Paper $paper
     * @return bool
     */
    public function destroy(User $user, Paper $paper)
    {
        return $user->id === $paper->user_id;
    }
}
