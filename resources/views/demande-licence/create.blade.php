<x-app-layout>
    @if(session('demandeRenouvellement'))
        <!-- Afficher les détails de la demande de renouvellement -->
        @php
            $demandeRenouvellement = session('demandeRenouvellement');
        @endphp

        <h2>Détails de la demande de renouvellement :</h2>
        <p>Libellé de la licence : {{ $demandeRenouvellement->licence->libelle }}</p>
    @endif
</x-app-layout>
