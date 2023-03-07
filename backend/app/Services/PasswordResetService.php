<?php

namespace App\Services;

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PasswordResetService
{
    protected PasswordReset $passwordReset;

    protected UserService $userService;

    public function __construct(PasswordReset $passwordReset, UserService $userService)
    {
        $this->passwordReset = $passwordReset;
        $this->userService = $userService;
    }

    public function getByToken($token)
    {
        return $this->passwordReset->where('token', $token)->orderBy('created_at', 'DESC')->first();
    }

    public function handleSendResetLink(User $user): array
    {
        $response = [
            'code' => Response::HTTP_OK,
            'message' => ''
        ];
        $passwordReset = $this->passwordReset
            ->where('email', $user->email)
            ->where('created_at', '>=', Carbon::now()->subMinutes(config('auth.password_reset_expired_minutes')))
            ->first();
        if(! $passwordReset) {
            $newPasswordReset = $this->passwordReset->create([
                'email' => $user->email,
                'token' => hash('sha256', Str::random(40)),
                'created_at' => Carbon::now()
            ]);
            //Send notification to user for reset password
            $user->notify(new PasswordResetNotification($newPasswordReset->token));

            $response['message'] = __('messages.sent_password_reset');

            return $response;
        }
        $response['message'] = __('messages.email_is_sent');
        $response['code'] = Response::HTTP_BAD_REQUEST;

        return $response;
    }

    /**
     * @param $data
     * @return array
     */
    public function handleResetPassword($data): array
    {
        $response = [];
        $passwordReset = $this->getByToken($data['token']);

        if (! $passwordReset) {
            $response['message'] = __('messages.not_found');
            $response['code'] = Response::HTTP_NOT_FOUND;

            return $response;
        }
        // Check expire token
        if (Carbon::parse($passwordReset->created_at)->addMinutes(config('auth.password_reset_expired_minutes'))->isPast()) {
            $response['message'] = __('messages.expired_password_reset_token');
            $response['code'] = Response::HTTP_BAD_REQUEST;

            return $response;
        }

        $user = $this->userService->getByEmail($passwordReset->email);

        if (! $user) {
            $response['message'] = __('messages.not_found_user');
            $response['code'] = Response::HTTP_NOT_FOUND;

            return $response;
        }

        if ($this->userService->update($user, ['password' => bcrypt($data['password'])])) {
            $this->passwordReset->where('email', $user->email)->delete();
        }

        $response['message'] = __('messages.success_reset_password');
        $response['code'] = Response::HTTP_OK;

        return $response;
    }

    public function checkTokenExpired($token)
    {
        $passwordReset = $this->getByToken($token);

        if (! $passwordReset) {
            $response['message'] = __('messages.token_was_used');
            $response['code'] = Response::HTTP_NOT_FOUND;

            return $response;
        }

        // Check expire token
        if (Carbon::parse($passwordReset->created_at)->addMinutes(config('auth.password_reset_expired_minutes'))->isPast()) {
            $response['message'] = __('messages.expired_password_reset_token');
            $response['code'] = Response::HTTP_BAD_REQUEST;

            return $response;
        }

        return [
            'message' => __('messages.ok'),
            'code' => Response::HTTP_OK
        ];
    }
}
