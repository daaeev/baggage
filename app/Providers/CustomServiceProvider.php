<?php

namespace App\Providers;

use App\Services\interfaces\UserRepositoryInterface;
use App\Services\Repositories\UserRepository;
use Illuminate\Support\Facades\Blade;

class CustomServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
    ];

    public function boot(UserRepositoryInterface $userRepository)
    {
        Blade::if('admin', function () use ($userRepository) {
            return $userRepository->getAuthenticated()?->isAdmin();
        });
    }
}
