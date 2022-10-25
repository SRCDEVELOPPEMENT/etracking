<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>GESTION LIVRAISON</title>

    <link href="{{ url('fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ url('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/select.min.css') }}" rel="stylesheet">

    <link href="{{ url('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <script src="{{ url('jquery/jquery.min.js') }}"></script>
    
    <script src="{{ url('jquery/jquery2.js') }}"></script>
    <script src="{{ url('jquery/select.min.js') }}"></script>

    @toastr_css
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-truck fa-5x"></i>
                    <i style="font-size:20px;" class="fas fa-clock"></i>
                </div>
                <div class="sidebar-brand-text mx-3"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span>Tableau De Bord</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            @can(['lister-region'], ['creer-region'], ['editer-region'], ['supprimer-region'], ['voir-region'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('regions') }}">
                    <i class="fa fa-globe fa-2x"></i>
                    <span>Région</span></a>
            </li>
            @endcan
            @can(['lister-role'], ['creer-role'], ['supprimer-role'], ['voir-role'], ['editer-role'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('roles') }}">
                    <i class="fa fa-user-lock fa-2x"></i>
                    <span>Role</span></a>
            </li>
            @endcan
            @can(['lister-site'], ['creer-site'], ['supprimer-site'], ['voir-site'], ['editer-site'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('sites') }}">
                    <i class="fa fa-building fa-2x"></i>
                    <span>Site</span></a>
            </li>
            @endcan
            @can(['lister-recette'], ['creer-recette'], ['supprimer-recette'], ['voir-recette'], ['editer-recette'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('recettes') }}">
                    <i class="fa fa-battery-empty fa-2x"></i>
                    <span>Recètte</span></a>
            </li>
            @endcan
            @can(['lister-vehicule'], ['creer-vehicule'], ['supprimer-vehicule'], ['voir-vehicule'], ['editer-vehicule'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('vehicules') }}">
                    <i class="fa fa-car fa-2x"></i>
                    <span>Véhicule</span></a>
            </li>
            @endcan
            @can(['lister-livraison'], ['creer-livraison'], ['supprimer-livraison'], ['voir-livraison'], ['editer-livraison'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('livraisons') }}">
                    <i class="fa fa-truck fa-2x mr-2"></i><i class="fa fa-clock"></i>
                    <span>Livraison</span></a>
            </li>
            @endcan
            @can(['lister-utilisateur'], ['creer-utilisateur'], ['supprimer-utilisateur'], ['voir-utilisateur'], ['editer-utilisateur'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('users') }}">
                    <i class="fa fa-user fa-2x"></i>
                    <span>Utilisateur</span></a>
            </li>
            @endcan
            @can(['lister-permission'], ['creer-permission'], ['supprimer-permission'], ['voir-permission'], ['editer-permission'])
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('users') }}">
                    <i class="fa fa-unlock fa-2x"></i>
                    <span>Permission</span></a>
            </li>
            @endcan

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider">
            
        </ul>
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button class="btn btn-default" id="sidebarToggle"><i class="fas fa-solid fa-bars fa-lg"></i></button>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->fullname}}</span>
                                <img class="img-profile rounded-circle"
                                src="{{ url('img/assurer.jpg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <?php $site =  DB::table('sites')->where('id', '=', auth()->user()->site_id)->get()->first(); ?>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item"
                                   data-toggle="modal" 
                                   data-target="#ProfileUser"
                                   data-backdrop="static" 
                                   data-keyboard="false"
                                   data-password="{{ auth()->user()->password }}"
                                   data-user="{{ auth()->user() }}"
                                   id="profil"
                                   data-intituleSite="{{ $site ? $site->site_name : '' }}"
                                   >
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                 Activité Connexion
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal" data-backdrop="static" data-keyboard="false">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Déconnexion
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')
            </div> 
            <!-- End of Main Content -->
            

            <!-- Footer -->
            <footer class="sticky-footer bg-dark" style="font-family: 'Century Gothic';">
                <div class="container my-auto">
                    <div class="copyright text-center text-white my-auto">
                        <span class="text-xl mr-3">Copyright &copy; SOREPCO SA 2022</span>
                        <span class="mr-3">
                            <i class="fas fa-lg fa-eye mr-1"></i>
                            <a style="text-decoration: underline;" class="text-white text-xl" target="_blank" href="https://groupesorepco.com/">Site Web</a>
                        </span>
                        <span class="text-white text-xl mr-3">
                            <i class="fas fa-lg fa-crosshairs mr-1"></i>
                            Address: Salle des fêtes, Douala Cameroun
                        </span>
                        <span class="text-white text-xl mr-3">
                            <i class="fas fa-lg fa-envelope mr-1"></i>
                            Email: info@groupesorepco.com
                        </span>
                        <span class="mr-3">
                            <i class="fas fa-phone mr-1"></i>
                            Phone: (237) 6 999 66 000
                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>


    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
            <div class="modal-dialog" role="document">
                    <div class="modal-content">
                                    <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            <i class="fas fa-sign-out-alt fa-2x fa-fw mr-2"></i>
                                            Pret A Partir ?
                                        </h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="color:black; font-size:17px;">Cliquer Sur Déconnexion méttra Fin à Votre Session. OK ? </div>
                                    <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                                <i class="fas fa-lg fa-times mr-2"></i>    
                                                Annuler
                                            </button>
                                            <form method="post" action="{{ URL::to('logout') }}">
                                                @csrf
                                                <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-lg fa-sign-out-alt mr-2"></i>    
                                                Déconnexion</button>
                                            </form>
                                    </div>
                    </div>
            </div>
    </div>

    <!-- Modal Profile User -->
    <div class="modal" id="ProfileUser" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                    <div class="modal-header" style="background-color:black;">
                                      <h5 class="modal-title" id="exampleModalLabel" style="color:#FFFFFF;font-weight: bold;">
                                      <i class="fas fa-info fa-lg mr-3"></i>
                                      Informations Utilisateur  <span class="badge badge-success text-lg" id="fullname"></span></h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row" id="ui">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-content collapse show">
                                                        <div class="table-responsive">
                                                            <table class="table table-responsive table-bordered mb-0">
                                                                <div class="imgs" style="float:right; margin-bottom:-30rem; padding-top: 0.1rem; padding-right:3rem;">
                                                                        <img src="{{asset('/img/tof.png')}}" alt="First slide">
                                                                </div>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <i style="color:#273A70;" class="fas fa-lg fa-signature mr-2"></i>
                                                                        <span  style="color:black;">
                                                                        Nom</span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="fulname">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <i style="color:#273A70;" class="fa fa-lg fa-hashtag mr-2"></i>
                                                                        <span  style="color:black;">Matricule</span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="matricul">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <i style="color:#273A70;" class="fa fa-lg fa-phone mr-2"></i>
                                                                            <span  style="color:black;">Téléphone</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                    <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="telefones">
                                                                              </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <i style="color:#273A70;" class="fas fa-lg fa-home mr-2"></i>
                                                                        <span style="color:black;">Site</span>
                                                                        </td>
                                                                        <td>
                                                                        <div class="form-group">
                                                                                    <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="sit">
                                                                              </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <i style="color:#273A70;" class="fas fa-lg fa-at mr-2"></i>
                                                                        <span style="color:black;">Email</span>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                            <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="mail">
                                                                            </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <i style="color:#273A70;" class="fas fa-lg fa-sign-in-alt mr-2"></i>
                                                                            <span style="color:black;">Nom Utilisateur</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                      <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="usernames">
                                                                                </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <i style="color:#273A70;" class="fas fa-lg fa-toolbox mr-2"></i>
                                                                            <span style="color:black;">Role</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                    <textarea style="background-color:white; border-style: none; font-weight:bolder;" id="rol" disabled rows="3" cols="20"></textarea>
                                                                              </div>
                                                                      </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                    </div>
                                        
                                  </div>
                                </div>
    </div>
    
    <!-- Modal Parametres -->
    <div class="modal" id="modalSetSettings" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-dark text-white">
                        <i class="fas fa-3x fa-box-open"></i>
                        <h5 style="font-size:1.1em; margin-left: 4rem; font-weight:bolder;" class="modal-title text-justifiy">
                        GESTION LIVRAISON</h5>
                        <button type="button" id="btnExit_ihm_settings" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                <div class="modal-body">
                        <div class="col-md-12">
                            <button type="button" 
                                    class="btn btn-outline-dark col-md-12"
                                    data-toggle="modal" 
                                    data-target="#modalAddConsommation"
                                    data-backdrop="static" 
                                    data-keyboard="false">
                                CONSOMMATION
                                <i class="fas fa-lg fa-angle-right ml-5"></i>
                            </button>
                        </div>
                        <hr>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Consommation -->
    <div class="modal" id="modalAddConsommation" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-dark text-white">
                        <h5 style="font-size:1.1em; margin-left: 4rem; font-weight:bolder;" class="modal-title text-justifiy">
                        CONSOMMATION</h5>
                        <button type="button" id="btnExit_itineraire_Main" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                <div class="modal-body">
                    <form id="ConsommationForm" autocomplete="off">
                            {{ csrf_field() }}
                                @csrf
                                <div class="form-group">
                                    <input id="id_conso" type="hidden" name="id_conso">
                                </div>
                        <div class="col-md-12" style="color:black;">
                            <div class="form-group">
                                <label for="">Tonnage (T)</label>
                                <input type="number" class="form-control border-primary" id="tonnagings" name="tonnaging">
                            </div>
                            <div class="form-group">
                                <label for="">Valeur (FCFA)</label>
                                <input type="number" class="form-control border-primary" id="montants" name="montant">
                            </div>
                            <div class="form-group">
                                <label for="">kilométrage (KM)</label>
                                <input type="number" class="form-control border-primary" id="kilometrages" name="kilometrage">
                            </div>
                            <hr>
                            <button type="button" 
                                    id="setConsomm"
                                    name="setConst"
                                    data-es="0"
                                    class="btn btn-outline-primary col-md-12">
                                VALIDER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal fade" id="errorvalidationsMainPage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                    <div class="modal-content">
                            <div class="modal-header" style="background-color:red;">
                                <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-group">
                                          <textarea id="validationsMainPage" disabled style="width:100%;border-style:none;height:150px;background-color:white;resize: none; color:black; font-size:19px;" class="form-control"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                            </div>
                    </div>
            </div>
    </div>

    <!-- Modal Confirmation Save Itineraire -->
    <div class="modal fade" id="modalConfirmMainPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                    <i class="fas fa-check fa-lg mr-3"></i>    
                                    Confirmez-Vous Ces Informations ?</h5>
                                </div>
                                <div class="modal-body">
                                                        <table class="table table-bordered mb-2">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-globe mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    Lieux Départ</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="lieux_depart_conf_Main"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-globe mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    Lieux Arrivée</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="lieux_arrive_conf_Main"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-info mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    Durée</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="duree_itineraire_conf_Main"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <tbody>
                                                        </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="conf_MainPage_Itin" class="btn btn-primary">OUI</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div> 

</body>
@toastr_js
@toastr_render
</html>
<script>
        $(document).on('click', '#setConsomm', function(){
            if(parseInt($(this).attr('data-es')) == 0){
                $.ajax({
                    type: 'POST',
                    url: 'consomation',
                    data: $('#ConsommationForm').serialize(),
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(){
                        location.reload();
                    }
                });
            }
        });

        $(document).on('click', '#profil', function(){
            let userConnecter = JSON.parse($(this).attr('data-user'));

            $('#fullname').replaceWith(`<span class="badge badge-success text-lg" id="fullname">${userConnecter.login}</span>`)
            $('#fulname').val(userConnecter.fullname);
            $('#matricul').val(userConnecter.matricule);
            $('#telefones').val(userConnecter.telephone);
            $('#sit').val($(this).attr('data-intituleSite'));
            $('#mail').val(userConnecter.email);
            $('#usernames').val(userConnecter.login);
            $('#passwords').val($(this).attr('data-password'));
            if(userConnecter.roles.length > 1){
                let conc = "";
                for (let index = 0; index < userConnecter.roles.length; index++) {
                    const elt = userConnecter.roles[index];
                    conc += elt.name + "\n";
                }
                $('#rol').val(conc);
            }else{
                $('#rol').val(userConnecter.roles[0].name);
            }
        });
</script>
