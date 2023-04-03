<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected UserService $userService;
    protected TeacherService $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index(Request $request): JsonResponse
    {

        $teachers = Teacher::with('user')->latest()->paginate(10);

        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => $teachers,
        ]);
    }

    public function update($teacherID, Request $request, Teacher $teacher)
    {

        $teacher = $this->teacherService->getById($teacherID);

        $teacher->user->update([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'email' => $request->email,
        ]);

        // Update the teacher model fields
        $teacher->update([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        return $this->respondOk([
            'message' => "Teacher updated successfully",
            'data' => [
                'teacher' => $teacher
            ]
        ]);
    }

    public function create(Request $request)
    {

        // Validate the request data
        $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:8',
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'role'              => 'required|string|max:2',
        ]);

        $teacher = User::create([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'password'  => Hash::make($request->password),
            'email'     => $request->email,
            'role'     => $request->role,
        ]);
        $teacher->teacher()->create([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);
        // Return a response indicating success
        return response()->json([
            'message' => 'Teacher created successfully',
            'data' => [
                'teacher' => $teacher
            ]
        ], 200);
    }
    public function detail($id) {
        $teacher = Teacher::with('user')->findOrFail($id);
        return response()->json([
            'message' => 'successfully',
            'data' => [
                'teacher' => $teacher
            ]
        ], 200);
    }

    public function delete(Teacher $teacher,$teacherID)
    {
        $teacher = $this->teacherService->getById($teacherID);
        if (!$teacher) {
            return $this->respondNotFound([
                'message' => __('messages.not_found')
            ]);
        }
        $teacher->delete();
        return $this->respondOk([
            'message' => __('messages.delete_success'),
        ]);
    }
}
