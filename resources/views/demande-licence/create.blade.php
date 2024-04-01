<x-app-layout>
    @if (session('demandeRenouvellement'))
        @php
            $demandeRenouvellement = session('demandeRenouvellement');
        @endphp

        <div class="text-center text-lg ">
            <h2>Détails de la demande de renouvellement :</h2>
            <p>Libellé de la licence : {{ $demandeRenouvellement->licence->libelle }}</p>
            <p>Durée : {{ $demandeRenouvellement->licence->duree }} jours</p>
            <p>Nouvelle date d'expiration prévue : {{ $demandeRenouvellement->date_fin_licence->format('d/m/Y') }}</p>
            <p>Prix : {{ $demandeRenouvellement->licence->prix }}€</p>

            <form action="{{ route('demande-licence.store') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mt-6">Confirmer la demande de
                    renouvellement</button>
            </form>
        </div>
    @endif

    @if (Session::has('success'))
        <div class="text-green-500">
            <p class=" text-xl">Votre demande de renouvellement de licence a bien été prise en compte !</p>
            <p>Vous allez être redirigé vers la liste de vos licences dans quelques secondes</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href =
                "{{ route('mes-licences.index') }}"; // Redirection vers la page mes-licences après 4 secondes
            }, 4000);
        </script>
    @endif
</x-app-layout>
