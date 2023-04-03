<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentService
{
    protected Student $student;
    const LIMIT_SEARCH_USER = 10;
    protected UploadService $uploadService;

    public function __construct(
        Student $student,

    )
    {
        $this->student = $student;

    }

    public function listAll($data)
    {
        $query =$this->student->newQuery();
        return $query->paginate(self::LIMIT_SEARCH_USER);
    }

    public function getByEmail($email)
    {
        return $this->student->where('email', $email)->first();
    }

    public function getById($id)
    {
        return $this->student->where('id', $id)->first();
    }

    public function update($student, $data): int
    {
        return $student->update($data);
    }
    public function create($data)
    {
        return $this->student->create($data);
    }
}
