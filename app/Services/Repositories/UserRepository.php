<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\interfaces\UserRepositoryInterface;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\ColumnSortingControl;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputSource;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAuthenticated()
    {
        return Auth::user();
    }

    /**
     * @inheritDoc
     */
    public function getFistOrNull(int $id): User|null
    {
        return User::where('id', $id)->firstOr(function () {
            return null;
        });
    }

    public function getAllUsingGrid(InputSource $input, int $pageSize = 15)
    {
        $provider = new EloquentDataProvider(User::query());

        $grid = new Grid($provider, [
            new Column('id'),
            new Column('name'),
            new Column('email'),
            new Column('status'),
            new Column('action'),
            new PaginationControl($input->option('page', 1), $pageSize),
            new ColumnSortingControl('id', $input->option('sort')),
            new FilterControl('id', FilterOperation::OPERATOR_LIKE, $input->option('sort_id')),
            new FilterControl('status', FilterOperation::OPERATOR_LIKE, $input->option('sort_name')),

        ]);

        $styles = new BootstrapStyling();
        $styles->apply($grid);

        return $grid;
    }
}
