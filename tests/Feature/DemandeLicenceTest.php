<?php

namespace Tests\Feature;

use App\Models\DemandeLicence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Tests\TestCase;

class DemandeLicenceTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_access_demande_licence_index_for_employe(): void
    {
        $user = User::factory()->create();
        Bouncer::assign('employe')->to($user);
        Bouncer::allow('employe')->to('gerer-demandes');
        Bouncer::refresh();
        $response = $this
            ->actingAs($user)
            ->get('/demande-licence');

        $response->assertOk();
    }

    public function test_access_demande_licence_index_for_admin(): void
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::allow('admin')->to('gerer-demandes');
        Bouncer::refresh();
        $response = $this
            ->actingAs($user)
            ->get('/demande-licence');

        $response->assertOk();
    }

    public function test_dont_access_demande_licence_index_for_user_without_abilities(): void
    {
        $user = User::factory()->create();
        Bouncer::refresh();

        $response = $this
            ->actingAs($user)
            ->get('/demande-licence');

        $response->assertStatus(401);
    }

    public function test_demande_licence_create_method_returns_correct_view()
    {
        $user = User::factory()->create();
        Bouncer::refresh();

        $response = $this
            ->actingAs($user)
            ->get('/demande-licence/create');

        $response->assertStatus(200);
        $response->assertViewIs('demande-licence.create');
    }

    public function test_user_can_create_demande(): void
    {
        $user = User::factory()->create();
        Bouncer::refresh();

        $response = $this;
        $this->actingAs($user);
        $response = $this->post('/demande-licence', [
            'type_demande' => 'demandeTest',
            'date_debut_licence' => '13/04/2024',
            'date_fin_licence' => '13/05-2024',
            'licencechoisie_id' => '1',
            'licence_id' => '1',
            'user_id' => '1',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
    }

    public function test_access_demande_licence_cant_be_destroyed_for_user_without_abilities(): void
    {

        // Création d'un utilisateur avec les rôles nécessaires
        $user = User::factory()->create();
        Bouncer::refresh();

        // Création d'une licence
        $demandelicence = DemandeLicence::factory()->create();

        // Requête DELETE pour détruire la demande-licence
        $response = $this
            ->actingAs($user)
            ->delete("/demande-licence/{$demandelicence->id}");

        $response->assertStatus(302);
    }

    public function test_demande_licence_can_be_destroyed(): void
    {

        // Création d'un utilisateur avec les rôles nécessaires
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::allow('admin')->to('gerer-demandes');
        Bouncer::refresh();

        // Création d'une licence
        $demandelicence = DemandeLicence::factory()->create();

        // Vérification que la demande de licence existe avant la destruction
        $this->assertDatabaseHas('licences', ['id' => $demandelicence->id]);

        // Requête DELETE pour détruire la demande de licence
        $response = $this
            ->actingAs($user)
            ->delete("/demande-licence/{$demandelicence->id}");

        // Assurer une redirection après la destruction
        $response->assertRedirect('/demande-licence');

        // Vérification que la colonne deleted_at de la demande de licence supprimée s'actualise
        $this->assertNotNull(DemandeLicence::withTrashed()->find($demandelicence->id)->deleted_at);
    }
}
