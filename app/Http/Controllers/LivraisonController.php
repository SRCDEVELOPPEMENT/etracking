<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Livraison;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Site;
use App\Models\Vehicule;
use App\Models\Consommation;
use DB;
use PDF;
use Carbon\Carbon;

class LivraisonController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:lister-livraison|creer-livraison|editer-livraison|supprimer-livraison|voir-livraison', ['only' => ['index','show']]);
        $this->middleware('permission:creer-livraison', ['only' => ['create','store']]);
        $this->middleware('permission:editer-livraison', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-livraison', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        toastr()->info('Liste Des Livraisons !');
        $user_connecte = Auth::user();
        if($user_connecte->roles[0]->name == "CONTROLLEUR" || $user_connecte->roles[0]->name == "ServiceApresVente" || $user_connecte->roles[0]->name == "INCIDENT" || $user_connecte->roles[0]->name == "SuperAdmin"){
            $livraisons = Livraison::with('vehicules')->get();
        }else{
            $livraisons = Livraison::with('vehicules')->where('user_id', '=', Auth::user()->id)->get();
        }
        
        $recipes = Recipe::all();

        $cars = Vehicule::all();

        $consommations = Consommation::all();

        $villes = [
            'DOUALA',
            'YAOUNDE',
            'KRIBI',
            'BAFOUSSAM',
            'BERTOUA',
            'EDEA',
            'LIMBE',
            'FOUMBAN',
            'BANGA',
            'NKONGSAMBA',
            'BAMENDA',
            'NGAOUNDERE',
            'LOUM',
            'GAROUA',
            'MAROUA',
            'KUMBA',
            'MBOUDA',
            'DSCHANG',
            'EBOLOWA',
            'KOUSSERI',
            'ESEKA',
            'MBALMAYO',
            'MEIGANGA',
            'BAFANG',
            'BUEA',
            'TIKO',
            'BAFIA',
            'SANGMELIMA',
            'FOUMBOT',
            'MBANGA',
            'MANJO',
            'TIBATI',
            'MAMFE',
            'MBANDJOCK',
            'KEKEM',
            'KOUTABA',
            'YABASSI',
            'YOKADOUMA',
            ''
        ];
        
        return view('livraisons.index', compact(
            'livraisons', 
            'recipes', 
            'cars', 
            'consommations',
            'villes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Request
     */
    public function statAgence(Request $request){
        $nbre_livraisons = DB::table('livraisons')->get()->count();
        $gobalRegions = array();
        $global = array();
        $livraisons = Livraison::with('users')->get();
        $regions = DB::table('regions')->get();
        $vehicules = DB::table('vehicules')->get();
        $users = DB::table('users')->get();
        $sites = DB::table('sites')->where('site_type', '=', 'AGENCE')->get();
        toastr()->info('BIENVENUE '. Auth::user()->fullname .' !');
        $annee = $request->input('year');

        for ($i=0; $i < count($regions); $i++) { 
            $region = $regions[$i];

            $table = [
                'name' => $region->region_name,
                'liv' => 0,
                'voyage' => 0,
                'tourville' => 0,
                'taux_incident' => 0,
                'taux_satisfaction' => 0,
            ];

            $nbr_livraisons = 0;
            $tourville = 0;
            $voyage = 0;
            $nbr_incident = 0;
            $nbr_avis = 0;

            for ($j=0; $j < count($livraisons); $j++) { 
                $livraison = $livraisons[$j];

                $y = substr($livraison->created_at, 0, 4);
                if(intval($y) == intval($annee)){
                    $user = User::where('id', '=', $livraison->user_id)->get()->first();
                    $sit = Site::where('id', '=', intval($user->site_id))->get()->first();
                    if($sit){
                    if($sit->region_id == intval($region->id)){
                        $nbr_livraisons +=1;
                        if($livraison->incident){
                            $nbr_incident +=1;
                        }
                        if($livraison->avis == "Satisfait"){
                            $nbr_avis +=1;
                        }
                    }}
                }
            }

            $table['liv'] = $nbr_livraisons;
            $table['taux_incident'] = $nbr_livraisons > 0 ? ($nbr_incident/$nbr_livraisons) * 100 : 0;
            $table['taux_satisfaction'] = $nbr_livraisons > 0 ? ($nbr_avis/$nbr_livraisons) * 100 : 0;
            array_push($gobalRegions, $table);

        }
        
        for ($i=0; $i < count($sites); $i++) { 
            $site = $sites[$i];
            
            $table = [
                'name' => $site->site_name,
                'liv' => 0,
                'voyage' => 0,
                'tourville' => 0,
                'taux_incident' => 0,
                'taux_satisfaction' => 0,
            ];

            $nbr_livraisons = 0;
            $tourville = 0;
            $voyage = 0;
            $nbr_incident = 0;
            $nbr_avis = 0;
            for ($j=0; $j < count($livraisons); $j++) {
                $livraison = $livraisons[$j];
                $y = substr($livraison->created_at, 0, 4);
                if(intval($y) == intval($annee)){
                    $user = DB::table('users')->where('id', '=', $livraison->user_id)->get()->first();
                    $agency = DB::table('sites')->where('id', '=', $user->site_id)->get()->first();
                    if($agency){
                    if(intval($agency->id) == intval($site->id)){
                        $nbr_livraisons +=1;
                        if($agency->ville == $livraison->destination){
                            $tourville +=1;
                        }else{
                            $voyage +=1;
                        }
                        if($livraison->incident){
                            $nbr_incident +=1;
                        }
                        if($livraison->avis == "Satisfait"){
                            $nbr_avis +=1;
                        }
                    }}
                }
            }

            $table['liv'] = $nbr_livraisons;
            $table['voyage'] = $voyage;
            $table['tourville'] = $tourville;
            $table['taux_incident'] = $nbr_livraisons > 0 ? ($nbr_incident/$nbr_livraisons) * 100 : 0;
            $table['taux_satisfaction'] = $nbr_livraisons > 0 ? ($nbr_avis/$nbr_livraisons) * 100 : 0;
            array_push($global, $table);
        }

        return view('dashboard', 
        [
            'livraisons' => $livraisons,
            'sites' => $sites,
            'regions' => $regions,
            'vehicules' => $vehicules,
            'users' => $users,
            'global' => $global,
            'gobalRegions' => $gobalRegions,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Request
     */
    public function informe(Request $request){
        toastr()->info('Liste Des Livraisons !');
            $livraisons = Livraison::where('user_id', '=', Auth::user()->id)
            ->where('etat_livraison', '=', 'ENDOMAGEE')
            ->orWhere('etat_livraison', '=', 'PARTIELLE')
            ->get();

        $recipes = Recipe::all();

        $cars = Vehicule::all();

        $consommations = Consommation::all();

        $villes = [
            'DOUALA',
            'YAOUNDE',
            'KRIBI',
            'BAFOUSSAM',
            'BERTOUA',
            'EDEA',
            'LIMBE',
            'FOUMBAN',
            'BANGA',
            'NKONGSAMBA',
            'BAMENDA',
            'NGAOUNDERE',
            'LOUM',
            'GAROUA',
            'MAROUA',
            'KUMBA',
            'MBOUDA',
            'DSCHANG',
            'EBOLOWA',
            'KOUSSERI',
            'ESEKA',
        ];
        
        return view('livraisons.index', compact(
            'livraisons',
            'recipes',
            'cars',
            'consommations',
            'villes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function etat_car(Request $request)
    {
        $somme_jan = 0;
        $somme_fev = 0;
        $somme_mars = 0;
        $somme_avr = 0;
        $somme_mai = 0;
        $somme_jui = 0;
        $somme_juil = 0;
        $somme_aou = 0;
        $somme_sep = 0;
        $somme_oct = 0;
        $somme_nov = 0;
        $somme_dec = 0;

        $nbr_voyage_jan = 0;
        $nbr_voyage_fev = 0;
        $nbr_voyage_mars = 0;
        $nbr_voyage_avr = 0;
        $nbr_voyage_mai = 0;
        $nbr_voyage_jui = 0;
        $nbr_voyage_juil = 0;
        $nbr_voyage_aou = 0;
        $nbr_voyage_sep = 0;
        $nbr_voyage_oct = 0;
        $nbr_voyage_nov = 0;
        $nbr_voyage_dec = 0;

        $nbr_tour_ville_jan = 0;
        $nbr_tour_ville_fev = 0;
        $nbr_tour_ville_mars = 0;
        $nbr_tour_ville_avr = 0;
        $nbr_tour_ville_mai = 0;
        $nbr_tour_ville_jui = 0;
        $nbr_tour_ville_juil = 0;
        $nbr_tour_ville_aou = 0;
        $nbr_tour_ville_sep = 0;
        $nbr_tour_ville_oct = 0;
        $nbr_tour_ville_nov = 0;
        $nbr_tour_ville_dec = 0;

        $contribution_carburant_jan = 0;
        $contribution_carburant_fev = 0;
        $contribution_carburant_mars = 0;
        $contribution_carburant_avr = 0;
        $contribution_carburant_mai = 0;
        $contribution_carburant_jui = 0;
        $contribution_carburant_juil = 0;
        $contribution_carburant_aou = 0;
        $contribution_carburant_sep = 0;
        $contribution_carburant_oct = 0;
        $contribution_carburant_nov = 0;
        $contribution_carburant_dec = 0;

        toastr()->info('Liste Des Etats Des Véhicules !');

        $vehicules = Vehicule::all();

        $personnes = DB::table('personnes')->get();

        $car_select = new Vehicule();

        return view('vehicules.etat_vehicule', compact(
            'vehicules', 
            'personnes',
            'car_select',

            'somme_jan',
            'somme_fev',
            'somme_mars',
            'somme_avr',
            'somme_mai',
            'somme_jui',
            'somme_juil',
            'somme_aou',
            'somme_sep',
            'somme_oct',
            'somme_nov',
            'somme_dec',
            'nbr_voyage_jan',
            'nbr_voyage_fev',
            'nbr_voyage_mars',
            'nbr_voyage_avr',
            'nbr_voyage_mai',
            'nbr_voyage_jui',
            'nbr_voyage_juil',
            'nbr_voyage_aou',
            'nbr_voyage_sep',
            'nbr_voyage_oct',
            'nbr_voyage_nov',
            'nbr_voyage_dec',
            'nbr_tour_ville_jan',
            'nbr_tour_ville_fev',
            'nbr_tour_ville_mars',
            'nbr_tour_ville_avr',
            'nbr_tour_ville_mai',
            'nbr_tour_ville_jui',
            'nbr_tour_ville_juil',
            'nbr_tour_ville_aou',
            'nbr_tour_ville_sep',
            'nbr_tour_ville_oct',
            'nbr_tour_ville_nov',
            'nbr_tour_ville_dec',
            'contribution_carburant_jan',
            'contribution_carburant_fev',
            'contribution_carburant_mars',
            'contribution_carburant_avr',
            'contribution_carburant_mai',
            'contribution_carburant_jui',
            'contribution_carburant_juil',
            'contribution_carburant_aou',
            'contribution_carburant_sep',
            'contribution_carburant_oct',
            'contribution_carburant_nov',
            'contribution_carburant_dec',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function etat_truck(Request $request){

        toastr()->info('Liste Des Etats Des Véhicules !');
        
        $car_courant = $request->car_courant;

        $year_select = $request->year_ca;
        $livraisons = DB::table('livraisons')->where('vehicule_id', '=', $car_courant)->get();
        
        $livraison_annee_selectionner = array();

        for ($i=0; $i < count($livraisons); $i++) { 
            $delivery = $livraisons[$i];
            $annee = substr($delivery->created_at, 0, 4);

            if(intval($annee) == intval($year_select)){
                array_push($livraison_annee_selectionner, $delivery);
            }
        }
        
        $somme_jan = 0;
        $somme_fev = 0;
        $somme_mars = 0;
        $somme_avr = 0;
        $somme_mai = 0;
        $somme_jui = 0;
        $somme_juil = 0;
        $somme_aou = 0;
        $somme_sep = 0;
        $somme_oct = 0;
        $somme_nov = 0;
        $somme_dec = 0;
        
        $nbr_voyage_jan = 0;
        $nbr_voyage_fev = 0;
        $nbr_voyage_mars = 0;
        $nbr_voyage_avr = 0;
        $nbr_voyage_mai = 0;
        $nbr_voyage_jui = 0;
        $nbr_voyage_juil = 0;
        $nbr_voyage_aou = 0;
        $nbr_voyage_sep = 0;
        $nbr_voyage_oct = 0;
        $nbr_voyage_nov = 0;
        $nbr_voyage_dec = 0;

        $nbr_tour_ville_jan = 0;
        $nbr_tour_ville_fev = 0;
        $nbr_tour_ville_mars = 0;
        $nbr_tour_ville_avr = 0;
        $nbr_tour_ville_mai = 0;
        $nbr_tour_ville_jui = 0;
        $nbr_tour_ville_juil = 0;
        $nbr_tour_ville_aou = 0;
        $nbr_tour_ville_sep = 0;
        $nbr_tour_ville_oct = 0;
        $nbr_tour_ville_nov = 0;
        $nbr_tour_ville_dec = 0;

        $contribution_carburant_jan = 0;
        $contribution_carburant_fev = 0;
        $contribution_carburant_mars = 0;
        $contribution_carburant_avr = 0;
        $contribution_carburant_mai = 0;
        $contribution_carburant_jui = 0;
        $contribution_carburant_juil = 0;
        $contribution_carburant_aou = 0;
        $contribution_carburant_sep = 0;
        $contribution_carburant_oct = 0;
        $contribution_carburant_nov = 0;
        $contribution_carburant_dec = 0;

        for ($i=0; $i < count($livraison_annee_selectionner); $i++) { 
            $liv = $livraison_annee_selectionner[$i];
            $mois = substr($liv->created_at, 5, 2);
            
            switch (intval($mois)) {
                case 1:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_jan += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_jan++;
                        }else{
                            $nbr_voyage_jan++;
                        }
                        $somme_jan += $liv->delivery_amount;
                    }
                    break;
                case 2:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_fev += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_fev++;
                        }else{
                            $nbr_voyage_fev++;
                        }
                        $somme_fev += $liv->delivery_amount;
                    }
                    break;
                case 3:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_mars += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_mars++;
                        }else{
                            $nbr_voyage_mars++;
                        }
                        $somme_mars += $liv->delivery_amount;
                    }
                    break;
                case 4:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_avr += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_avr++;
                        }else{
                            $nbr_voyage_avr++;
                        }
                        $somme_avr += $liv->delivery_amount;
                    }
                    break;
                case 5:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_mai += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_mai++;
                        }else{
                            $nbr_voyage_mai++;
                        }
                        $somme_mai += $liv->delivery_amount;
                    }
                    break;
                case 6:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_jui += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_jui++;
                        }else{
                            $nbr_voyage_jui++;
                        }
                        $somme_jui += $liv->delivery_amount;
                    }
                    break;
                case 7:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_juil += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_juil++;
                        }else{
                            $nbr_voyage_juil++;
                        }
                        $somme_juil += $liv->delivery_amount;
                    }
                    break;
                case 8:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_aou += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_aou++;
                        }else{
                            $nbr_voyage_aou++;
                        }
                        $somme_aou += $liv->delivery_amount;
                    }
                    break;
                case 9:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_sep += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_sep++;
                        }else{
                            $nbr_voyage_sep++;
                        }
                        $somme_sep += $liv->delivery_amount;
                    }
                    break;
                case 10:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_oct += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_oct++;
                        }else{
                            $nbr_voyage_oct++;
                        }
                        $somme_oct += $liv->delivery_amount;
                    }
                    break;
                case 11:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_nov += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_nov++;
                        }else{
                            $nbr_voyage_nov++;
                        }
                        $somme_nov += $liv->delivery_amount;
                    }
                    break;
                case 12:
                    $user_liv = DB::table('users')->where('id', '=', $liv->user_id)->get()->first();
                    $site_user = DB::table('sites')->where('id', '=', $user_liv->site_id)->get()->first();
                    $contribution_carburant_dec += $liv->amount_paye;
                    if($site_user){
                        if($site_user->ville == $liv->destination){
                            $nbr_tour_ville_dec++;
                        }else{
                            $nbr_voyage_dec++;
                        }
                        $somme_dec += $liv->delivery_amount;
                    }
                    break;
                default:
                    break;
            }
        }


        $car_select = DB::table('vehicules')->where('id', '=', intval($car_courant))->get()->first();

        $vehicules = Vehicule::all();

        $personnes = DB::table('personnes')->get();

        return view('vehicules.etat_vehicule', compact(
            'vehicules',
            'car_select',
            'somme_jan',
            'somme_fev',
            'somme_mars',
            'somme_avr',
            'somme_mai',
            'somme_jui',
            'somme_juil',
            'somme_aou',
            'somme_sep',
            'somme_oct',
            'somme_nov',
            'somme_dec',
            'nbr_voyage_jan',
            'nbr_voyage_fev',
            'nbr_voyage_mars',
            'nbr_voyage_avr',
            'nbr_voyage_mai',
            'nbr_voyage_jui',
            'nbr_voyage_juil',
            'nbr_voyage_aou',
            'nbr_voyage_sep',
            'nbr_voyage_oct',
            'nbr_voyage_nov',
            'nbr_voyage_dec',
            'nbr_tour_ville_jan',
            'nbr_tour_ville_fev',
            'nbr_tour_ville_mars',
            'nbr_tour_ville_avr',
            'nbr_tour_ville_mai',
            'nbr_tour_ville_jui',
            'nbr_tour_ville_juil',
            'nbr_tour_ville_aou',
            'nbr_tour_ville_sep',
            'nbr_tour_ville_oct',
            'nbr_tour_ville_nov',
            'nbr_tour_ville_dec',
            'contribution_carburant_jan',
            'contribution_carburant_fev',
            'contribution_carburant_mars',
            'contribution_carburant_avr',
            'contribution_carburant_mai',
            'contribution_carburant_jui',
            'contribution_carburant_juil',
            'contribution_carburant_aou',
            'contribution_carburant_sep',
            'contribution_carburant_oct',
            'contribution_carburant_nov',
            'contribution_carburant_dec',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $amount = 0;
            $typeLivraison = "";
            
            $recipe_selectionner = DB::table('recipes')
            ->where('id', '=', intval($request->input('recipe_id')))
            ->get()->first();

            if($request->input('tonnage') && $recipe_selectionner){
            $amount = intval($request->input('tonnage')) * $recipe_selectionner->value;}
            if($amount < 5000){$amount = 5000;}
            switch ($request->input('type_livraison')) {
                case '0':
                    $typeLivraison = "PAYANTE";
                    break;
                case '1':
                    $typeLivraison = "GRATUITE AUTORISE";
                    break;
                case '2':
                    $typeLivraison = "ZONE GRATUITE";
                    break;
                case '3':
                    $typeLivraison = "PROSPECTION";
                    break;
                default:
                    break;
            }
            Livraison::create([
                'destination' => $request->destination,
                'type_livraison' => $typeLivraison,
                'observation' => $request->input('observation') ? $request->input('observation') : '',
                'amount_paye' => $request->input('amount_paye') ? intval($request->input('amount_paye')) : 0,
                'phone_client' => intval($request->input('phone_client')),
                'nom_client' => $request->input('nom_client'),
                'itinerary' => $request->input('itinerary'),
                'delivery_amount' => $amount,
                'order_number' => $request->input('order_number'),
                'tonnage' => $request->input('tonnage') ? intval($request->input('tonnage')) : NULL,
                'distance' => $request->input('distance') ? intval($request->input('distance')) : NULL,
                'recipe_id' => $request->input('recipe_id') ? intval($request->input('recipe_id')) : NULL,
                'vehicule_id' => $request->input('vehicule_id') ? intval($request->input('vehicule_id')) : NULL,
                'user_id' => intval(Auth::user()->id),
                'state' => "ENCOUR",
                'delivery_date' => $request->input('delivery_date'),
            ]);

            $livraison = Livraison::get()->last();

            $livraisons = Livraison::all();

            toastr()->success('Livraison Enrégistrer Avec Succèss !');

            return response([$livraison, $livraisons]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadfile(Request $request){
        dd($request->input('file'));
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
    public function edit(Request $request)
    {
        DB::table('livraisons')->where('id', '=', intval($request->id))->update([
            'observation' => $request->input('observation') ? $request->input('observation') : '',
            'phone_client' => intval($request->input('phone_client')),
            'nom_client' => $request->input('nom_client'),
            'itinerary' => $request->input('itinerary'),
            'order_number' => $request->input('order_number'),
            'delivery_date' => $request->input('delivery_date'),
            'really_delivery_date' => $request->input('really_delivery_date'),
            'vehicule_id' => intval($request->input('vehicule_id')),
        ]);
        
        toastr()->success('Livraison Modifier Avec Succèss !');
        return response()->json([1]);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('livraisons')->where('id', $request->id)->update([
            'state' => 'ANNULER',
            'motif_annulation' => $request->motif,
        ]);

        toastr()->info('Livraison Annuler Avec Succèss !');

        return response()->json([1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function etat(Request $request)
    {
        DB::table('livraisons')->where('id', $request->id)->update([
            'etat_livraison' => $request->etat_livraison
        ]);

        toastr()->success('Etat De La Livraison Modifier Avec Succèss !');

        return response()->json([1]);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statut(Request $request)
    {   
        $incident = NULL;

        if($request->etat_livraison == "PARTIELLE" || $request->etat_livraison == "ENDOMAGEE"){
            $incident = "EnAttente";
        }
        DB::table('livraisons')->where('id', $request->id)->update([
            'state' => $request->statut_livraison,
            'really_delivery_date' => $request->date,
            'etat_livraison' => $request->etat_livraison,
            'observation_a_la_livraison' => $request->obs,
            'incident' => $incident ? $incident : NULL,
        ]);

        toastr()->success('Livraison Effectuer Avec Succèss !');

        return response()->json([1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function giveAvis(Request $request){
        DB::table('livraisons')->where('id', $request->id)->update([
            'avis' => $request->avis,
            'commentaire_avis' => $request->comment ? $request->comment : NULL,
        ]);

        toastr()->success('Avis Du Client Donner Avec Succèss !');

        return response()->json([1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setIncident(Request $request){
        DB::table('livraisons')->where('id', $request->id)->update([
            'incident' => $request->incidant,
            'commentaire_incident' => $request->incide_liv ? $request->incide_liv : NULL,
        ]);

        toastr()->success('Incident Déclaré Avec Succèss !');

        return response()->json([1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request){
        //dd($request->id);
        $livraison = Livraison::where('id', '=', $request->id)->get()->first();

        $pdf = PDF::loadView('PDF/livraison', ['livraison' => $livraison]);
        
        return $pdf->stream('livraison.pdf', array('Attachment'=> false));
    }
}