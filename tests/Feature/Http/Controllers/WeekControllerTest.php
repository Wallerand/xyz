<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeekControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure user is redirected to login form.
     */
    public function test_redirect_if_unauthenticated(): void
    {
        $this->get(route('app.weeks.index'))->assertRedirectToRoute('login');
    }

    /**
     * Ensure user can show current week ranking.
     */
    public function test_week(): void
    {
        /** @var User */
        $user = User::factory()->createOne();

        $this->actingAs($user)->get(route('app.weeks.index'))
            ->assertRedirectToRoute('app.weeks.show', [
                'week' => date('Y/W') // Current week URI
            ]);
    }

    /**
     * Ensure user can show a week ranking.
     */
    public function test_week_show(): void
    {
        /** @var User */
        $user = User::factory()->createOne();

        $this->actingAs($user)->get(route('app.weeks.show', [
                'week' => $this->currentWeek->uri
            ]))
            ->assertSuccessful();
    }
}
