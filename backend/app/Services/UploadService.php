<?php

namespace App\Services;

class UploadService
{
    public function uploadAvatar($userId, $file)
    {
        return $file->storeAs('avatar/' . $userId, $file->getClientOriginalName(), config('filesystems.default'));
    }
}
