<?php

namespace App\Services\Repositories;

use App\Models\Order;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\ColumnSortingControl;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputSource;
use App\Services\interfaces\OrdersRepositoryInterface;

class OrdersRepository implements OrdersRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllUsingGrid(InputSource $input, int $pageSize = 15)
    {
        $provider = new EloquentDataProvider(Order::query());

        $grid = new Grid($provider, [
            new Column('id'),
            (new Column('user_id'))->setValueFormatter(function($value) {
                return "<a href=" . route('admin.users', ['filt_id' => $value]) . ">$value</a>";
            }),
            (new Column('bag_id'))->setValueFormatter(function($value) {
                return "<a href=" . route('admin.bags', ['filt_id' => $value]) . ">$value</a>";
            }),
            new Column('name'),
            new Column('number'),
            new Column('created_at'),
            new PaginationControl($input->option('page', 1), $pageSize),
            new ColumnSortingControl('created_at', $input->option('sort_created')),
            new FilterControl('id', FilterOperation::OPERATOR_LIKE, $input->option('sort_id')),
            new FilterControl('user_id', FilterOperation::OPERATOR_LIKE, $input->option('sort_user-id')),
            new FilterControl('bag_id', FilterOperation::OPERATOR_LIKE, $input->option('sort_bag-id')),
        ]);

        $styles = new BootstrapStyling();
        $styles->apply($grid);

        return $grid;
    }

    /**
     * @inheritDoc
     */
    public function getFirstOrNull(int $id): Order|null
    {
        return Order::where('id', $id)->firstOr(function () {
            return null;
        });
    }
}
