<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/en/upaycard-deposit-success',
        '/en/upaycard-deposit-fail',
        '/en/voguepay_deposit_notify',
        '/de/voguepay_deposit_notify',
        '/en/skrill_deposit_status',
        '/de/skrill_deposit_status',
        '/en/perfect_money_deposit_status',
        '/de/perfect_money_deposit_status',
        '/api/3rdParty',
        '/api/3rdParty/clients',
        '/api/3rdParty/clients/filter',
        '/api/3rdParty/client/details',
        '/api/3rdParty/client/details/filter'
    ];
}
