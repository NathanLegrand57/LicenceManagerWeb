<x-app-layout>

    <div class="flex justify-between mt-10">
        <p class="ml-10">
            <a class="bg-red-600 hover:bg-red-700 duration-500 text-white font-bold py-1 px-2 rounded"
                href="{{ route('mes-licences.index') }}">Retour</a>
        </p>
        @can('create-licence')
            <p class="ml-10">
                <a class="bg-green-600 hover:bg-green-700 duration-500 text-white font-bold py-1 px-2 rounded mr-20"
                    href="{{ route('licence.create') }}">Créer une licence</a>
            </p>
        @endcan
    </div>
    <h1 class="text-3xl font-semibold text-center mt-10 mb-10">Licences disponibles</h1>

    <section class="w-fit mx-auto grid grid-cols-1 md:grid-cols-2 justify-items-center gap-y-10 gap-x-10 mt-10 mb-20">
        @forelse ($licences as $licence)
            <div class="bg-white p-6 mt-6 rounded-lg shadow-md leading-7">
                <h5 class="text-xl font-semibold">{{ $licence->libelle }}</h5>
                @if ($licence->duree > 31)
                    <h5 class="text-gray-700"><strong>Licence annuelle</strong></h5>
                @else
                    <h5 class="text-gray-700"><strong>Licence mensuelle</strong></h5>
                @endif
                <h5 class="text-gray-700"><strong>Produit :</strong> {{ $licence->produit->libelle }}</h5>
                <h5 class="text-gray-500 mb-4">{{ $licence->produit->description }}</h5>

                <div class="flex items-end">
                    <p>
                        <a class="bg-blue-500 my-auto hover:bg-blue-700 duration-500 text-white font-bold py-1 px-2 rounded"
                            href="{{ route('licence.index') }}">En savoir plus</a>
                        {{-- Changer la route en .show --}}
                    </p>
                    <div class="justify-center ml-auto">
                        <h5 class="text-gray-700 text-lg font-semibold flex justify-center">{{ $licence->prix }}
                            €</h5>
                        <p>
                        <form action="{{ route('demande-licence.ajouter', ['licence' => $licence->id]) }}"
                            method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 duration-500 text-white font-bold py-0 px-2 rounded mt-1">Demander</button>
                        </form>
                        </p>
                    </div>
                </div>

                <div class="btn-toolbar">

                </div>
            </div>
        @empty
            <p class="ms-3">
                Aucun produit connu
            </p>
        @endforelse
    </section>



</x-app-layout>
