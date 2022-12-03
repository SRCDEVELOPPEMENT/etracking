<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\ItineraireController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\ConsommationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Livraison;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('splash');
});

Route::get('/dashboard', function () {

    $nbre_livraisons = DB::table('livraisons')->get()->count();

    $colis_en_retard = array();

    $livraisons = Livraison::with('users')->get();

    $regions = DB::table('regions')->get();

    $vehicules = DB::table('vehicules')->get();

    $users = DB::table('users')->get();

    $sites = DB::table('sites')->where('site_type', '=', 'AGENCE')->get();

    $global = array();
    $gobalRegions = array();

    toastr()->info('BIENVENUE '. Auth::user()->fullname .' !');

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
})->middleware(['auth'])->name('dashboard');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('recettes', RecipeController::class);
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('courriers', CourrierController::class);
    Route::resource('postes', PosteController::class);
    Route::resource('personnes', PersonneController::class);
    Route::resource('itineraires', ItineraireController::class);
    Route::resource('livraisons', LivraisonController::class);
    Route::resource('consomations', ConsommationController::class);


    Route::post('consomation', [ConsommationController::class, 'store'])->name('consomation');
    
    Route::delete('deleteConsommation', [ConsommationController::class, 'destroy'])->name('deleteConsommation');
    
    Route::put('editConsommation', [ConsommationController::class, 'edit'])->name('editConsommation');


    Route::post('createLivraison', [LivraisonController::class, 'store'])->name('createLivraison');

    Route::put('editLivraison', [LivraisonController::class, 'edit'])->name('editLivraison');

    Route::get('deleteLivraison', [LivraisonController::class, 'destroy'])->name('deleteLivraison');

    Route::get('etatVehicule', [LivraisonController::class, 'etat_car'])->name('etatVehicule');
    
    Route::get('car_etats', [LivraisonController::class, 'etat_truck'])->name('car_etats');

    Route::get('stat_en_agence', [LivraisonController::class, 'statAgence'])->name('stat_en_agence');
    
    //Route::get('stat_par_region', [LivraisonController::class, 'statRegion'])->name('stat_par_region');

    Route::get('generate-livraison', [LivraisonController::class, 'generate'])->name('generate-livraison');

    Route::get('doStatut', [LivraisonController::class, 'statut'])->name('doStatut');

    Route::get('livraison_informe', [LivraisonController::class, 'informe'])->name('livraison_informe');
    
    Route::put('give_avis_client', [LivraisonController::class, 'giveAvis'])->name('give_avis_client');
    
    Route::put('set_incident', [LivraisonController::class, 'setIncident'])->name('set_incident');
    
    Route::post('upload', [LivraisonController::class, 'uploadfile'])->name('upload');

    

    Route::post('createPermission', [PermissionController::class, 'store'])->name('createPermission');

    Route::post('editPermission', [PermissionController::class, 'update'])->name('editPermission');

    Route::get('deletePermission', [PermissionController::class, 'destroy'])->name('deletePermission');


    
    Route::post('createUser', [UserController::class, 'store'])->name('createUser');
    Route::get('getusers', [UserController::class, 'getUsers'])->name('getusers');
    Route::get('deleteUser', [UserController::class, 'destroy'])->name('deleteUser');
    Route::put('editUser', [UserController::class, 'edit'])->name('editUser');


    Route::post('createRole', [RoleController::class, 'store'])->name('createRole');

    Route::get('deleteRole', [RoleController::class, 'destroy'])->name('deleteRole');


    Route::post('createRegion', [RegionController::class, 'store'])->name('createRegion');

    Route::post('editRegion', [RegionController::class, 'update'])->name('editRegion');

    Route::get('deleteRegion', [RegionController::class, 'destroy'])->name('deleteRegion');

    
    Route::post('createVehicule', [VehiculeController::class, 'store'])->name('createVehicule');

    Route::post('editVehicule', [VehiculeController::class, 'update'])->name('editVehicule');

    Route::get('deleteVehicule', [VehiculeController::class, 'destroy'])->name('deleteVehicule');

    Route::get('generate-vehicule', [VehiculeController::class, 'generate'])->name('generate-vehicule');

    Route::post('affectCarToPersonne', [VehiculeController::class, 'affectation'])->name('affectCarToPersonne');


    Route::post('createSite', [SiteController::class, 'store'])->name('createSite');

    Route::get('deleteSite', [SiteController::class, 'destroy'])->name('deleteSite');

    Route::post('editSite', [SiteController::class, 'update'])->name('editSite');

    Route::get('generate-site', [SiteController::class, 'generate'])->name('generate-site');



    Route::post('createRecette', [RecipeController::class, 'store'])->name('createRecette');

    Route::get('deleteRecette', [RecipeController::class, 'destroy'])->name('deleteRecette');

    Route::post('editRecette', [RecipeController::class, 'update'])->name('editRecette');



    Route::post('createPoste', [PosteController::class, 'store'])->name('createPoste');

    Route::get('deletePoste', [PosteController::class, 'destroy'])->name('deletePoste');

    Route::post('editPoste', [PosteController::class, 'update'])->name('editPoste');


    Route::post('createPersonne', [PersonneController::class, 'store'])->name('createPersonne');

    Route::get('deletePersonne', [PersonneController::class, 'destroy'])->name('deletePersonne');

    Route::post('editPersonne', [PersonneController::class, 'update'])->name('editPersonne');

    Route::get('generation_personne', [PersonneController::class, 'generate_personne'])->name('generate-personnes');


    
    Route::get('couriers', [CourrierController::class, 'getcourriers'])->name('couriers');
    
    Route::post('createCourrier', [CourrierController::class, 'store'])->name('createCourrier');

    Route::put('editCourrier', [CourrierController::class, 'edit'])->name('editCourrier');

    Route::get('deleteCourrier', [CourrierController::class, 'destroy'])->name('deleteCourrier');

    Route::put('retraitCourrier', [CourrierController::class, 'retraitcourier'])->name('retraitCourrier');


    Route::get('receptCourrier', [CourrierController::class, 'receptionShow'])->name('receptCourrier');
    
    Route::post('receptionCourrier', [CourrierController::class, 'reception'])->name('receptionCourrier');

    Route::get('livCourrier', [CourrierController::class, 'livraisonShow'])->name('livCourrier');

    Route::post('livraisonCourrier', [CourrierController::class, 'livraison'])->name('livraisonCourrier');

    Route::get('archiveCourrier', [CourrierController::class, 'archive'])->name('archiveCourrier');

    Route::post('annulerCourrier', [CourrierController::class, 'annuler'])->name('annulerCourrier');

    Route::get('consultationCourrierRegion', [CourrierController::class, 'consulter'])->name('consultationCourrierRegion');

    Route::get('ihm_client', [CourrierController::class, 'suiviClient'])->name('ihm_client');

    Route::get('ihmClient', [CourrierController::class, 'suiviClientReq'])->name('ihmClient');

    
    Route::get('generate-file', [CourrierController::class, 'generate_pdf_file'])->name('generate-file');

    Route::get('generate-pdf', [CourrierController::class, 'generatePDF'])->name('generate-pdf');
    
    Route::get('generate', [CourrierController::class, 'generate'])->name('generate');

    Route::get('generate-all', [CourrierController::class, 'generateAllCourrier'])->name('generate-all');

    Route::get('preview', [CourrierController::class, 'save_courrier_preview'])->name('preview');

    Route::get('generate-pdf-date', [CourrierController::class, 'generatePDF_par_date'])->name('generate-pdf-date');
    
    Route::get('generate-pdf-journalier', [CourrierController::class, 'generatePDF_Journalier'])->name('generate-pdf-journalier');
    
    Route::get('generate-pdf-region', [CourrierController::class, 'generatePDF_par_region'])->name('generate-pdf-region');


    Route::post('createItineraireMainPage', [ItineraireController::class, 'store'])->name('createItineraireMainPage');
    Route::post('createItineraireItinPage', [ItineraireController::class, 'store'])->name('createItineraireItinPage');

    Route::post('deleteItineraire', [ItineraireController::class, 'destroy'])->name('deleteItineraire');

    Route::put('updateItineraire', [ItineraireController::class, 'update'])->name('updateItineraire');
    
    Route::get('setGraphColisParMois', [CourrierController::class, 'setGraph'])->name('setGraphColisParMois');

    Route::get('setGraphColisParRegion', [CourrierController::class, 'setGraphParRegion'])->name('setGraphColisParRegion');

    Route::get('setColisEnRetard', [CourrierController::class, 'setCourrierRetard'])->name('setColisEnRetard');
});

require __DIR__.'/auth.php';