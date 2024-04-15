<?php

namespace Tests\Feature;

use App\Models\DemandeLicence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Tests\TestCase;

class LicenceChoisieTest extends TestCase
{
    public function test_licencechoisie_index_method_returns_correct_view()
    {
        $user = User::factory()->create();
        Bouncer::refresh();

        $response = $this
            ->actingAs($user)
            ->get('/mes-licences');

        $response->assertStatus(200);
        $response->assertViewIs('licence-choisie.index');
    }

}
