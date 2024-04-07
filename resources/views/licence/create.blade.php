<x-app-layout>
    <p class="mt-10 ml-10">
        <a class="bg-red-600 hover:bg-red-700 duration-500 text-white text-md font-bold py-1 px-2 rounded"
            href="{{ route('licence.index') }}">Retour</a>
    </p>

    <h1 class="text-3xl font-semibold text-center mt-10 mb-10">Création d'une licence</h1>


    <div class="flex justify-center">
        <div class="bg-white p-6 mt-6 rounded-lg shadow-md leading-8">
            <h2 class="text-center text-xl mb-8">Informations de la licence</h2>
            <form action="{{ route('licence.store') }}" method="POST">
                @csrf

                <label for="libelle">Libellé</label>
                <input class="rounded w-full" type="text" name="libelle" id="libelle"
                    placeholder="Libellé de la licence">
                @error('libelle')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror

                <div class="flex justify-between gap-6 mt-2 mb-2">
                    <div>
                        <label for="prix">Prix</label><br />
                        <input class="rounded" type="text" name="prix" id="prix" placeholder="Prix en €">
                        @error('prix')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duree">Durée</label><br />
                        <input class="rounded" type="text" name="duree" id="duree" placeholder="Durée en jour">
                        @error('duree')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <label for="produit">Produit</label>
                <select class="rounded w-full" name="produit" id="produit">
                    @foreach ($produits as $produit)
                        <option value="{{ $produit->id }}">{{ $produit->libelle }}</option>
                    @endforeach
                </select>

                <div class="flex justify-center mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 duration-500 text-white font-bold py-0 px-4 rounded mt-6 flex justify-center">Confirmer
                        la création</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
