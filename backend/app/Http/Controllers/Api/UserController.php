<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response\HandleJsonResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    use HandleJsonResponses;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        parent::__construct();
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('user.index', Auth::user());

        $users = $this->userService->listAll($request->all());

        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => $users
        ]);
    }
    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update($userId, UpdateUserRequest $request): JsonResponse
    {
        $this->authorize('user.update', Auth::user());

        $user =$this->userService->getById($userId);

        if (! $user) {
            return $this->respondNotFound(['message' => __('messages.not_found')]);
        }
        $data = $request->data();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            Storage::putFile('public/images/', $file);
            $path = 'public/images/' . $file->getClientOriginalName() . '.' . $file->getExtension();
            $data['avatar'] = $path;
        }
        $this->userService->update($user, $request->$data);

        return $this->respondOk([
            'message' => __('messages.ok')
        ]);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $this->authorize('user.store', Auth::user());
        $data = $request->data();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            Storage::putFile('public/images/', $file);
            $path = 'public/images/' . $file->getClientOriginalName() . '.' . $file->getExtension();
            $data['avatar'] = $path;
        }

        $this->userService->create($data);

        return $this->respondOk([
            'message' => __('messages.ok')
        ]);
    }

    public function delete($id): JsonResponse
    {
        $this->authorize('user.delete', Auth::user());

        $user = $this->userService->getById($id);
        if (!$user) {
            return $this->respondNotFound([
                'message' => __('messages.not_found')
            ]);
        }
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }
        $user->delete();
        return $this->respondOk([
            'message' => __('messages.delete_success'),
        ]);
    }

    public function detail($id): JsonResponse
    {
        $this->authorize('user.detail', Auth::user());

        $user = $this->userService->getById($id);
        if (!$user) {
            return $this->respondNotFound([
                'message' => __('messages.not_found')
            ]);
        }
        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => $user
        ]);
    }
}
