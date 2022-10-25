<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Recipe;
use Validator,Redirect,Response;
use Illuminate\Support\Str;
use PDF;
use DB;

class RecipeController extends Controller
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
        toastr()->info('Liste Des Recettes !');

        $cars = Vehicule::all();

        $recipes = Recipe::orderBy('id','DESC')->get();

        $personnes = DB::table('personnes')->get();

        $statuts = ["EnPanne", "EnFonctionnement"];

        return view('recipes.index', ['recipes' => $recipes , 'personnes' => $personnes, 'statuts' => $statuts, 'cars' => $cars]);
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

            $recipe = new Recipe();

            $recipe->nature = $input['nature'];
            $recipe->value = $input['value'];
            $recipe->itinerary = $input['itinerary'] ? $input['itinerary'] : '';
            //$recipe->vehicule_id = $input['vehicule_id'];

            $recipe->save();

            $recette = Recipe::with('vehicules')->get()->last();

            $recettes = Recipe::with('vehicules')->get();

            toastr()->success('Recètte Enrégistrer Avec Succèss !');

            return response([$recette, $recettes]);
        //}
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
        // $vehicules = DB::table('vehicules')->get();

        // $Qte = 0;
        // $tab = array();

        // foreach ($vehicules as $vehicule) {
        //     if($vehicule->id != intval($request->input('id'))){
        //         array_push($tab, $vehicule);
        //     }
        // }

        // foreach ($tab as $vehicule) {
        //     $vehicule_present = strtolower(Str::ascii(str_replace(" ", "", $vehicule->Immatriculation)));
        //     $vehicule_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('Immatriculation'))));
        //     if(strcmp($vehicule_present, $vehicule_int) == 0){
        //         $Qte += 1;
        //     }
        // }

        // if($Qte > 0){
        //     return response()->json([]);
        // }else{
            DB::table('recipes')->where('id', $request->id)->update([
                'itinerary'=> $request->itinerary,
                'nature'=> $request->nature,
                'value'=> $request->value,
                'vehicule_id' => $request->vehicule_id
            ]);
            
            toastr()->success('Recètte Modifier Avec Succèss !');

            return response()->json([1]);
        //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('recipes')->where('id', $request->id)->delete();

        toastr()->success('Recètte Supprimer Avec Succèss !');

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
