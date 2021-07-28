<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ViewAchievementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function aUserCanViewTheirAchievements()
    {
        $user = User::factory()->create();

        $this->get("/users/{$user->id}/achievements")
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->whereAllType([
                'unlocked_achievements' => 'array',
                'next_available_achievements' => 'array',
                'current_badge' => 'string',
                'next_badge' => 'string',
                'remaining_to_unlock_next_badge' => 'integer',
            ]);
        });
    }
}
