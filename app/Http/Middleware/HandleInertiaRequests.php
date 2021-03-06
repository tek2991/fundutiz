<?php

namespace App\Http\Middleware;

use App\Http\Resources\v1\FinancialYearResource;
use Inertia\Middleware;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'is_admin' => Auth::check() ? Auth::user()->email === config('constants.admin_email') : false,
            'current_financial_year' => Auth::check() && FinancialYear::hasActive() ? new FinancialYearResource(FinancialYear::current()) : null,
        ]);
    }
}
