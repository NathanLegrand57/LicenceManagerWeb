<x-app-layout>
    <h1 class="text-center text-xl min-[475px]:text-2xl sm:text-3xl font-semibold mt-14 mb-10">Demandes de licences
        disponibles</h1>

    <section
        class="w-fit mx-auto grid grid-cols-1 md:grid-cols-2 justify-items-center gap-y-2 sm:gap-y-10 gap-x-10 mt-0 sm:mt-10 mb-20">
        @forelse ($demandes_licences as $demande_licence)
            <div
                class="bg-white p-6 mt-6 rounded-lg shadow-md text-sm min-[475px]:text-base sm:text-lg leading-6 min-[475px]:leading-8">
                <h5 class="min-[475px]:text-lg sm:text-xl font-semibold mb-2">
                    @if ($demande_licence->a_renouveler == 0)
                        Demande de renouvellement
                    @else
                        Demande d'ajout
                    @endif
                </h5>

                <p><strong>Licence demandée :</strong> {{ $demande_licence->licence->libelle }}</p>
                <p class="text-gray-700"><strong>Début de la souscription :</strong>
                    {{ \Carbon\Carbon::parse($demande_licence->date_debut_licence)->format('d/m/Y') }}</p>
                <p class="text-gray-700"><strong>Fin de la souscription :</strong>
                    {{ \Carbon\Carbon::parse($demande_licence->date_fin_licence)->format('d/m/Y') }}</p>
                <p><strong>Entreprise souhaitant :</strong> {{ $demande_licence->user->libelle }}</p>
                <div class="flex mt-4 items-end justify-between">
                    <form method="POST" action="{{ route('demande-licence.destroy', $demande_licence) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-white bg-red-600 font-semibold py-0 px-4 rounded">Refuser
                        </button>
                    </form>
                    @if ($demande_licence->a_renouveler == 0)
                        <form
                            action="{{ route('mes-licences.renouvelerLicenceClient', ['demandeRenouvellement' => $demande_licence->id]) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="demandeLicenceId" value="{{ $demande_licence->id }}">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 duration-500 text-white font-semibold py-0 px-2 rounded mt-6">
                                Accepter
                            </button>
                        </form>
                    @else
                        <form action="{{ route('mes-licences.ajouterLicenceClient') }}" method="POST">
                            @csrf
                            <input type="hidden" name="demandeLicenceId" value="{{ $demande_licence->id }}">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 duration-500 text-white font-semibold py-0 px-2 rounded mt-6">Accepter</button>
                        </form>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="md:col-span-2 text-center">
                <p class="text-center text-sm min-[475px]:text-base sm:text-lg">
                    Aucune demande connue
                </p>
            </div>
        @endforelse
    </section>
</x-app-layout>
