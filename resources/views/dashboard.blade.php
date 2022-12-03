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
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="text-left" style="color:black; font-size:20px;">
                                    Quantité Des Livraisons Par Agence
                                </div>
                                <div class="col-md-10 text-right">
                                    <form action="stat_en_agence" method="GET">
                                        <div class="row col-md-6 float-right">
                                            <div class="col-md-4">
                                                <select style="background-color:#5A5C69; color:white;" class="form-control form-control-lg" name="year" id="">
                                                    <option value="">ANNEE</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2010">2023</option>
                                                    <option value="2010">2024</option>
                                                    <option value="2010">2025</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="form-control form-control-lg btn btn-dark" type="submit">VALIDER</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th>AGENCE</th>
                                                <th>NOMBRE DE LIVRAISON</th>
                                                <th>NOMBRE DE TOUR DE LIGNE</th>
                                                <th>NOMBRE DE TOUR DE VILLE</th>
                                                <th>TAUX D'INCIDENT</th>
                                                <th>TAUX DE SATISFACTION CLIENT</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th>AGENCE</th>
                                                <th>NOMBRE DE LIVRAISON</th>
                                                <th>NOMBRE DE TOUR DE LIGNE</th>
                                                <th>NOMBRE DE TOUR DE VILLE</th>
                                                <th>TAUX D'INCIDENT</th>
                                                <th>TAUX DE SATISFACTION CLIENT</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($global as $agence)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>{{ $agence['name'] }}</label></td>
                                                        <td><label>{{ $agence['liv'] }}</label></td>
                                                        <td><label>{{ $agence['voyage'] }}</label></td>
                                                        <td><label>{{ $agence['tourville'] }}</label></td>
                                                        <td><label>{{ $agence['taux_incident'] }}</label></td>
                                                        <td><label>{{ $agence['taux_satisfaction'] }}</label></td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="text-left" style="color:black; font-size:20px;">
                                    Quantité Des Livraisons Par Région
                                </div>
                                <div class="col-md-10 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th>REGION</th>
                                                <th>NOMBRE DE LIVRAISON</th>
                                                <th>TAUX D'INCIDENT</th>
                                                <th>TAUX DE SATISFACTION CLIENT</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th>REGION</th>
                                                <th>NOMBRE DE LIVRAISON</th>
                                                <th>TAUX D'INCIDENT</th>
                                                <th>TAUX DE SATISFACTION CLIENT</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($gobalRegions as $reg)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>{{ $reg['name'] }}</label></td>
                                                        <td><label>{{ $reg['liv'] }}</label></td>
                                                        <td><label>{{ $reg['taux_incident'] }}</label></td>
                                                        <td><label>{{ $reg['taux_satisfaction'] }}</label></td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <p style="font-weight:bold;">Livraisons Total
                            <select id="totaux" style="height:3em;"
                                data-users="{{ $users }}"
                                data-livraison="{{ $livraisons }}"
                                data-regions="{{ $regions }}"
                                data-sites="{{ $sites }}"
                            >
                                                    <option value=""></option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2010">2023</option>
                                                    <option value="2010">2024</option>
                                                    <option value="2010">2025</option>
                            </select>
                        </p>
                        <div class="row">
                            <div class="col-xl-7 col-md-4 mb-2">
                                <div class="card border-left-primary shadow h-10">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Nombre Total De Livraison 
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="tot">0</span></div>
                                            </div>
                                            <div class="col-auto mr-3">
                                                <i class="fas fa-truck fa-2x text-primary"></i>
                                                <i class="fas fa-list fa-sm text-primary"></i>
                                            </div>
                                            <div class="col mr-2">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>ENCOURS</td><td><span id="encoursss">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>LIVRER</td><td><span id="livree">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ANNULER</td><td><span id="anulation">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                            </div>
                                            <div class="col mr-2">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>CONFORME</td><td><span id="confort">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>PARTIELLE</td><td><span id="part">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ENDOMAGEE</td><td><span id="endo">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                            </div>
                                            <div class="col mr-2">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>Tour De Ville</td><td><span id="tville">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Ligne</td><td><span id="lignevoyage">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                            </div>
                                            <div class="col mr-3">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>Nombre Livraisons Respecté</td><td><span id="lresp">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nombre Livraisons Non Respecté</td><td><span id="lnonresp">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                            </div>
                                            <div class="col">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>Taux Satisfaction (En %)</td><td><span id="satiste">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
                                data-users="{{ $users }}"
                                name="yashui">
                                <option value=""></option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2010">2023</option>
                                                    <option value="2010">2024</option>
                                                    <option value="2010">2025</option>
                            </select>
                        </p>
                        <div class="row">
                            @foreach($sites as $key => $site)
                                    <div class="col-xl-6 col-md-4 mb-2">
                                        <div class="card border-left-success shadow h-10">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-sm font-weight-bold text-dark text-uppercase mb-1">
                                                            Nombre De Livraison <span class="text-success">{{ $site->site_name }}</span></div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="tube{{$key}}">0</span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-truck fa-2x text-success" aria-hidden="true"></i>
                                                        <i class="fas fa-arrow-left fa-1x text-success mr-3"></i>
                                                    </div>
                                                    <div class="col mr-3">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>ENCOURS</td><td><span style="padding:3px;" id="staten{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>LIVRER</td><td><span style="padding:3px;" id="statentr{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ANNULER</td><td><span style="padding:3px;" id="statrecept{{ $key }}">0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col mr-3">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>Tour De Ville</td><td><span class="text-dark" id="tour_ville{{ $key }}"> 0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Voyage</td><td><span class="text-dark" id="voyage{{ $key }}"> 0</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col">
                                                        <i class="fas fa-tools fa-2x text-success" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col">
                                                        <span class="text-success mr-2">Taux D'Incident (En %) </span><span class="text-dark" id="incident_agence{{ $key }}"> 0</span>
                                                    </div>
                                                    <div class="col">
                                                        <span class="text-success mr-2">Taux Satisfaction (En %) </span><span class="text-dark" id="avis_client{{ $key }}"> 0</span>
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
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2010">2023</option>
                                                    <option value="2010">2024</option>
                                                    <option value="2010">2025</option>
                            </select>
                        </p>
                        <div class="row">
                            @foreach($regions as $key => $region)
                                    <div class="col-xl-3 col-md-4 mb-2">
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
                                                        <i class="fas fa-arrow-left fa-1x text-success mr-3"></i>
                                                    </div>
                                                    <div class="col">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>ENCOURS</td><td><span style="padding:3px;" id="encou{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>LIVRER</td><td><span style="padding:3px;" id="endom{{ $key }}">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ANNULER</td><td><span style="padding:3px;" id="partiel{{ $key }}">0</span></td>
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
                        <p class="mt-5" style="font-weight:bold;">
                            Année
                            <select id="car_year" style="height:3em;" 
                                data-livraison="{{ $livraisons }}"
                                data-vehicules="{{ $vehicules }}"
                                >
                                <option value="">ANNEE</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2010">2023</option>
                                                    <option value="2010">2024</option>
                                                    <option value="2010">2025</option>
                            </select>
                            Véhicules
                            <select id="trucks" style="height:3em;" 
                                data-livraison="{{ $livraisons }}"
                                data-vehicules="{{ $vehicules }}"
                                data-sites="{{ $sites }}"
                                data-users="{{ $users }}"
                                >
                                    <option value="">VEHICULE</option>
                                @foreach($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}">{{ $vehicule->ModelVehicule }} - {{ $vehicule->Immatriculation }}</option>
                                @endforeach
                            </select>
                        </p>
                        <div class="row">
                                    <div class="col-xl-8 col-md-8 mb-2 text-lg">
                                        <div class="card border-left-warning shadow h-10">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-1">
                                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                            Véhicule Immatriculé <span class="text-dark" id="infos_car"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto mr-3">
                                                        <i class="fas fa-truck fa-2x text-warning" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col mr-2">
                                                        <i class="fas fa-coins fa-3x text-warning" aria-hidden="true"></i>
                                                        <i class="fas fa-coins fa-3x text-warning" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col mr-3">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr><td>Productivité</td><td>FCFA</td></tr>
                                                                <tr>
                                                                    <td style="padding:3px;">JANVIER</td><td><span style="padding:6px;" id="jan">0</span></td>
                                                                    <td style="padding:3px;">FEVRIER</td><td><span style="padding:6px;" id="fev">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:3px;">MARS</td><td><span style="padding:6px;" id="mar">0</span></td>
                                                                    <td style="padding:3px;">AVRIL</td><td><span style="padding:6px;" id="avr">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:3px;">MAI</td><td><span style="padding:6px;" id="mai">0</span></td>
                                                                    <td style="padding:3px;">JUIN</td><td><span style="padding:6px;" id="jui">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:3px;">JUILLET</td><td><span style="padding:6px;" id="juit">0</span></td>
                                                                    <td style="padding:3px;">AOUT</td><td><span style="padding:6px;" id="aou">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:3px;">SEPTEMBRE</td><td><span style="padding:6px;" id="sep">0</span></td>
                                                                    <td style="padding:3px;">OCTOBRE</td><td><span style="padding:6px;" id="oct">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:3px;">NOVEMBRE</td><td><span style="padding:6px;" id="nov">0</span></td>
                                                                    <td style="padding:3px;">DECCEMBRE</td><td><span style="padding:6px;" id="dec">0</span></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col">
                                                        <table class="table-bordered">
                                                            <tbody style="font-size:15px; color:black;">
                                                                <tr>
                                                                    <td>Tour De Ville</td><td><span style="padding:3px;" id="hydra">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tour De Ligne</td><td><span style="padding:3px;" id="trave">0</span></td>
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

    <!-- Page level plugins -->
    <script src="{{ url('datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>
@endsection