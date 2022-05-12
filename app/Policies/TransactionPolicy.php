<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
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
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Transaction $transaction)
    {
        return true;
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
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Transaction $transaction)
    {
        $all_users_team_ids = $user->allTeams()->pluck('id')->toArray();
        $transaction_team_id = $transaction->team_id;
        return in_array($transaction_team_id, $all_users_team_ids) || $user->is_admin();     
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Transaction $transaction)
    {
        $all_users_team_ids = $user->allTeams()->pluck('id')->toArray();
        $transaction_team_id = $transaction->team_id;
        return in_array($transaction_team_id, $all_users_team_ids) || $user->is_admin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Transaction $transaction)
    {
        $all_users_team_ids = $user->allTeams()->pluck('id')->toArray();
        $transaction_team_id = $transaction->team_id;
        return in_array($transaction_team_id, $all_users_team_ids) || $user->is_admin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Transaction $transaction)
    {
        $all_users_team_ids = $user->allTeams()->pluck('id')->toArray();
        $transaction_team_id = $transaction->team_id;
        return in_array($transaction_team_id, $all_users_team_ids) || $user->is_admin();
    }
}
