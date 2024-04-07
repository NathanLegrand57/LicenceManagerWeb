<x-app-layout>
    <p class="mt-10 ml-10 mb-10">
        <a class="bg-red-600 hover:bg-red-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-1 px-2 rounded"
            href="{{ route('mes-licences.index') }}">Retour</a>
    </p>

    {{-- Section renouvellement de licence --}}

    @if (session('demandeRenouvellement'))
        @php
            $demandeRenouvellement = session('demandeRenouvellement');
        @endphp

        <h1 class="text-center text-3xl font-semibold">Détails de la demande de renouvellement :</h1>
        <div class="flex justify-center mt-8">
            <div class="w-4/12 text-md bg-white p-6 mt-6 rounded-lg shadow-md leading-8">
                <p class="text-gray-700 text-sm sm:text-md"><strong>Libellé de la licence :</strong>
                    {{ $demandeRenouvellement->licence->libelle }}</p>
                @if ($demandeRenouvellement->duree > 31)
                    <h5 class="text-gray-700"><strong>Licence annuelle</strong></h5>
                @else
                    <h5 class="text-gray-700"><strong>Licence mensuelle</strong></h5>
                @endif

                <p class="text-gray-700 text-sm sm:text-md"><strong>Prix total :</strong>
                    {{ $demandeRenouvellement->licence->prix }}€</p>

                <div class="mt-2 mb-4">
                    <form action="{{ route('demande-licence.store') }}" method="POST">
                        @csrf
                        <label for="date_debut_licence"><strong>Début de la licence :</strong></label><br />
                        <input class="rounded" type="date" name="date_debut_licence" id="date_debut_licence"
                            required>
                </div>
                @error('date_debut_licence')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror

                <label class="text-gray-700" for="date_debut_licence"><strong>Expiration de la licence
                        :</strong></label><br />
                <input class="rounded" type="date" name="date_fin_licence" id="date_fin_licence" readonly>
                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 duration-500 text-white font-bold py-0 px-4 rounded mt-6 flex justify-center">Confirmer
                        la
                        demande</button>
                </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('date_debut_licence').addEventListener('change', function() {
                var dateDebut = new Date(this.value);
                var dureeLicence = {{ $demandeRenouvellement->duree }};
                var dateFin = new Date(dateDebut.getTime() + dureeLicence * 24 * 60 * 60 *
                    1000); // Calcul de la date de fin
                var dateFinFormatted = dateFin.toISOString().slice(0, 10); // Formatage de la date de fin (YYYY-MM-DD)
                document.getElementById('date_fin_licence').value =
                    dateFinFormatted;
            });
        </script>
    @endif

    {{-- Section ajout de licence --}}

    @if (session('demandeAjout'))
        @php
            $demandeAjout = session('demandeAjout');
        @endphp
        <h1 class="text-center text-xl min-[475px]:text-2xl sm:text-3xl font-semibold">Détails de la demande d'ajout :
        </h1>
        <div class="flex justify-center min-[475px]:mt-8">
            <div class="text-md bg-white p-6 mt-6 rounded-lg shadow-md leading-8 sm:leading-10">
                <p class="text-gray-700 text-sm min-[475px]:text-base sm:text-lg"><strong>Libellé de la licence
                        :</strong>
                    {{ $demandeAjout->libelle }}</p>
                @if ($demandeAjout->duree > 31)
                    <p class="text-sm min-[475px]:text-base sm:text-lg"><strong>Licence annuelle</strong></p>
                @else
                    <p class="text-sm min-[475px]:text-base sm:text-lg"><strong>Licence mensuelle</strong></p>
                @endif
                <p class="text-gray-700 text-sm min-[475px]:text-base sm:text-lg"><strong>Produit :</strong>
                    {{ $demandeAjout->produit }}</p>
                <p class="text-gray-700 text-sm min-[475px]:text-base sm:text-lg"><strong>Prix total :</strong>
                    {{ $demandeAjout->prix }}€</p>

                <div class="min-[475px]:flex justify-center min-[475px]:mt-6 min-[475px]:mb-4 gap-2 sm:gap-10">
                    <div class="flex justify-center">
                        <form action="{{ route('demande-licence.store') }}" method="POST">
                            @csrf
                            <label class="text-sm min-[475px]:text-base sm:text-lg"
                                for="date_debut_licence"><strong>Début de la licence :</strong></label><br />
                            <input class="rounded text-sm min-[475px]:text-base sm:text-lg" type="date"
                                name="date_debut_licence" id="date_debut_licence" required>
                    </div>
                    @error('date_debut_licence')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-center">
                        <div>
                            <label class="text-sm min-[475px]:text-base sm:text-lg" class="text-gray-700"
                                for="date_debut_licence"><strong>Expiration de la licence
                                    :</strong></label><br />
                            <input class="rounded text-sm min-[475px]:text-base sm:text-lg" type="date"
                                name="date_fin_licence" id="date_fin_licence" readonly>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 duration-500 text-sm min-[475px]:text-base sm:text-lg text-white font-bold py-1 px-2 rounded mt-6 flex justify-center">Confirmer
                        la
                        demande</button>
                </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('date_debut_licence').addEventListener('change', function() {
                var dateDebut = new Date(this.value);
                var dureeLicence = {{ $demandeAjout->duree }};
                var dateFin = new Date(dateDebut.getTime() + dureeLicence * 24 * 60 * 60 *
                    1000); // Calcul de la date de fin
                var dateFinFormatted = dateFin.toISOString().slice(0, 10); // Formatage de la date de fin (YYYY-MM-DD)
                document.getElementById('date_fin_licence').value =
                    dateFinFormatted;
            });
        </script>
    @endif

    @if (Session::has('success'))
        <div class="flex h-60">
            <div class="text-green-500 text-center m-auto">
                <p class="text-xl">Votre demande a bien été prise en compte !</p>
                <p class="text-gray-700 text-sm sm:text-md">Vous allez être redirigé vers la liste de vos licences dans
                    quelques secondes
                </p>
            </div>
        </div>
        <script>
            setTimeout(function() {
                window.location.href =
                    "{{ route('mes-licences.index') }}"; // Redirection vers la page mes-licences après 4 secondes
            }, 4000);
        </script>
    @endif
</x-app-layout>
