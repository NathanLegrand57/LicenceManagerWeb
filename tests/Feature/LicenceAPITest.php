<?php

namespace Tests\Feature;

use App\Models\Licence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Tests\TestCase;

class LicenceAPITest extends TestCase
{
    public function test_licence_API_index_method_returns_correct_view()
    {
        $user = User::factory()->create();
        Bouncer::refresh();

        $response = $this
            ->actingAs($user)
            ->get('/api/licences');

        $response->assertStatus(200);
        $response->assertOk();
    }
}
