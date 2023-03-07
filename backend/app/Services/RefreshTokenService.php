<?php

namespace App\Services;

use App\Models\RefreshToken;
use Illuminate\Database\Eloquent\Model;

class RefreshTokenService
{
    protected RefreshToken $refreshToken;

    public function __construct(RefreshToken $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    public function getByToken($token): Model
    {
        return $this->refreshToken->newQuery()->where('token', $token)->orderBy('id', 'DESC')->first();
    }

}
