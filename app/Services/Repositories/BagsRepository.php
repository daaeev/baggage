<?php

namespace App\Services\Repositories;

use App\Models\Bag;
use App\Services\interfaces\BagsRepositoryInterface;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\ColumnSortingControl;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputSource;

class BagsRepository implements BagsRepositoryInterface
{
    public function getAllUsingGrid(InputSource $input)
    {
        $provider = new EloquentDataProvider(Bag::query());

        $grid = new Grid($provider, [
            new Column('id'),
            new Column('name'),
            new Column('description'),
            new Column('price'),
            new Column('discount_price'),
            new Column('count'),
            (new Column('image'))->setValueFormatter(function($value) {
                return "<img src = '" . asset("storage/$value") . "' alt='bag_preview_image' width='200px'>";
            }),
            new PaginationControl($input->option('page', 1), 15),
            new ColumnSortingControl('id', $input->option('sort')),
            new FilterControl('id', FilterOperation::OPERATOR_LIKE, $input->option('sort_id')),
            new FilterControl('name', FilterOperation::OPERATOR_LIKE, $input->option('sort_name')),
            new FilterControl('count', FilterOperation::OPERATOR_LIKE, $input->option('sort_count')),
            new FilterControl('price', FilterOperation::OPERATOR_LIKE, $input->option('sort_price')),
            new FilterControl('discount_price', FilterOperation::OPERATOR_LIKE, $input->option('sort_discount_price')),

        ]);

        $styles = new BootstrapStyling();
        $styles->apply($grid);

        return $grid;
    }

    /**
     * @inheritDoc
     */
    public function getFistOrNull(int $id): Bag|null
    {
        return Bag::where('id', $id)->firstOr(function () {
            return null;
        });
    }
}
