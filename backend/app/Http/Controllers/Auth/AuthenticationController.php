<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Status;
use App\Helpers\Response\HandleJsonResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\ResetLinkEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\PasswordResetService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    use HandleJsonResponses;

    protected AuthService $authService;

    protected UserService $userService;

    protected PasswordResetService $passwordResetService;

    public function __construct(
        AuthService $authService,
        UserService $userService,
        PasswordResetService $passwordResetService
    )
    {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password', 'role']);
        if (! Auth::guard()->attempt($credentials)) {
            return response()->json([
                'message' => __('messages.error_email_or_password')
            ], 401);
        }

        if (Auth::user()?->status != Status::VALID) {
            return response()->json([
                'message' => __('messages.user_in_valid')
            ], 401);
        }


        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => [
                'access_token' => Auth::user()->createToken('authToken')->plainTextToken
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => [
                'user' => $request->user()
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->respondOk([
            'message' => __('messages.logout')
        ]);
    }

//    /**
//     * @param RefreshTokenRequest $request
//     * @return JsonResponse
//     */
//    public function refresh(RefreshTokenRequest $request): JsonResponse
//    {
//        $newToken = $this->authService->refreshNewToken($request->get('refresh_token'));
//
//        if (! $newToken) {
//            return $this->respondNotFound([
//                'message' => __('messages.not_found_token')
//            ]);
//        }
//
//        return $this->respondOk([
//            'message' => __('messages.ok'),
//            'data' => $newToken
//        ]);
//    }

    /**
     * @param ResetLinkEmailRequest $request
     * @return JsonResponse
     */
    public function sendResetLinkEmail(ResetLinkEmailRequest $request): JsonResponse
    {
        $user = $this->userService->getByEmail($request->get('email'));

        if (! $user) {
            return $this->respondNotFound(['message' => __('messages.not_found_user')]);
        }

        $response = $this->passwordResetService->handleSendResetLink($user);
        if ($response['code'] == Response::HTTP_BAD_REQUEST) {
            return $this->respondBadRequest(['message' => $response['message']]);
        }

        return $this->respondOk([
            'message' => $response['message']
        ]);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $response = $this->passwordResetService->handleResetPassword($request->all());

        if ($response['code'] == Response::HTTP_NOT_FOUND) {
            return $this->respondNotFound([
                'message' => $response['message']
            ]);
        } elseif ($response['code'] == Response::HTTP_BAD_REQUEST) {
            return $this->respondBadRequest(['message' => $response['message']]);
        } else {
            return $this->respondOk(['message' => $response['message']]);
        }
    }

    public function checkExpiredForgotPasswordToken(Request $request)
    {
        $token = $request->get('token');
        $response = $this->passwordResetService->checkTokenExpired($token);

        if ($response['code'] != Response::HTTP_OK) {
            return $this->respondBadRequest(['message' => $response['message']]);
        }

        return $this->respondOk(['message' => __('messages.ok')]);
    }
}
