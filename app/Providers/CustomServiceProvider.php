<?php

namespace App\Providers;

use App\Services\interfaces\UserRepositoryInterface;
use App\Services\Repositories\UserRepository;

class CustomServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
    ];
}
