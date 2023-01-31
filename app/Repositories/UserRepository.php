<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    public function list(int $userId): Collection
    {
        return User::with(['sentMessages' => function ($query) use ($userId) {
            $query->where(['is_read' => false, 'receiver_id' => $userId]);
        }])
            ->where('id', '!=', $userId)
            ->get();
    }
}
