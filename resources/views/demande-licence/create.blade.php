<x-app-layout>
    <p class="mt-4 sm:mt-10 ml-10 mb-10">
        <a class="bg-red-600 hover:bg-red-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-1 px-2 rounded"
            href="{{ route('mes-licences.index') }}">Retour</a>
    </p>

    {{-- Section renouvellement de licence --}}

    @if (session('demandeRenouvellement'))
        @php
            $demandeRenouvellement = session('demandeRenouvellement');
        @endphp

        <h1 class="text-center text-xl min-[475px]:text-2xl sm:text-3xl font-semibold">Détails de la demande de
            renouvellement :</h1>
        <div class="flex justify-center min-[475px]:mt-8">
            <div
                class="bg-white text-sm min-[475px]:text-base sm:text-lg p-6 mt-6 rounded-lg shadow-md leading-6 min-[475px]:leading-8">
                <p class="text-gray-700"><strong>Libellé de la licence :</strong>
                    {{ $demandeRenouvellement->licence->libelle }}</p>
                @if ($demandeRenouvellement->duree > 31)
                    <p class="text-gray-700"><strong>Licence annuelle</strong></p>
                @else
                    <p class="text-gray-700"><strong>Licence mensuelle</strong></p>
                @endif

                <p class="text-gray-700"><strong>Prix total :</strong>
                    {{ $demandeRenouvellement->licence->prix }}€</p>

                <div class="min-[475px]:flex justify-center mt-2 min-[475px]:mt-6 min-[475px]:mb-4 gap-2 sm:gap-10">
                    <div>
                        <form action="{{ route('demande-licence.store') }}" method="POST">
                            @csrf
                            <p class="text-gray-700 text-center"><strong>Début de la licence :</strong></p>
                            <div class="flex justify-center">
                                <input class="rounded text-sm min-[475px]:text-base sm:text-lg" type="date"
                                    name="date_debut_licence" id="date_debut_licence" required>
                            </div>
                    </div>

                    <div class="mt-2 min-[475px]:mt-0">
                        <p class="text-gray-700 text-center"><strong>Expiration de la licence :</strong></p>
                        <div class="flex justify-center">
                            <input class="rounded text-sm min-[475px]:text-base sm:text-lg" type="date"
                                name="date_fin_licence" id="date_fin_licence" readonly>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 duration-500 text-white font-bold py-1 px-2 rounded mt-6 flex justify-center">Confirmer
                        la
                        demande</button>
                </div>
                </form>
                @error('date_debut_licence')
                    <p class="text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Calcul dynamique de la date de fin de la licence --}}

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
            <div
                class="text-md bg-white text-sm min-[475px]:text-base sm:text-lg p-6 mt-6 rounded-lg shadow-md leading-6 min-[475px]:leading-8">
                <p class="text-gray-700"><strong>Libellé de la licence :</strong>
                    {{ $demandeAjout->libelle }}</p>
                @if ($demandeAjout->duree > 31)
                    <p class="text-gray-700"><strong>Licence annuelle</strong></p>
                @else
                    <p class="text-gray-700"><strong>Licence mensuelle</strong></p>
                @endif
                <p class="text-gray-700"><strong>Produit :</strong>
                    {{ $demandeAjout->produit }}</p>
                <p class="text-gray-700"><strong>Prix total :</strong>
                    {{ $demandeAjout->prix }}€</p>

                <div class="min-[475px]:flex justify-center mt-2 min-[475px]:mt-6 min-[475px]:mb-4 gap-2 sm:gap-10">
                    <div>
                        <form action="{{ route('demande-licence.store') }}" method="POST">
                            @csrf
                            <p class="text-gray-700 text-center"><strong>Début de la licence :</strong></p>
                            <div class="flex justify-center">
                                <input class="rounded text-sm min-[475px]:text-base sm:text-lg" type="date"
                                    name="date_debut_licence" id="date_debut_licence" required>
                            </div>
                    </div>

                    <div class="mt-2 min-[475px]:mt-0">
                        <p class="text-gray-700 text-center"><strong>Expiration de la licence :</strong></p>
                        <div class="flex justify-center">
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
                @error('date_debut_licence')
                    <p class="text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Calcul dynamique de la date de fin de la licence --}}

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

        {{-- Message de succès qui redirige par la suite vers la page des licences choisies --}}

    @if (Session::has('success'))
        <div class="flex h-60">
            <div class="text-green-500 text-center m-auto">
                <p class="text-base min-[475px]:text-lg sm:text-xl">Votre demande a bien été prise en compte !</p>
                <p class="text-gray-700 text-sm min-[475px]:text-base sm:text-lg">Vous allez être redirigé vers la liste
                    de vos licences dans quelques secondes
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
