<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Site;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use DB;
use Redirect;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $role = DB::table('roles')->where('name', "SuperAdmin")->get()->first();

        // if($role != NULL){
        //     $permissions = DB::table('role_has_permissions')->where('role_id', $role->id)->get();
        //     if(count($permissions) > 0){
        //         return redirect()->route('login');
        //     }    
        // }

        // $permissions = [];, ['permissions' => $permissions]

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'fullname' => ['required', 'string', 'max:255'],
            // 'matricule' => ['required', 'string', 'max:255', 'unique:users'],
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            // 'telephone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:5'],
            // 'email' => 'required|email|unique:users,email',
            'roles' => 'required'
            ],[
                // 'matricule.unique' => 'Matricule Déja Utiliser !',
                'login.unique' => 'Nom Utilisateur Déja Utiliser !',
                // 'telephone.unique' => 'Téléphone Déja Utiliser !',
                // 'email.unique' => 'Email Déja Utilier !',
                'password.confirmed' => 'Mot De Passes Non Identique !',
                'password.min' => 'Le Mot De Passe Doit avoir Au Minimum 8 Caractères !'
            ]);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
              
        $permitions = [
            'creer-role',
            'lister-role',
            'editer-role',
            'supprimer-role',
            'voir-role',
            'lister-region',
            'creer-region',
            'editer-region',
            'supprimer-region',
            'voir-region',
            'creer-site',
            'lister-site',
            'editer-site',
            'supprimer-site',
            'voir-site',
            'creer-utilisateur',
            'lister-utilisateur',
            'editer-utilisateur',
            'supprimer-utilisateur',
            'voir-utilisateur',
            'creer-vehicule',
            'lister-vehicule',
            'editer-vehicule',
            'supprimer-vehicule',
            'voir-vehicule',
            'creer-permission',
            'lister-permission',
            'editer-permission',
            'supprimer-permission',
            'voir-permission',
            'creer-personne',
            'lister-personne',
            'editer-personne',
            'supprimer-personne',
            'voir-personne',
            'creer-livraison',
            'lister-livraison',
            'editer-livraison',
            'supprimer-livraison',
            'voir-livraison',
            'creer-consommation',
            'lister-consommation',
            'editer-consommation',
            'supprimer-consommation',
            'voir-consommation',
            'creer-recette',
            'lister-recette',
            'editer-recette',
            'supprimer-recette',
            'voir-recette',
        ];

        foreach ($permitions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role = Role::create(['name' => $request->input('roles')]);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
