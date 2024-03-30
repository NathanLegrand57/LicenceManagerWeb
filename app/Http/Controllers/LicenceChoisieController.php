<?php

namespace App\Http\Controllers;

use App\Models\LicenceChoisie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenceChoisieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    $user = Auth::user();

    $licences_choisies = $user->licences_choisies;

    return view('licencechoisie.index', compact('licences_choisies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LicenceChoisie $licenceChoisie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LicenceChoisie $licenceChoisie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LicenceChoisie $licenceChoisie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LicenceChoisie $licenceChoisie)
    {
        //
    }
}
