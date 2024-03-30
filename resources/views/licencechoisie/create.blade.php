<x-app-layout>
    <div class="flex flex-wrap justify-center">
        <h1 class="">Mes licences</h1>
        @forelse ($licences_choisies as $licence_choisie)
            <div class="bg-white mt-6 rounded-lg shadow-md overflow-hidden m-3 flex-grow">
                <div class="p-6">
                    <h5 class="text-xl font-semibold mb-2">{{ __('Libellé de la licence') }} :
                        {{ $licence_choisie->licence->libelle }}</h5>
                    <p class="text-gray-700">Date de souscription : {{ \Carbon\Carbon::parse($licence_choisie->date_debut)->format('d/m/Y') }}</p>
                    <p class="text-gray-700">{{ \Carbon\Carbon::parse($licence_choisie->date_fin)->format('d/m/Y') }}</p>
                    @if($licence_choisie->jours_restants <= 0)
                        <p class="text-blue-400">Licence expirée</p>
                    @else
                        <p class="text-gray-700">Jours restants : {{ $licence_choisie->jours_restants }}</p>
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
