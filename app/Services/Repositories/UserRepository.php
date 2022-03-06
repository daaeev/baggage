<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\interfaces\UserRepositoryInterface;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
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
            (new Column('email_verified_at', 'Email verify'))->setValueFormatter(function($value) {
                return $value ? 'Verified' : '';
            }),
            new Column('status'),
            new PaginationControl($input->option('page', 1), $pageSize),
            new FilterControl('id', FilterOperation::OPERATOR_LIKE, $input->option('filt_id')),
            new FilterControl('status', FilterOperation::OPERATOR_LIKE, $input->option('filt_name')),

        ]);

        $styles = new BootstrapStyling();
        $styles->apply($grid);

        return $grid;
    }
}
