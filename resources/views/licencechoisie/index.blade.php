<x-app-layout>
    <div class="flex flex-wrap justify-center">
        <h1 class="text-9xl">Mes licences</h1>
        @forelse ($licences_choisies as $licence_choisie)
            <div class="bg-white mt-6 rounded-lg shadow-md overflow-hidden m-3 flex-grow">
                <div class="p-6">
                    <h5 class="text-xl font-semibold mb-2">{{ __('Libellé de la licence') }} :
                        {{ $licence_choisie->licence->libelle }}</h5>
                    <p class="text-gray-700">{{ $licence_choisie->description }}</p>
                    <p class="text-gray-700">{{ $licence_choisie->date_debut }}</p>
                    <p class="text-gray-700">{{ $licence_choisie->date_fin }}</p>
                </div>
            </div>
        @empty
            <p class="ms-3">
                Aucune licence connue
            </p>
        @endforelse
    </div>
</x-app-layout>
