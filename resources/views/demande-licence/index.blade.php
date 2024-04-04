<x-app-layout>
    <h1 class="text-3xl font-semibold text-center mt-14 mb-10">Demandes de licences disponibles</h1>

    <section class="w-fit mx-auto grid grid-cols-1 md:grid-cols-2 justify-items-center gap-y-10 gap-x-10 mt-10 mb-20">
        @forelse ($demandes_licences as $demande_licence)
            <div class="bg-white p-6 mt-6 rounded-lg shadow-md leading-8">
                <h5 class="text-xl font-semibold mb-2">
                    {{ $demande_licence->type_demande }}</h5>
                <p>Licence demandée : {{ $demande_licence->licence->libelle }}</p>
                <p class="text-gray-700">Début de la souscription :
                    {{ \Carbon\Carbon::parse($demande_licence->date_debut)->format('d/m/Y') }}</p>
                <p class="text-gray-700">Fin de la souscription :
                    {{ \Carbon\Carbon::parse($demande_licence->date_fin)->format('d/m/Y') }}</p>
                <p>Entreprise souhaitant : {{ $demande_licence->user->libelle }}</p>
                <div class="flex mt-4 items-end justify-between">
                    <form method="POST" action="{{ route('demande-licence.destroy', $demande_licence) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-red-600 font-semibold py-0 px-4 rounded">Refuser</button>
                    </form>
                    <form action="{{ route('mes-licences.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="demandeLicenceId" value="{{ $demande_licence->id }}">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 duration-500 text-white font-semibold py-0 px-2 rounded mt-6">Accepter</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 text-center">
                <p class="text-center">
                    Aucune demande connue
                </p>
            </div>
        @endforelse
    </section>
</x-app-layout>
