<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSetRole;
use App\Services\interfaces\UserRepositoryInterface;
use App\Services\traits\ReturnWithRedirectAndFlash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ReturnWithRedirectAndFlash;

    /**
     * Метод устанавливет статус определенному пользователю
     *
     * @param UserRepositoryInterface $userRepository
     * @param Request $request
     * @param UserSetRole $validation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setRole(
        UserRepositoryInterface $userRepository,
        Request $request,
        UserSetRole $validation
    )
    {
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
