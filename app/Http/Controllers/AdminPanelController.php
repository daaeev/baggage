<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Schema\Grammars\ChangeColumn;
use Illuminate\Support\Facades\DB;
use App\Services\interfaces\UserRepositoryInterface;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\ColumnSortingControl;
use ViewComponents\Grids\Component\DetailsRow;
use ViewComponents\Grids\Component\SolidRow;
use ViewComponents\Grids\Component\TableCaption;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Component\Debug\SymfonyVarDump;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputSource;

class AdminPanelController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @return mixed
     */
    public function usersList(UserRepositoryInterface $userRepository)
    {
        $provider = new EloquentDataProvider(User::query());
        $input = new InputSource(request()->query());

        $grid = new Grid($provider, [
            new Column('id'),
            new Column('name'),
            new Column('email'),
            new Column('status'),
            new Column('action'),
            new PaginationControl($input->option('page', 1), 15),
            new ColumnSortingControl('id', $input->option('sort')),
            new FilterControl('id', FilterOperation::OPERATOR_LIKE, $input->option('sort_id')),
            new FilterControl('status', FilterOperation::OPERATOR_LIKE, $input->option('sort_name')),

        ]);

        $styles = new BootstrapStyling();
        $styles->apply($grid);

        return view('admin.users', compact('grid'));
    }

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
