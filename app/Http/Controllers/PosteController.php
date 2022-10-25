<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Poste;
use DB;

class PosteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-poste|creer-poste|editer-poste|supprimer-poste|voir-poste', ['only' => ['index','show']]);
        $this->middleware('permission:creer-poste', ['only' => ['create','store']]);
        $this->middleware('permission:editer-poste', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-poste', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        toastr()->info('Liste Des Postes !');

        $posts = Poste::all();

        $postes = Poste::orderBy('id','DESC')->paginate();

        return view('postes.index', compact('postes', 'posts'));
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
        $good = true;
        $message = "";

        $get_postes = DB::table('postes')->get();
        $oui = true;
        foreach ($get_postes as $poste) {
            $poste_courrant = strtolower(Str::ascii(str_replace(" ", "", $poste->intitulePoste)));
            $poste_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['intitulePoste'])));
            if(strcmp($poste_courrant, $poste_saisi) == 0){
                $oui = false;
            }
        }
        if(!$oui){
            $good = false;
            $message .= "Veuillez Modifier Votre Poste Car Déja Existant ! \n";
        }
        if(!$good){
            $good = false;
            return response()->json([$message]);
        }else{
            Poste::create([
                'intitulePoste' => $request->input('intitulePoste'),
                'descriptionPoste' => $request->input('descriptionPoste') ? $request->input('descriptionPoste') : NULL,
            ]);
    
            $poste = DB::table('postes')->get()->last();
    
            $postes = Poste::all();
    
            toastr()->success('Poste Créer Avec Succèss !');

            return response([$poste, $postes]);    
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
        $postes = DB::table('postes')->get();

        $Qte = 0;
        $tab = array();

        foreach ($postes as $poste) {
            if($poste->id != intval($request->input('id'))){
                array_push($tab, $poste);
            }
        }

        foreach ($tab as $poste) {
            $poste_present = strtolower(Str::ascii(str_replace(" ", "", $poste->intitulePoste)));
            $poste_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('intitulePoste'))));
            if(strcmp($poste_present, $poste_int) == 0){
                $Qte += 1;
            }
        }

        if($Qte > 0){
            return response()->json([]);
        }else{
            DB::table('postes')->where('id', $request->id)->update([
                'intitulePoste'=>$request->intitulePoste,
                'descriptionPoste'=> $request->descriptionPoste ? $request->descriptionPoste : NULL,
            ]);
            
            toastr()->success('Poste Modifier Avec Succèss !');

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
        Poste::find($request->id)->delete();

        toastr()->info('Poste Supprimer Avec Succèss !');

        return response()->json();
    }
}
