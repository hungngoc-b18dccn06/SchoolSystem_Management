<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected User $user;
    const LIMIT_SEARCH_USER = 10;
    protected UploadService $uploadService;

    public function __construct(
        User $user,
    )
    {
        $this->user = $user;
    }

    public function listAll($data)
    {
        $text = $data['search_text'] ?? null;
        $query =$this->user->newQuery();
        if ($text) {
            $query = $query->where('email', 'like', "%$text%")
                ->orWhere(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', "%$text%");
        }

        return $query->paginate(self::LIMIT_SEARCH_USER);
    }

    public function getByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function getById($id)
    {
        return $this->user->where('id', $id)->first();
    }

    public function update($user, $data): int
    {
        return $user->update($data);
    }
    public function create($data)
    {
        return $this->user->create($data);
    }
}
