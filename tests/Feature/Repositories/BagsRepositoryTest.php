<?php

namespace Tests\Feature\Repositories;

use App\Models\Bag;
use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\Repositories\BagsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Input\InputSource;

class BagsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected BagsRepositoryInterface $repository;

    public function setUp(): void
    {
        $this->repository = new BagsRepository;
        parent::setUp();
    }

    public function testFirstOrNullIfNotExist()
    {
        $bag = $this->repository->getFirstOrNull(1);

        $this->assertNull($bag);
    }

    public function testFirstOrNullIfExist()
    {
        $bag_created = Bag::factory()->createOne();
        $bag_founded = $this->repository->getFirstOrNull($bag_created->id);

        $this->assertNotNull($bag_founded);
        $this->assertInstanceOf(Bag::class, $bag_founded);
        $this->assertEquals($bag_created->id, $bag_founded->id);
    }

    public function testFirstWhereOrNullIfNotExist()
    {
        $bag = $this->repository->getFirstWhereOrNull([['id', '=', 1]]);

        $this->assertNull($bag);
    }

    public function testFirstWhereOrNullIfExist()
    {
        $bag_created = Bag::factory()->createOne();
        $bag_founded = $this->repository->getFirstWhereOrNull([['slug', '=', $bag_created->slug]]);

        $this->assertNotNull($bag_founded);
        $this->assertInstanceOf(Bag::class, $bag_founded);
        $this->assertEquals($bag_created->id, $bag_founded->id);
    }

    public function testMakeGridSuccess()
    {
        $grid = $this->repository->getAllUsingGrid(new InputSource([]));

        $this->assertNotNull($grid);
        $this->assertInstanceOf(Grid::class, $grid);
    }

    public function testGetAllWithPagIfNothing()
    {
        $bags = $this->repository->getAllWithPag();

        $this->assertNotNull($bags);
        $this->assertEquals(0, $bags->total());
        $this->assertEmpty($bags->items());
    }

    public function testGetAllWithPagIfHaveBags()
    {
        $bags_count = 3;

        Bag::factory($bags_count)->create();
        $bags_pag = $this->repository->getAllWithPag();

        $this->assertNotNull($bags_pag);
        $this->assertNotEmpty($bags_pag->items());
        $this->assertEquals($bags_count, $bags_pag->total());
    }

    public function testGetAllWithPagIfHaveBagsWithPages()
    {
        $bags_count = 4;
        $page_size = 2;

        Bag::factory($bags_count)->create();
        $bags_pag = $this->repository->getAllWithPag($page_size);

        $this->assertNotNull($bags_pag);
        $this->assertEquals(intdiv($bags_count, $page_size), $bags_pag->lastPage());
        $this->assertEquals($page_size, $bags_pag->perPage());
        $this->assertEquals($page_size, $bags_pag->count());
    }

    public function testGetAllBySearchWithPagIfNothing()
    {
        $search = 'some';
        $bags_pag = $this->repository->getAllBySearchWithPag($search);

        $this->assertNotNull($bags_pag);
        $this->assertEmpty($bags_pag->items());
        $this->assertEquals(0, $bags_pag->total());
    }

    public function testGetAllBySearchWithPagIfHave()
    {
        $search = 'Bag';
        $bags_count = 4;

        Bag::factory($bags_count)->create(['name' => 'Bag bla-bla']);
        Bag::factory(1)->create();
        $bags_pag = $this->repository->getAllBySearchWithPag($search);

        $this->assertNotNull($bags_pag);
        $this->assertNotEmpty($bags_pag->items());
        $this->assertEquals($bags_count, $bags_pag->total());
    }

    public function testGetBagsLimitCondIfHave()
    {
        $bags_recs_count = 2;

        $bag = Bag::factory()->createOne();
        Bag::factory($bags_recs_count)->create();
        $bag_recs = $this->repository->getBagsLimitCond($bag, $bags_recs_count);

        $this->assertNotNull($bag_recs);
        $this->assertFalse(in_array($bag, $bag_recs->all()));
        $this->assertEquals($bags_recs_count, $bag_recs->count());
    }

    public function testGetBagsLimitCondIfNotHave()
    {
        $bag = Bag::factory()->createOne();
        $bag_recs = $this->repository->getBagsLimitCond($bag);

        $this->assertNotNull($bag_recs);
        $this->assertEmpty($bag_recs->all());
    }
}
