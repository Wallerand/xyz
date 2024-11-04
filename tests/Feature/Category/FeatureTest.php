<?php

namespace Tests\Feature\Category;

// 12

use App\Models\Category;
use App\Models\Track;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        // Create a fake user
        $this->user = User::factory()->createOne();

        if (class_exists(\Database\Seeders\CategorySeeder::class)) {
            $this->seed(\Database\Seeders\CategorySeeder::class);
        }
    }

    public function testCreateTrackWithCategory()
    {
        $track = Track::factory()->sample()->make();
        $category = Category::inRandomOrder()->first();

        // Create track form is accessible
        $this->actingAs($this->user)
            ->get(route('app.tracks.create'))
            ->assertSuccessful();

        // Fails when category_id is missing
        $this->actingAs($this->user)
            ->post(route('app.tracks.store'), $track->only('title', 'artist', 'url'))
            ->assertRedirect()
            ->assertSessionHasErrors(['category_id']);

        // Fails with invalid category_id
        $this->actingAs($this->user)
            ->post(route('app.tracks.store'), array_merge(
                $track->only('title', 'artist', 'url'),
                ['category_id' => 584839]
            ))
            ->assertRedirect()
            ->assertSessionHasErrors(['category_id']);

        // Success with valid category_id
        $this->actingAs($this->user)
            ->followingRedirects()
            ->post(route('app.tracks.store'), array_merge(
                $track->only('title', 'artist', 'url'),
                ['category_id' => $category->id]
            ))
            ->assertSuccessful();
    }

    public function testShowTrackWithCategory()
    {
        $category = Category::inRandomOrder()->first();
        $track = Track::factory()
            ->state([
                'week_id' => $this->currentWeek->id, 
                'category_id' => $category->id
            ])
            ->sample()
            ->create();

        $this->actingAs($this->user)
            ->get(route('app.tracks.show', [
                'week' => $this->currentWeek->uri,
                'track' => $track
            ]))
            ->assertSuccessful()
            ->assertSee($category->name);
    }

    public function testIndexCategory()
    {
        $this->actingAs($this->user)
            ->get('/categories')
            ->assertSuccessful();
    }

    public function testShowCategory()
    {
        $category = Category::inRandomOrder()->first();

        $this->actingAs($this->user)
            ->get("/categories/{$category->id}")
            ->assertSuccessful();
    }

    public function testShowWeekTracksWithCategory()
    {
        $category = Category::inRandomOrder()->first();
        $track = Track::factory()
            ->state([
                'week_id' => $this->currentWeek->id, 
                'category_id' => $category->id
            ])
            ->sample()
            ->create();

        $this->actingAs($this->user)
            ->get(route('app.weeks.show', [
                'week' => $this->currentWeek->uri,
            ]))
            ->assertSuccessful()
            ->assertSee($category->name);
    }
}