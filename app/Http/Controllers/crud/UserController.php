<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    /**
     * Метод устанавливет статус определенному пользователю
     *
     * id пользователя и номер роли передаются через get-параметры
     * @param UserRepositoryInterface $userRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setRole(UserRepositoryInterface $userRepository)
    {
        $id = request()->query('id');
        $role = request()->query('role');

        // Проверка на существование пользователя с id = $id
        if (!$user = $userRepository->getFistOrNull($id)) {
            request()->session()->flash('status_fail', "User with id $id not found");

            return response()->redirectTo(route('admin.users'));
        }

        // Проверка на существование роли с номером $role
        if (!in_array($role, [User::STATUS_USER, User::STATUS_ADMIN, User::STATUS_BANNED])) {
            request()->session()->flash('status_fail', "Incorrect role");

            return response()->redirectTo(route('admin.users'));
        }

        // Сохранение данных пользователя в БД
        $user->status = $role;
        if (!$user->save()) {
            request()->session()->flash('status_fail', "Save failed");

            return response()->redirectTo(route('admin.users'));
        }

        request()->session()->flash('status_success', "Role is set");

        return response()->redirectTo(route('admin.users'));
    }
}
