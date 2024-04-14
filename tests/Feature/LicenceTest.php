<?php

namespace Tests\Feature;

use App\Models\Licence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Tests\TestCase;

class LicenceTest extends TestCase
{
    public function test_licence_index_method_returns_correct_view()
    {
        $user = User::factory()->create();
        Bouncer::refresh();

        $response = $this
            ->actingAs($user)
            ->get('/licence');

        $response->assertStatus(200);
        $response->assertViewIs('licence.index');
    }

    public function test_licence_show_for_user(): void
    {
        $user = User::factory()->create();
        $licence = Licence::factory()->create();
        Bouncer::refresh();

        $response = $this
            ->actingAs($user)
            ->get('/licence/' . $licence->id);

        $response->assertOk();
    }

    public function test_dont_access_licence_create_for_user_without_abilities(): void
    {
        $user = User::factory()->create();
        Bouncer::refresh();

        $response = $this
            ->actingAs($user)
            ->get('/licence/create');

        $response->assertStatus(401);
    }

    public function test_access_licence_create_for_user(): void
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::allow('admin')->to('create-licence');
        Bouncer::refresh();
        $response = $this
            ->actingAs($user)
            ->get('/licence/create');

        $response->assertOk();
    }

    public function test_user_can_create_licence(): void
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::allow('admin')->to('create-licence');
        Bouncer::refresh();

        $response = $this;
        $this->actingAs($user);
        $response = $this->post('/licence', [
            'libelle' => 'libelleTest',
            'prix' => '3.90',
            'duree' => '31',
            'produit_id' => '1',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/licence');
    }

    public function test_access_licence_cant_be_destroyed_for_user_without_abilities(): void
    {

        // Création d'un utilisateur avec les rôles nécessaires
        $user = User::factory()->create();
        Bouncer::refresh();

        // Création d'une licence
        $licence = Licence::factory()->create();

        // Requête DELETE pour détruire la licence
        $response = $this
            ->actingAs($user)
            ->delete("/licence/{$licence->id}");

        $response->assertStatus(302);
    }

    public function test_produit_can_be_destroyed(): void
    {

        // Création d'un utilisateur avec les rôles nécessaires
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::allow('admin')->to('delete-licence');
        Bouncer::refresh();

        // Création d'une licence
        $licence = Licence::factory()->create();

        // Vérification que la licence existe avant la destruction
        $this->assertDatabaseHas('licences', ['id' => $licence->id]);

        // Requête DELETE pour détruire la licence
        $response = $this
            ->actingAs($user)
            ->delete("/licence/{$licence->id}");

        // Assurer une redirection après la destruction
        $response->assertRedirect('/licence');

        // Vérification que la colonne deleted_at du licence supprimé s'actualise
        $this->assertNotNull(Licence::withTrashed()->find($licence->id)->deleted_at);
    }

}
