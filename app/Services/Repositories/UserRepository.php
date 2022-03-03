<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAuthenticated()
    {
        return Auth::user();
    }

    /**
     * @inheritDoc
     */
    public function getFistOrNull(int $id): User|null
    {
        return User::where('id', $id)->firstOr(function () {
            return null;
        });
    }
}
