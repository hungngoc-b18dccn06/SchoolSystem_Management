<?php

namespace App\Services;

use App\Enums\RevokedRefreshToken;
use App\Models\RefreshToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthService
{
    protected RefreshTokenService $refreshTokenService;

    public function __construct(RefreshTokenService $refreshTokenService)
    {
        $this->refreshTokenService = $refreshTokenService;
    }

    /**
     * @param User $user
     * @return array
     */
    public function createNewToken(User $user): array
    {
        $response['type'] = 'Bearer';
        $response['access_token'] = $user->createToken('Personal Access Token')->plainTextToken;
        $refreshTokenModel = $user->refreshToken()->where('expires_at', '>=', Carbon::now())->first();
        $user->refreshToken()->where('revoked', RevokedRefreshToken::YES)->orWhere('expires_at', '<', Carbon::now())->delete();
        if (! $refreshTokenModel) {
            $response['refresh_token'] = $this->createNewRefreshToken($user);
        } else {
            $response['refresh_token'] = $refreshTokenModel->token;
        }

        return $response;
    }

    public function createNewRefreshToken(User $user)
    {
        $refreshToken = new RefreshToken();
        $refreshToken->token = hash('sha256', Str::random(40));
        $refreshToken->expires_at = Carbon::now()->addDays(config('sanctum.refresh_token_expired_days'));

        $user->refreshToken()->save($refreshToken);

        return $refreshToken->token;
    }

    public function refreshNewToken($refreshToken): ?array
    {
        $refreshTokenModel = $this->refreshTokenService->getByToken($refreshToken);
        if (! $refreshTokenModel) {
            return null;
        }
        $user = $refreshTokenModel->user;

        return $this->createNewToken($user);
    }
}
