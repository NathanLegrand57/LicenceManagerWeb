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
            <p>Prix total : {{ $demandeRenouvellement->licence->prix }}€</p>

            <form action="{{ route('demande-licence.store') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-6">Confirmer la
                    demande de
                    renouvellement</button>
            </form>
        </div>
    @endif

    @if (session('demandeAjout'))
        @php
            $demandeAjout = session('demandeAjout');
        @endphp

        <div class="text-center text-lg ">
            <h2>Détails de la demande d'ajout :</h2>
            <p>Libellé de la licence : {{ $demandeAjout->libelle }}</p>
            @if ($demandeAjout->duree > 31)
                <h5 class="text-gray-700">Licence annuelle</h5>
            @else
                <h5 class="text-gray-700">Licence mensuelle</h5>
            @endif
            <p>Produit : {{ $demandeAjout->produit }}</p>
            <input type="date" name="date_debut_licence" id="date_debut_licence">
            {{-- <p>Nouvelle date d'expiration prévue : {{ $demandeAjout->date_fin_licence->format('d/m/Y') }}</p> --}}
            <p>Prix total : {{ $demandeAjout->prix }}€</p>

            <form action="{{ route('demande-licence.store') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-6">Confirmer la
                    demande d'ajout</button>
            </form>
        </div>
    @endif

    @if (Session::has('success'))
        <div class="text-green-500 text-center">
            <p class="text-xl">Votre demande a bien été prise en compte !</p>
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
