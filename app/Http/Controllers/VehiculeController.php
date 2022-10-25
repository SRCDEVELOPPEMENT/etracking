<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Validator,Redirect,Response;
use Illuminate\Support\Str;
use PDF;
use DB;

class VehiculeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-vehicule|creer-vehicule|editer-vehicule|supprimer-vehicule|voir-vehicule', ['only' => ['index','show']]);
        $this->middleware('permission:creer-vehicule', ['only' => ['create','store']]);
        $this->middleware('permission:editer-vehicule', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-vehicule', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        toastr()->info('Liste Des Véhicules !');

        $cars = Vehicule::all();

        $vehicules = Vehicule::orderBy('id','DESC')->get();

        $personnes = DB::table('personnes')->get();

        $statuts = ["EnPanne", "EnFonctionnement"];

        return view('vehicules.index', ['vehicules' => $vehicules , 'personnes' => $personnes, 'statuts' => $statuts, 'cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $input = $request->all();

        $vehicules = DB::table('vehicules')->get();
        $good = true;

        foreach ($vehicules as $vehicule) {
            $vehicule_courant = strtolower(Str::ascii(str_replace(" ", "", $vehicule->Immatriculation)));
            $vehicule_int = strtolower(Str::ascii(str_replace(" ", "", $input['Immatriculation'])));
            if(strcmp($vehicule_courant, $vehicule_int) == 0){
                $good = false;
            }
        }
        if(!$good){
            return response()->json([]);
        }else{

            $car = new Vehicule();

            $car->Immatriculation = $input['Immatriculation'];
            $car->StatutVehicule = $input['StatutVehicule'];
            $car->tonnage = intval($input['tonnage']);
            $car->ModelVehicule = $input['ModelVehicule'];
            $car->save();


            $vehicule = DB::table('vehicules')->get()->last();

            $vehicules = Vehicule::all();

            toastr()->success('Véhicule Enrégistrer Avec Succèss !');

            return response([$vehicule, $vehicules]);
        }
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
        $vehicules = DB::table('vehicules')->get();

        $Qte = 0;
        $tab = array();

        foreach ($vehicules as $vehicule) {
            if($vehicule->id != intval($request->input('id'))){
                array_push($tab, $vehicule);
            }
        }

        foreach ($tab as $vehicule) {
            $vehicule_present = strtolower(Str::ascii(str_replace(" ", "", $vehicule->Immatriculation)));
            $vehicule_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('Immatriculation'))));
            if(strcmp($vehicule_present, $vehicule_int) == 0){
                $Qte += 1;
            }
        }

        if($Qte > 0){
            return response()->json([]);
        }else{
            DB::table('vehicules')->where('id', $request->id)->update([
                'Immatriculation'=> $request->Immatriculation,
                'tonnage'=> $request->tonnage,
                'ModelVehicule'=> $request->ModelVehicule,
                'StatutVehicule' => $request->StatutVehicule
            ]);
            
            toastr()->success('Véhicule Modifier Avec Succèss !');

            return response()->json([1]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('vehicules')->where('id', $request->id)->delete();

        $vehicules = Vehicule::all();

        toastr()->success('Véhicule Supprimer Avec Succèss !');

        return response()->json();
    }

    public function generate(){

        $vehicules = Vehicule::get();

        $pdf = PDF::loadView('PDF/vehicules', ['vehicules' => $vehicules]);
        
        return $pdf->stream('vehicules.pdf', array('Attachment'=>0));
    }

    public function affectation(Request $request){
        
        toastr()->success('Véhicule Attribuer Avec Succèss Au Chauffeur !');

        DB::table('personnes')->where('id', $request->input('chauffeur_id'))->update([
            'vehicule_id'=> $request->input('vehicule_id'),
        ]);

        return response()->json();
    }
}
