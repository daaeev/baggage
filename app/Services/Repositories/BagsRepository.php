<?php

namespace App\Services\Repositories;

use App\Models\Bag;
use App\Services\interfaces\BagsRepositoryInterface;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputSource;

class BagsRepository implements BagsRepositoryInterface
{
    public function getAllUsingGrid(InputSource $input, int $pageSize = 15)
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
            new PaginationControl($input->option('page', 1), $pageSize),
            new FilterControl('id', FilterOperation::OPERATOR_LIKE, $input->option('filt_id')),
            new FilterControl('name', FilterOperation::OPERATOR_LIKE, $input->option('filt_name')),
            new FilterControl('count', FilterOperation::OPERATOR_LIKE, $input->option('filt_count')),
            new FilterControl('price', FilterOperation::OPERATOR_LIKE, $input->option('filt_price')),
            new FilterControl('discount_price', FilterOperation::OPERATOR_LIKE, $input->option('filt_discount_price')),

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

    /**
     * @inheritDoc
     */
    public function getAllWithPag(int $pageSize = 15)
    {
        return Bag::orderBy('created_at')
            ->paginate($pageSize);
    }

    /**
     * @inheritDoc
     */
    public function getAllBySearchWithPag(string $search, int $pageSize = 15)
    {
        return Bag::where('name', 'like', "%$search%")
            ->orderBy('created_at')
            ->paginate($pageSize);
    }

    /**
     * @inheritDoc
     */
    public function getFirstWhereOrNull(array $where)
    {
        return Bag::where($where)->firstOr(function () {
            return null;
        });
    }

    /**
     * @inheritDoc
     */
    public function getBagsLimitCond(Bag $bag, int $count = 4)
    {
        return Bag::where([['id', '!=', $bag->id]])
            ->orderBy('created_at')
            ->limit($count)
            ->get();
    }
}
