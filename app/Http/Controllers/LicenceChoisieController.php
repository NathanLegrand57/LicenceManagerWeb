<?php

namespace App\Http\Controllers;

use App\Models\LicenceChoisie;
use Carbon\Carbon;
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

        $licences_choisies->each(function ($licence) {
            $dateFin = Carbon::parse($licence->date_fin);
            $aujourdhui = Carbon::now();

            if ($dateFin->isPast()) {
                $licence->jours_restants = 0;
            } else {
                $licence->jours_restants = $aujourdhui->diffInDays($dateFin);
            }
        });

        return view('licencechoisie.index', compact('licences_choisies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $licences_choisies = LicenceChoisie::all();

        return view('licencechoisie.create', compact('licences_choisies'));
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
