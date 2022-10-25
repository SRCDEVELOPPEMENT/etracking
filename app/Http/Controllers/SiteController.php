<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Site;
use App\Models\Region;
use DB;
use PDF;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-site|creer-site|editer-site|supprimer-site|voir-site', ['only' => ['index','show']]);
        $this->middleware('permission:creer-site|', ['only' => ['create','store']]);
        $this->middleware('permission:editer-site', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-site', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        toastr()->info('Liste Des Sites !');

        $categorieSite = [
            "SERVICE",
            "AGENCE",
            "ENTITE EXTERNE"
        ];

        $sits = Site::all();

        $regions = Region::all();

        $users = DB::table('users')->get();

        return view('sites.index',
        [
         'categories' => $categorieSite,
         'sits' => $sits, 
         'regions' => $regions, 
         'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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

        $get_sites = Site::get();
        $oui = true;

        foreach ($get_sites as $site) {
            $site_courrant = strtolower(Str::ascii(str_replace(" ", "", $site->site_name)));
            $site_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['site_name'])));
            if(strcmp($site_courrant, $site_saisi) == 0){
                $oui = false;
            }
        }

        if(!$oui){
            return [];
        }else{

            $site = new Site();

            $site->site_name = $input['site_name'];
            $site->region_id = intval($input['region_id']);
            $site->site_type = $input['site_type'];
            $site->save();
            $site = Site::with('regions')->get()->last();
            
            $sites = Site::all();

            toastr()->success('Site Enrégistrer Avec Succèss !');

            return response([$site, $sites]);    
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
        $site = Site::find($id);

        return view('sites.show',compact('site'));    
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
        $input = $request->all();

        $sites = DB::table('sites')->get();

        $Qte = 0;
        $tab = array();

        foreach ($sites as $site) {
            if($site->id != intval($request->input('id'))){
                array_push($tab, $site);
            }
        }

        foreach ($tab as $site) {
            $site_present = strtolower(Str::ascii(str_replace(" ", "", $site->site_name)));
            $site_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('site_name'))));
            if(strcmp($site_present, $site_int) == 0){
                $Qte += 1;
            }
        }

        if($Qte > 0){
            return [];
        }else{
            DB::table('sites')->where('id', $request->id)->update([
                'site_name'=>$request->site_name,
                'region_id'=> intval($request->region_id),
                'site_type'=>$request->site_type,
            ]);
            
            toastr()->success('Site Modifier Avec Succèss !');
    
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
        DB::table('sites')->where('id', $request->id)->delete();

        toastr()->success('Site Supprimer Avec Succèss !');

        return response()->json();
    }

    public function generate(){

        $sites = Site::with('regions')->get();

        $pdf = PDF::loadView('PDF/sites', ['sites' => $sites]);
        
        return $pdf->stream('sites.pdf', array('Attachment'=>0));
    }
}
