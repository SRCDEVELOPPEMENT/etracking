<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Region;
use DB;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-region|creer-region|editer-region|supprimer-region|voir-region', ['only' => ['index','show']]);
        $this->middleware('permission:creer-region', ['only' => ['create','store']]);
        $this->middleware('permission:editer-region', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-region', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        toastr()->info('Liste Des Régions !');

        $regions = Region::all();

        $sites = DB::table('sites')->get();
        
        return view('regions.index', compact('regions', 'sites'));
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
        $regions = Region::all();

        $oui = true;
        foreach ($regions as $region) {
            $region_courant = strtolower(Str::ascii($region->intituleRegion));
            $region_in = strtolower(Str::ascii($request->input('intituleRegion')));
            if(strcmp($region_courant, $region_in) == 0){
                $oui = false;
            }
        }
        if(!$oui){
            return [];
        }else{
            Region::create([
                'region_name' => $request->input('intituleRegion'),
            ]);
            $region = Region::get()->last();
            toastr()->success('Région Enrégistrer Avec Succèss !');

            return response([$region, $regions]);
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
        $regions = DB::table('regions')->get();

        $Qte = 0;
        $tab = array();

        foreach ($regions as $region) {
            if($region->id != intval($request->input('id'))){
                array_push($tab, $region);
            }
        }

        foreach ($tab as $region) {
            $region_present = strtolower(Str::ascii(str_replace(" ", "", $region->intituleRegion)));
            $region_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('intituleRegion'))));
            if(strcmp($region_present, $region_int) == 0){
                $Qte += 1;
            }
        }

        if($Qte > 0){
            return [];
        }else{

            DB::table('regions')->where('id', $request->id)->update([

                'region_name'=> strtoupper($request->intituleRegion),
            ]);

            toastr()->success('Région Modifier Avec Succèss !');

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
        DB::table('regions')->where('id', $request->id)->delete();

        toastr()->info('Région Supprimer Avec Succèss !');

        return response()->json();
    }
}
