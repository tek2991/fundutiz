<?php

namespace App\Http\Controllers\Inertia;

use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Illuminate\Http\Request;
use Laravel\Jetstream\TeamInvitation;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController;


class InertiaTeamInvitationController extends TeamInvitationController
{
    /**
     * Accept a team invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Jetstream\TeamInvitation  $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptInvitation(Request $request, TeamInvitation $invitation)
    {
        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role
        );

        $invitation->delete();

        return redirect()->back()->banner(
            __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]),
        );
    }
}
