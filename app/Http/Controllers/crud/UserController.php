<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\interfaces\UserRepositoryInterface;
use App\Services\traits\ReturnWithRedirectAndFlash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ReturnWithRedirectAndFlash;

    /**
     * Метод устанавливет статус определенному пользователю
     *
     * id пользователя и номер роли передаются через get-параметры
     * @param UserRepositoryInterface $userRepository
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setRole(UserRepositoryInterface $userRepository, Request $request)
    {
        // перечень значений статусов пользователя для валидатора 'in'
        $stringOfUserStatuses = User::STATUS_ADMIN . ',' . User::STATUS_USER . ',' . User::STATUS_BANNED;

        $request->validate([
            'id' => 'bail|required|integer|exists:\App\Models\User,id',
            'role' => 'bail|required|integer|in:' . $stringOfUserStatuses,
        ]);

        $user_id = $request->input('id');
        $role = $request->input('role');

        // Сохранение данных пользователя в БД
        $user = $userRepository->getFistOrNull($user_id);
        $user->status = $role;
        if (!$user->save()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Save failed',
                route('admin.users'),
                $request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Role is set',
            route('admin.users'),
            $request
        );
    }
}
