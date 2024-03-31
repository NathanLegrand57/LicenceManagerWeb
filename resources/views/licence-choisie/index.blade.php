<x-app-layout>
    <div class="flex flex-wrap justify-center">
        <h1 class="text-xl font-semibold">Mes licences</h1>
        @forelse ($licences_choisies as $licence_choisie)
            <div class="bg-white mt-6 rounded-lg shadow-md overflow-hidden m-3 flex-grow">
                <div class="p-6">
                    <h5 class="text-xl font-semibold mb-2">{{ __('Libellé de la licence') }} :
                        {{ $licence_choisie->licence->libelle }}</h5>
                    <p class="text-gray-700">Début de la souscription :
                        {{ \Carbon\Carbon::parse($licence_choisie->date_debut)->format('d/m/Y') }}</p>
                    <p class="text-gray-700">Fin de la souscription :
                        {{ \Carbon\Carbon::parse($licence_choisie->date_fin)->format('d/m/Y') }}</p>
                    @if ($licence_choisie->jours_restants <= 0)
                        <p class="text-blue-400">Licence expirée</p>
                        <form
                            action="{{ route('demande-licence.renouveler', ['licenceChoisie' => $licence_choisie->id]) }}"
                            method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mt-6">Renouveler</button>
                        </form>
                    @elseif ($licence_choisie->jours_restants <= 5)
                        <p class="text-gray-700">Jours restants avant expiration de la licence :
                        <span class="text-red-500">{{ $licence_choisie->jours_restants }}</span></p>
                        <form
                            action="{{ route('demande-licence.renouveler', ['licenceChoisie' => $licence_choisie->id]) }}"
                            method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mt-6">Renouveler</button>
                        </form>
                    @else
                        <p class="text-gray-700">Jours restants avant expiration de la licence :
                            {{ $licence_choisie->jours_restants }}</p>
                    @endif
                </div>
            </div>
        @empty
            <p class="ms-3">
                Aucune licence connue
            </p>
        @endforelse
    </div>
</x-app-layout>
