<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Consommation;
use DB;

class ConsommationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:lister-consommation|creer-consommation|editer-consommation|supprimer-consommation|voir-consommation', ['only' => ['index','show']]);
        $this->middleware('permission:creer-consommation', ['only' => ['create','store']]);
        $this->middleware('permission:editer-consommation', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-consommation', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        toastr()->info('Liste Des Consommations !');

        $consommations = Consommation::all();
        
        return view('consommations.index', compact('consommations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $conso = new Consommation();
        DB::table('consommations')->where('id', '=', intval($request->input('id_conso')))->update([
            'tonnaging' => $request->input('tonnaging'),
            'montant' => $request->input('montant'),
            'kilometrage' => intval($request->input('kilometrage')),
        ]);

        return response()->json([1]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Consommation::create([
            'tonnaging' => $request->input('tonnaging'),
            'montant' => $request->input('montant'),
            'kilometrage' => intval($request->input('kilometrage')),
        ]);
        toastr()->success('Consommation Ajouté Avec Succèss !');
        
        return response()->json(0);
    }

    public function destroy(Request $request)
    {
        Consommation::find($request->id)->delete();

        toastr()->success('Consommation Supprimer Avec Succèss !');

        return response()->json();
    }
}