<x-app-layout>

    <div class="flex gap-4 justify-between mt-4 sm:mt-10">
        <p class="ml-10">
            <a class="bg-red-600 hover:bg-red-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-1 px-2 rounded"
                href="{{ route('mes-licences.index') }}">Retour</a>
        </p>
        @can('create-licence')
            <p>
                <a class="bg-green-600 hover:bg-green-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-1 px-2 rounded min-[475px]:mr-20"
                    href="{{ route('licence.create') }}">Créer une licence</a>
            </p>
        @endcan
    </div>
    <h1 class="text-xl min-[475px]:text-2xl sm:text-3xl font-semibold text-center mb-0 sm:mb-10 mt-4 sm:mt-5">Licences
        disponibles</h1>

    <section
        class="w-fit mx-auto grid grid-cols-1 md:grid-cols-2 justify-items-center gap-y-2 sm:gap-y-10 gap-x-10 mt-0 sm:mt-10 mb-20">
        @forelse ($licences as $licence)
            <div
                class="min-w-full bg-white p-6 mt-6 rounded-lg shadow-md text-sm min-[475px]:text-base sm:text-lg leading-6 min-[475px]:leading-8">
                <h5 class="min-[475px]:text-lg sm:text-xl font-semibold">{{ $licence->libelle }}</h5>
                {{-- <h5 class="min-[475px]:text-lg sm:text-xl font-semibold">{{ $licence['libelle'] }}</h5> --}}
                @if ($licence->duree > 31)
                    <p class="text-gray-700"><strong>Licence annuelle</strong></p>
                @else
                    <p class="text-gray-700"><strong>Licence mensuelle</strong></p>
                @endif
                <p class="text-gray-700"><strong>Produit :</strong> {{ $licence->produit->libelle }}</p>

                <div class="flex items-end mt-2">
                    <p>
                        <a class="bg-blue-500 my-auto hover:bg-blue-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-1 px-2 rounded"
                            href="{{ route('licence.show', [$licence->id]) }}">En savoir plus</a>
                    </p>
                    <div class="justify-center ml-auto">
                        <p class="text-gray-700 font-semibold flex justify-center">{{ $licence->prix }} €</p>
                        <p>
                        <form action="{{ route('demande-licence.ajouter', ['licence' => $licence->id]) }}"
                            method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-0.5 px-2 rounded mt-1">Demander</button>
                        </form>
                        </p>
                    </div>
                </div>

                @can('delete-licence')
                    <div class="flex justify-end mt-2">
                        <form method="POST" action="{{ route('licence.destroy', $licence) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-white text-sm min-[475px]:text-base sm:text-lg bg-red-600 hover:bg-red-700 duration-500 font-semibold py-0.5 px-2 rounded">Supprimer</button>
                        </form>
                    </div>
                @endcan
            </div>
        @empty
            <p class="ms-3 text-sm min-[475px]:text-base sm:text-lg text-center">
                Aucune licence connue
            </p>
        @endforelse
    </section>



</x-app-layout>
