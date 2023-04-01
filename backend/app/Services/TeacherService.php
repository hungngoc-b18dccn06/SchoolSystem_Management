<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherService
{
    protected Teacher $teacher;
    const LIMIT_SEARCH_USER = 10;
    protected UploadService $uploadService;

    public function __construct(
        Teacher $teacher,

    )
    {
        $this->teacher = $teacher;

    }

    public function listAll($data)
    {
        $query =$this->teacher->newQuery();
        return $query->paginate(self::LIMIT_SEARCH_USER);
    }

    public function getByEmail($email)
    {
        return $this->teacher->where('email', $email)->first();
    }

    public function getById($id)
    {
        return $this->teacher->where('id', $id)->first();
    }

    public function update($teacher, $data): int
    {
        return $teacher->update($data);
    }
    public function create($data)
    {
        return $this->teacher->create($data);
    }
}
