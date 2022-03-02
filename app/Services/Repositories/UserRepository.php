<?php

namespace App\Services\Repositories;

use Illuminate\Support\Facades\Auth;

class UserRepository implements \App\Services\interfaces\UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAuthenticated()
    {
        return Auth::user();
    }
}
