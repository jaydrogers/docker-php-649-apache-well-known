<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/.well-known/openid-configuration', function () {
    $appUrl = config('app.url');

    return response()->json([
        'issuer' => $appUrl,
        'authorization_endpoint' => $appUrl . '/oauth/authorize',
        'token_endpoint' => $appUrl . '/oauth/token',
        'userinfo_endpoint' => $appUrl . '/oauth/userinfo',
        'jwks_uri' => $appUrl . '/.well-known/jwks.json',
    ]);
});