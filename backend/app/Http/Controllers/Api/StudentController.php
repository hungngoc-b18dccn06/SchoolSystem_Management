<?php

namespace App\Http\Controllers\Api;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\StudentService;
class StudentController extends Controller
{
    protected UserService $userService;

    protected StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('user')->latest()->paginate(10);

        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            'class_id'          => 'required|numeric',
            'roll_number'       => [
                'required',
                'numeric',Rule::unique('students')->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id);
                })
            ],
            'role' => 'required|in:' . implode(",", Role::asArray()),

        ]);

        $student = User::create([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'password'  => Hash::make($request->password),
            'email'     => $request->email,
            'role'     => $request->role,
        ]);
        $student->student()->create([
            'class_id'          => $request->class_id,
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'roll_number'       => $request->roll_number
        ]);
        // Return a response indicating success
        return response()->json([
            'message' => 'student created successfully',
            'data' => [
                'student' => $student
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($studentID, Request $request, Student $student)
    {

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
            'class_id'          => 'required|numeric',
            'roll_number'       => [
                'required',
                'numeric',Rule::unique('students')->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id);
                })
            ],
            'role' => 'required|in:' . implode(",", Role::asArray()),

        ]);

        $student = $this->studentService->getById($studentID);

        $student->user->update([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'password'  => Hash::make($request->password),
            'email'     => $request->email,
        ]);

        // Update the student model fields
        $student->update([
            'class_id'          => $request->class_id,
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'roll_number'       => $request->roll_number
        ]);

        dd($user = User::findOrFail($student->user_id));
        return $this->respondOk([
            'message' => "student updated successfully",
            'data' => [
                'student' => $student
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Student $student,$studentID)
    {
        $student = $this->studentService->getById($studentID);
        if (!$student) {
            return $this->respondNotFound([
                'message' => __('messages.not_found')
            ]);
        }
        $student->delete();
        return $this->respondOk([
            'message' => __('messages.delete_success'),
        ]);
    }

    public function detail($id) {
        $student = Student::with('user')->findOrFail($id);
        return response()->json([
            'message' => 'successfully',
            'data' => [
                'teacher' => $student
            ]
        ], 200);
    }
}
