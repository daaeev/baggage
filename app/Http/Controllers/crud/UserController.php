<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

        $user_id = request()->query('id');
        $role = request()->query('role');

        // Сохранение данных пользователя в БД
        $user = $userRepository->getFistOrNull($user_id);
        $user->status = $role;
        if (!$user->save()) {
            request()->session()->flash('status_failed', "Save failed");

            return response()->redirectTo(route('admin.users'));
        }

        request()->session()->flash('status_success', "Role is set");

        return response()->redirectTo(route('admin.users'));
    }
}
