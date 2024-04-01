<x-app-layout>
    <h1 class="text-4xl font-semibold text-center mt-14 mb-10">Licences disponibles</h1>

    @forelse ($demande_licences as $demande_licence)
        <div class="bg-white p-6 mt-6 rounded-lg shadow-md leading-8">
            <h5 class="">{{ __('Nom du produit') }} : {{ $produit->nom }}</h5>
        </div>
    @empty
        <p class="ms-3">
            Aucun produit connu
        </p>
    @endforelse




</x-app-layout>
