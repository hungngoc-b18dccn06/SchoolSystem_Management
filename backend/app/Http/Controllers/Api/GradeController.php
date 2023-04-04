<?php

namespace App\Http\Controllers\Api;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Http\Controllers\Controller;
use App\Http\Resources\ListGradeResource;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Grade::withCount('students')->with('teacher.user')->latest()->paginate(10);
        //dd($classes);
        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => [
                "classes" => ListGradeResource::collection($classes),
                'count' => $classes->total(),
                'page' => $classes->currentPage(),
                'linePerPage' => $classes->perPage(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$teachers = Teacher::latest()->get();

        $request->validate([
            'class_name'        => 'required|string|max:255|unique:grades',
            'class_numeric'     => 'required|numeric',
            'teacher_id'        => 'required|numeric',
            'class_description' => 'required|string|max:255'
        ]);

        $class = Grade::create([
            'class_name'        => $request->class_name,
            'class_numeric'     => $request->class_numeric,
            'teacher_id'        => $request->teacher_id,
            'class_description' => $request->class_description
        ]);

        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => $class
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_name'        => 'required|string|max:255|unique:grades,class_name,'.$id,
            'class_numeric'     => 'required|numeric',
            'teacher_id'        => 'required|numeric',
            'class_description' => 'required|string|max:255'
        ]);

        $class = Grade::findOrFail($id);

        $class->update([
            'class_name'        => $request->class_name,
            'class_numeric'     => $request->class_numeric,
            'teacher_id'        => $request->teacher_id,
            'class_description' => $request->class_description
        ]);

        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => $class
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $class = Grade::findOrFail($id);

        $class->subjects()->detach();
        $class->delete();

        return $this->respondOk([
            'message' => __('messages.ok'),
        ]);
    }


    public function assignSubject($classid)
    {
        $assigned = Grade::with(['subjects','students'])->findOrFail($classid);

        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' =>   $assigned
        ]);
    }

}
