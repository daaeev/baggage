<?php

namespace App\Http\Middleware;

use App\Services\interfaces\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

/**
 * Посредник для проверки авторизации пользователя
 */
class Authorize
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->userRepository->getAuthenticated()) {
            return response()->redirectTo(route('login'));
        }

        return $next($request);
    }
}
