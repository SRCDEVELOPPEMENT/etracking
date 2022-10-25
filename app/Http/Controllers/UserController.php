<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Site;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{

    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:lister-utilisateur|creer-utilisateur|editer-utilisateur|supprimer-utilisateur|voir-utilisateur', ['only' => ['index','store']]);
         $this->middleware('permission:creer-utilisateur', ['only' => ['create','store']]);
         $this->middleware('permission:editer-utilisateur', ['only' => ['edit','update']]);
         $this->middleware('permission:supprimer-utilisateur', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        toastr()->info('Liste Des Utilisateurs De L\'application !');

        $sites = Site::all();

        $roles = Role::get();

        $cars = Vehicule::get();

        $utilisateurs = User::get();

        return view('users.index', 
        [
        'sites' => $sites,
        'roles' => $roles, 
        'cars' => $cars,
        'utilisateurs' => $utilisateurs,
        ]);
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


    public function getUsers(){
        return response()->json(User::with('sites', 'roles')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = User::all();
        $input = $request->all();
        $good = true;
        $message = "";
        $oui = true;

        if($input['login'] && $input['password']){
            foreach ($users as $user) {
                $user_courrant = strtolower(Str::ascii(str_replace(" ", "", $user->login)));
                $user_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['login'])));
                if(strcmp($user_courrant, $user_saisi) == 0){
                    $oui = false;
                }
            }
            if(!$oui){
                $good = false;
                $message .= "Veuillez Modifier Votre Nom D'utilisateur Car Déja Existant !\n";
            }

            $oui = true;
            foreach ($users as $user) {
                if(Hash::check($request->input('password'), $user->password)){
                    $oui = false;
                }
            }
            if(!$oui){
                $good = false;
                $message .= "Veuillez Renseigner Un Autre Mot De Passe Car Déja Existant !\n";
            }
        }

        if($good){

            $user = User::create([
                'login' => $input['login'] ? $input['login'] : NULL,
                'password' => $input['password'] ? Hash::make($input['password']) : NULL,
                'vehicule_id' => $request->vehicule_id ? intval($request->vehicule_id) : NULL,
                'site_id' => $input['site_id'] ? intval($input['site_id']) : NULL,
                'fullname' => $request->fullname ? $request->fullname : NULL,
                'telephone' => intval($request->telephone),
            ]);
            
            $user->assignRole($request->input('roles'));

            $utilisateurs = User::get();

            $utilisateur = User::with('sites')->get()->last();
            
            toastr()->success('Utilisateur Créer Avec Succèss !');

            return response()->json([$utilisateur, $utilisateurs]);
        }else{
            return response([$message]);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

            User::where('id', '=', $request->id)->update([
                'fullname' => $request->input('fullname'),
                'vehicule_id' => $request->input('vehicule_id') ? Str::ascii($request->input('vehicule_id')) : NULL,
                'login' => $request->input('login') ? $request->input('login') : NULL,
                'password' => $request->input('password') ? Hash::make($request->input('password')) : NULL,
                'telephone' => $request->input('telephone'),
                'site_id' => $request->input('site_id') ? intval($request->input('site_id')) : NULL,
            ]);

            $user = User::where('id', '=', $request->id)->get()->first();

            $user->assignRole($request->input('roles'));

            toastr()->success('Utilisateur Modifier Avec Succèss !');

            return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fullname' => ['required', 'string', 'max:255'],
            'matricule' => ['required', 'string', 'max:255', 'unique:users'],
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'max:255', 'unique:users'],
            'site_id' => ['required', 'unique:users'],
            'password' => ['required', 'same:confirm-password', Rules\Password::defaults()],
            'email' => 'required|email|unique:users,email',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('users')->where('id', $request->id)->delete();

        toastr()->success('Utilisateur Supprimer Avec Succèss !');

        return response()->json();
    }
}
