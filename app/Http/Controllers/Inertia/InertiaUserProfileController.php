<?php

namespace App\Http\Controllers\Inertia;

use Auth;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

class InertiaUserProfileController extends UserProfileController
{
        /**
     * Show the general profile settings screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function showProfile(Request $request)
    {
        $this->validateTwoFactorAuthenticationState($request);

        return Jetstream::inertia()->render($request, 'Profile/Show', [
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'sessions' => $this->sessions($request)->all(),
            'userTeamInvitations' => Auth::user()->teamInvitations()->with('team')->get(),
        ]);
    }
}
