<?php

namespace App\Http\Controllers;

use App\Http\Repositories\LicenceRepository;
use App\Http\Requests\LicenceRequest;
use App\Models\Licence;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenceController extends Controller
{
    protected $licenceRepository;
    public function __construct(LicenceRepository $licenceRepository)
    {
        $this->licenceRepository = $licenceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $licences = Licence::all();
        return view('licence.index', compact('licences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::all();

        if (Auth::user()->can('create-licence')) {
            return view('licence.create', compact('produits'));
        }

        abort(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LicenceRequest $request)
    {
        $this->licenceRepository->store($request);

        return redirect()->route('licence.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Licence $licence)
    {
        return view('licence.show', compact('licence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Licence $licence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Licence $licence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Licence $licence)
    {
        $licence->delete();
        return redirect()->route("licence.index");
    }
}
