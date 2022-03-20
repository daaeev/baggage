<?php

namespace Tests\Feature\Repositories;

use App\Models\Bag;
use App\Models\Subscription;
use App\Services\interfaces\SubscribeRepositoryInterface;
use App\Services\Repositories\SubscribeRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected SubscribeRepositoryInterface $repository;

    public function setUp(): void
    {
        $this->repository = new SubscribeRepository();
        parent::setUp();
    }

    public function testUserIsSubIfNot()
    {
        $is_sub = $this->repository->userIsSubscribed(1, 1);

        $this->assertFalse($is_sub);
    }

    public function testUserIsSubIfYes()
    {
        $user = User::factory()->createOne();
        $bag = Bag::factory()->createOne();
        Subscription::factory()->createOne([
            'user_id' => $user->id,
            'bag_id' => $bag->id,
        ]);

        $is_sub = $this->repository->userIsSubscribed($user->id, $bag->id);

        $this->assertTrue($is_sub);
    }

    public function testGetAllSubsIfNothing()
    {
        $subs_count = 2;

        $bag = Bag::factory()->createOne();
        Subscription::factory($subs_count)->create([
            'bag_id' => $bag->id,
        ]);

        $subs = $this->repository->getAllSubscriptionsByBag($bag->id);

        $this->assertNotNull($subs);
        $this->assertEquals($subs_count, $subs->count());
    }
}
