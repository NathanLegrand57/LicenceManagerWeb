<x-app-layout>
    <h1 class="text-4xl font-semibold text-center mt-14 mb-10">Licences disponibles</h1>

    <section class="w-fit mx-auto grid grid-cols-1 md:grid-cols-2 justify-items-center gap-y-10 gap-x-10 mt-10 mb-20">
        @forelse ($licences as $licence)
            <div class="">
                <div class="bg-white p-6 mt-6 rounded-lg shadow-md leading-7">
                    <h5 class="text-xl font-semibold">{{ $licence->libelle }}</h5>
                    @if ($licence->duree > 31)
                        <h5 class="text-gray-700">Licence annuelle</h5>
                    @else
                        <h5 class="text-gray-700">Licence mensuelle</h5>
                    @endif
                    <h5 class="text-gray-700">Produit : {{ $licence->produit->libelle }}</h5>
                    <h5 class="text-gray-500 mb-4">{{ $licence->produit->description }}</h5>

                    <div class="flex items-end" flex-end;">
                        <p class="">
                            <a class="bg-blue-500 my-auto hover:bg-blue-700 duration-500 text-white text-sm font-bold py-1 px-2 rounded"
                                href="{{ route('licence.index') }}">En savoir plus</a>
                            {{-- Changer la route en .show --}}
                        </p>
                        <div class="justify-center ml-auto">
                            <h5 class="text-gray-700 text-lg font-semibold flex justify-center">{{ $licence->prix }}.00
                                €</h5>
                            <p>
                            <form action="{{ route('demande-licence.ajouter', ['licence' => $licence->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 duration-500 text-white text-sm font-bold py-1 px-2 rounded mt-1">Demander</button>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="btn-toolbar">

                    </div>
                </div>
            </div>
        @empty
            <p class="ms-3">
                Aucun produit connu
            </p>
        @endforelse
    </section>



</x-app-layout>
