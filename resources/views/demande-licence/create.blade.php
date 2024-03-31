<x-app-layout>
    @if (session('demandeRenouvellement'))
        <!-- Afficher les détails de la demande de renouvellement -->
        @php
            $demandeRenouvellement = session('demandeRenouvellement');
        @endphp

        <h2>Détails de la demande de renouvellement :</h2>
        <p>Libellé de la licence : {{ $demandeRenouvellement->licence->libelle }}</p>
        <p>Durée : {{ $demandeRenouvellement->licence->duree }} jours</p>
        <p>Prix : {{ $demandeRenouvellement->licence->prix }}€</p>
        <!-- Vérifiez si la nouvelle date de fin est définie avant de l'afficher -->
        <p>Nouvelle date de fin prévue : {{ $demandeRenouvellement->date_fin_licence->format('d/m/Y') }}</p>

        <form action="{{ route('demande-licence.store') }}"
            method="POST">
            @csrf
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mt-6">Confirmer la demande de renouvellement</button>
        </form>
    @endif
</x-app-layout>
