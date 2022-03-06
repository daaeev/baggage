<?php

namespace App\Providers;

use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\interfaces\UserRepositoryInterface;
use App\Services\Repositories\BagsRepository;
use App\Services\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        BagsRepositoryInterface::class => BagsRepository::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UserRepositoryInterface $userRepository)
    {
        Blade::if('admin', function () use ($userRepository) {
            return $userRepository->getAuthenticated()?->isAdmin();
        });

        Validator::extend('telephone', function ($attribute, $value, $parameters) {
            $matches = [];
            preg_match('#^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$#', $value, $matches);

            return @$matches[0] == $value;
        });
    }
}
