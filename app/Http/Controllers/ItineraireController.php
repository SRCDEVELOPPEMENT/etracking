<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itineraire;
use DB;

class ItineraireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-itineraire|creer-itineraire|editer-itineraire|supprimer-itineraire|', ['only' => ['index','show']]);
        $this->middleware('permission:creer-itineraire', ['only' => ['store']]);
        $this->middleware('permission:editer-itineraire', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-itineraire', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courriers = DB::table('courriers')->get();

        $itineraires = DB::table('itineraires')->get();

        toastr()->info('Liste Des Itinéraires !');
        toastr()->warning('Renseigner La Durée De Vos Itinéraires En Terme D\'heure !');

        return view('itineraires.index', ['itineraires' => $itineraires, 'courriers' => $courriers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newItineraire = new Itineraire();

        $newItineraire->lieux_depart = $request->input('lieux_depart');
        $newItineraire->lieux_arrivee = $request->input('lieux_arrivee');
        $newItineraire->duree = $request->input('duree');

        $newItineraire->save();

        $last_itineraire = DB::table('itineraires')->get()->last();

        return response()->json($last_itineraire);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $itineraire = Itineraire::find($request->id);

        $itineraire->lieux_depart = $request->input('lieux_depart');
        $itineraire->lieux_arrivee = $request->input('lieux_arrivee');
        $itineraire->duree = $request->input('duree');

        $itineraire->save();

        toastr()->success('Itineraire Modifier Avec Succèss !');

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Itineraire::find($request->id)->delete();

        toastr()->success('Itineraire Supprimer Avec Succèss !');

        return response()->json();
    }
}
