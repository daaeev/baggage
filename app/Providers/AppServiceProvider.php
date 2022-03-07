<?php

namespace App\Providers;

use App\Models\Bag;
use App\Observers\SubscriptionObserver;
use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\interfaces\OrdersRepositoryInterface;
use App\Services\interfaces\ReceiptRepositoryInterface;
use App\Services\interfaces\SubscribeRepositoryInterface;
use App\Services\interfaces\UserRepositoryInterface;
use App\Services\Repositories\BagsRepository;
use App\Services\Repositories\OrdersRepository;
use App\Services\Repositories\ReceiptRepository;
use App\Services\Repositories\SubscribeRepository;
use App\Services\Repositories\UserRepository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        BagsRepositoryInterface::class => BagsRepository::class,
        OrdersRepositoryInterface::class => OrdersRepository::class,
        ReceiptRepositoryInterface::class => ReceiptRepository::class,
        SubscribeRepositoryInterface::class => SubscribeRepository::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UserRepositoryInterface $userRepository)
    {
        // РЕГИСТРАЦИЯ НАБЛЮДАТЕЛЕЙ

        Bag::observe(SubscriptionObserver::class);

        // РЕГИСТРАЦИЯ BLADE ДИРЕКТИВ

        Blade::if('admin', function () use ($userRepository) {
            return $userRepository->getAuthenticated()?->isAdmin();
        });

        // РЕГИСТРАЦИЯ ВАЛИДАТОРОВ ---------------

        Validator::extend('telephone', function ($attribute, $value, $parameters) {
            $matches = [];
            preg_match('#^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$#', $value, $matches);

            return @$matches[0] == $value;
        });


        // Проверяяет, является ли значение поля с именем $parameters[1] модели $parameters[0]
        // равным 0. Для получение экземпляра модели, название валидируемого
        // поля из запроса должно быть равным названию поля в БД модели $parameters[0].
        // Значение валидируемого поля из запроса ($value) должно быть уникальным в таблице,
        // так как по нему ищется единственный экземпляр в таблице модели $parameters[0]
        Validator::extend('countIsZero', function ($attribute, $value, $parameters) {
            return !($parameters[0]::where([[$attribute, '=', $value], [$parameters[1], '!=', 0]])->exists());
        });
    }
}
