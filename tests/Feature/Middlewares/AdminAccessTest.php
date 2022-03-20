<?php

namespace Tests\Feature\Middlewares;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function testIfAdmin()
    {
        $user = User::factory()->createOne(['status' => User::$status_admin]);

        Route::get('/admin-middleware-test', function () {
            return true;
        })->middleware('admin');

        $this->actingAs($user)
            ->get('/admin-middleware-test')
            ->assertOk();

        $this->assertAuthenticatedAs($user);
    }

    public function testIfNotAdmin()
    {
        $user = User::factory()->createOne();

        Route::get('/admin-middleware-test', function () {
            return true;
        })->middleware('admin');

        $this->actingAs($user)
            ->get('/admin-middleware-test')
            ->assertRedirect(\route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function testIfNotAuth()
    {
        Route::get('/admin-middleware-test', function () {
            return true;
        })->middleware('admin');

        $this->get('/admin-middleware-test')
            ->assertRedirect(\route('home'));
    }
}
