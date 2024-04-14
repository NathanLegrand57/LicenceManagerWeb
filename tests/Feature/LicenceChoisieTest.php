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

    public function test_user_can_accept_demande(): void
    {
        $user = User::factory()->create();
        $demandelicence = DemandeLicence::factory()->create();
        Bouncer::refresh();

        $response = $this;
        $this->actingAs($user);
        $response = $this->post('/demande-licence', [
            'date_debut' => $demandelicence->date_debut_licence,
            'date_fin' => $demandelicence->date_fin_licence,
            'licence_id' => $demandelicence->licence_id,
            'user_id' => $demandelicence->user_id,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

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
