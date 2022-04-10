<?php

namespace Tests\Feature\Repositories;

use App\Models\Order;
use App\Services\interfaces\OrdersRepositoryInterface;
use App\Services\Repositories\OrdersRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Input\InputSource;

class OrdersRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected OrdersRepositoryInterface $repository;

    public function setUp(): void
    {
        $this->repository = new OrdersRepository();
        parent::setUp();
    }

    public function testFirstOrNullIfNotExist()
    {
        $bag = $this->repository->getFirstOrNull(1);

        $this->assertNull($bag);
    }

    public function testFirstOrNullIfExist()
    {
        $order_created = Order::factory()->createOne();
        $order_founded = $this->repository->getFirstOrNull($order_created->id);

        $this->assertNotNull($order_founded);
        $this->assertInstanceOf(Order::class, $order_founded);
        $this->assertEquals($order_created->id, $order_founded->id);
    }

    public function testMakeGridSuccess()
    {
        $grid = $this->repository->getAllUsingGrid(new InputSource([]));

        $this->assertNotNull($grid);
        $this->assertInstanceOf(Grid::class, $grid);
    }
}
