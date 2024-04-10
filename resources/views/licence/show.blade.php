<x-app-layout>
    <p class="ml-10 mt-4 sm:mt-10">
        <a class="bg-red-600 hover:bg-red-700 duration-500 text-white text-sm min-[475px]:text-base sm:text-lg font-bold py-1 px-2 rounded"
            href="{{ route('licence.index') }}">Retour</a>
    </p>
    <h1 class="text-xl min-[475px]:text-2xl sm:text-3xl font-semibold text-center mb-0 sm:mb-10 mt-4 sm:mt-5">
        {{ $licence->produit->libelle }}</h1>
    <div class="flex justify-center">
        <div
            class="min-[475px]:w-11/12 sm:w-10/12 md:w-8/12 lg:w-6/12 bg-white p-6 mt-6 rounded-lg shadow-md text-sm min-[475px]:text-base sm:text-lg leading-6 min-[475px]:leading-8">
            <h5 class="min-[475px]:text-lg sm:text-xl font-semibold text-center mb-4 sm:mb-8">Informations sur le produit</h5>
            <p>{{ $licence->produit->description}}</p>
        </div>
    </div>
</x-app-layout>
