@extends('layouts.main')

@section('content')


        <!-- Begin Page Content -->
        <div class="container-fluid" style="font-family: 'Century Gothic';">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div class="row  float-left">
                            <h1 class="h3 mb-0" style="color:#290661;">
                            <i style="color:#290661" class="fas fa-chart-pie fa-lg mr-2"></i>  
                            Etat Statistique</h1>  
                        </div>
                        <div class="row float-right">
                        <i style="color:#290661" class="fas fa-chart-line fa-4x mr-2"></i>  
                        </div>
                        
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Générer Un Fichier</a> -->
                    </div>

                    <!-- Content Row -->
                    <!-- <div class="row"> -->

                        <!-- Earnings (Monthly) Card Example -->
                        <p style="font-weight:bold;">Livraisons Total</p>
                        <div class="row">
                            <div class="col-xl-2 col-md-4 mb-2">
                                <div class="card border-left-primary shadow h-10">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Nombre Total De Livraison 
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nbre_livraisons }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-truck fa-2x text-primary"></i>
                                                <i class="fas fa-list fa-sm text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </br>
                        <p style="font-weight:bold;">
                        Livraisons Agence
                            <select id="symphos" style="height:3em;" 
                                data-livraison="{{ $livraisons }}"
                                data-regions="{{ $regions }}"
                                data-sites="{{ $sites }}"
                                name="yashui">
                                <option value=""></option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                            </select>
                        </p>
                        <div class="row">
                            @foreach($sites as $key => $site)
                                    <div class="col-xl-2 col-md-12 mb-2">
                                        <div class="card border-left-success shadow h-10">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Nombre De Livraison {{ $site->site_name }}</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="tube{{$key}}">0</span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-truck fa-2x text-success" aria-hidden="true"></i>
                                                        <i class="fas fa-arrow-left fa-1x text-success"></i>
                                                    </div>
                                                    <div class="col mr-3">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:10px; color:black;">
                                                                <tr>
                                                                    <td>ENCOURS</td><td><span style="padding:3px;" id="staten{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ENDOMAGEE</td><td><span style="padding:3px;" id="statentr{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PARTIELLE</td><td><span style="padding:3px;" id="statrecept{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>CONFORME</td><td><span style="padding:3px;" id="statlivr{{ $key }}">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col">
                                                        <i class="fas fa-road fa-2x text-success" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col mr-4">
                                                        <span class="text-success">Ville </span><span class="text-dark" id="tour_ville{{ $key }}"> 0</span>
                                                        <span class="text-success">Ligne </span><span class="text-dark" id="voyage{{ $key }}"> 0</span>
                                                    </div>
                                                    <div class="col">
                                                        <i class="fas fa-tools fa-2x text-success" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col">
                                                        <span class="text-success mr-2">Incident (%) </span><span class="text-dark" id="incident_agence{{ $key }}"> 0</span>
                                                    </div>
                                                    <div class="col mr-2">
                                                        <i class="fas fa-comments fa-2x text-success" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col">
                                                        <span class="text-success mr-2">Satisfaction (%) </span><span class="text-dark" id="avis_client{{ $key }}"> 0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        <p style="font-weight:bold;">
                            Livraisons Région 
                            <select id="dev" style="height:3em;" 
                                data-livraison="{{ $livraisons }}"
                                data-regions="{{ $regions }}"
                                data-sites="{{ $sites }}"
                                name="annees">
                                <option value=""></option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                            </select>
                        </p>
                        <div class="row">
                            @foreach($regions as $key => $region)
                                    <div class="col-xl-2 col-md-4 mb-2">
                                        <div class="card border-left-info shadow h-10">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Nombre De Livraison {{ $region->region_name }}</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="ch{{$key}}">0</span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-truck fa-2x text-info" aria-hidden="true"></i>
                                                        <i class="fas fa-arrow-left fa-1x text-success"></i>
                                                    </div>
                                                    <div class="col">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:10px; color:black;">
                                                                <tr>
                                                                    <td>ENCOURS</td><td><span style="padding:3px;" id="encou{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ENDOMAGEE</td><td><span style="padding:3px;" id="endom{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PARTIELLE</td><td><span style="padding:3px;" id="partiel{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>CONFORME</td><td><span style="padding:3px;" id="conf{{ $key }}">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        <p style="font-weight:bold;">
                            Livraisons Par Véhicule 
                            <select id="car_livr" style="height:3em;" 
                                data-livraison="{{ $livraisons }}"
                                data-vehicules="{{ $vehicules }}"
                                >
                                <option value=""></option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                            </select>
                        </p>
                        <div class="row">
                            @foreach($vehicules as $key => $vehicule)
                                    <div class="col-xl-2 col-md-8 mb-2">
                                        <div class="card border-left-warning shadow h-10">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                            Nombre De Voyage De <span class="text-dark">{{ $vehicule->ModelVehicule }} - {{ $vehicule->Immatriculation }} </span></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="toto{{$key}}">0</span></div>
                                                    </div>
                                                    <div class="col-auto mr-3">
                                                        <i class="fas fa-truck fa-2x text-warning" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col">
                                                        <i class="fas fa-road fa-2x text-warning" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col">
                                                        <span class="text-warning">Tour De Ville </span><span class="text-dark" id="tour_dans_ville{{$key}}"> 0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                 

        </div>
        <!-- /.container-fluid -->
    <script src="{{ url('dashboard.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ url('jquery/jquery.min.js') }}"></script>
    <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ url('chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('js/demo/chart-pie-demo.js') }}"></script>

@endsection