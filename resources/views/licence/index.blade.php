<x-app-layout>
    @forelse ($licences as $licence)
        <div class="card m-3">
            <div class="card-body">
                <h5 class="card-title">{{ __('Libellé de la licence') }} : {{ Auth::user()->licencechoisie->licence->libelle }}</h5>
                <div class="btn-toolbar">
                    {{-- <x-details-button property="licence" :model="$licence" /> --}}

                    {{-- @can('licence-update')
                        <x-update-button property="licence" :model="$licence" />
                    @endcan
                    @can('marque-retrieve')
                        <x-delete-button property="licence" :model="$licence" />
                    @endcan --}}
                </div>
            </div>
        </div>
    @empty
        <p class="ms-3">
            Aucune licence connue
        </p>
    @endforelse

</x-app-layout>
