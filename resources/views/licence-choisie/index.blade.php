<x-app-layout>
    <p class="flex justify-center sm:justify-end mt-4 sm:mt-10 sm:mr-20">
        <a class="bg-green-600 hover:bg-green-700 duration-500 text-white text-sm min-[475px]:text-base font-bold py-1 px-2 rounded"
            href="{{ route('licence.index') }}">Demander une licence</a>
    </p>
    <h1 class="text-xl min-[475px]:text-2xl sm:text-3xl font-semibold text-center mb-0 sm:mb-10 mt-4 sm:mt-5">Mes
        licences</h1>

    <section
        class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-2 justify-items-center gap-y-2 sm:gap-y-10 gap-x-10 mt-0 sm:mt-10 mb-20">
        @forelse ($licences_choisies as $licence_choisie)
            <div
                class="min-w-full bg-white text-sm min-[475px]:text-base sm:text-lg p-6 mt-6 rounded-lg shadow-md leading-6 min-[475px]:leading-8">
                <h5 class="text-base min-[475px]:text-lg sm:text-xl font-semibold mb-2">
                    {{ $licence_choisie->licence->libelle }}</h5>

                <p class="text-gray-700"><strong>Début de la souscription :</strong>
                    {{ \Carbon\Carbon::parse($licence_choisie->date_debut)->format('d/m/Y') }}</p>

                <p class="text-gray-700"><strong>Fin de la souscription :</strong>
                    {{ \Carbon\Carbon::parse($licence_choisie->date_fin)->format('d/m/Y') }}</p>

                @if ($licence_choisie->jours_restants <= 0)
                    <p class="text-red-500"><strong>Licence expirée</strong></p>
                    <form action="{{ route('demande-licence.renouveler', ['licenceChoisie' => $licence_choisie->id]) }}"
                        method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-0 px-2 rounded mt-0 sm:mt-6">Renouveler</button>
                    </form>
                @elseif ($licence_choisie->jours_restants <= 5)
                    <p class="text-gray-700"><strong>Jours restants avant expiration de la licence :</strong>
                        <span class="text-red-500">{{ $licence_choisie->jours_restants }}</span>
                    </p>
                    <p class="text-red-500"><strong>Attention ! La licence expire bientôt.</strong></p>
                    <form action="{{ route('demande-licence.renouveler', ['licenceChoisie' => $licence_choisie->id]) }}"
                        method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 duration-500 text-white font-bold py-0 px-2 rounded mt-2 sm:mt-6">Renouveler</button>
                    </form>
                @else
                    <p class="text-gray-700"><strong>Jours restants avant expiration de la licence :</strong>
                        {{ $licence_choisie->jours_restants }}</p>
                @endif
            </div>
        @empty

            <div class="md:col-span-2 text-center">
                <p class="text-center text-sm min-[475px]:text-base sm:text-lg">
                    Aucune licence connue
                </p>
            </div>
        @endforelse
    </section>
</x-app-layout>
