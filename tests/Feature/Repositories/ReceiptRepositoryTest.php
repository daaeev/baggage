<?php

namespace Tests\Feature\Repositories;

use App\Services\interfaces\ReceiptRepositoryInterface;
use App\Services\Repositories\ReceiptRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Input\InputSource;

class ReceiptRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ReceiptRepositoryInterface $repository;

    public function setUp(): void
    {
        $this->repository = new ReceiptRepository();
        parent::setUp();
    }

    public function testMakeGridSuccess()
    {
        $grid = $this->repository->getAllUsingGrid(new InputSource([]));

        $this->assertNotNull($grid);
        $this->assertInstanceOf(Grid::class, $grid);
    }
}
