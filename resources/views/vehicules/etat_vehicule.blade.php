@extends('layouts.main')


@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid" style="font-family: 'Century Gothic';">
                    <!-- Page Heading -->

                    <p class="mb-4">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                    <a href="{{ URL::to('dashboard')  }}" type="button" class="btn btn-info float-left btn-icon-back">
                                                        <span class="icon text-white-80">
                                                            <i class="fas fa-reply"></i>
                                                        </span>
                                                        <span class="text">Retour</span>
                                    </a>
                            </div>
                        </div>
                    </p>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6 text-lg text-left" style="color:black;">
                                    Liste Des Etats D'un Véhicule
                                </div>
                                <form action="car_etats" method="GET">
                                    <div class="row">
                                            <div class="col-md-3">
                                                <select style="background-color:#5A5C69; color:white;" class="form-control form-control-lg form-control-danger" name="year_ca" id="yyyy">
                                                    <option value="">ANNEE</option>
                                                    <option value="2009">2009</option>
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
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2025">2025</option>
                                                    <option value="2026">2026</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select disabled style="background-color:#5A5C69; color:white;" class="form-control form-control-lg form-control-danger" name="car_courant" id="truck">
                                                    <option value="">VEHICULES</option>
                                                    @foreach($vehicules as $car)
                                                    <option value="{{ $car->id }}">{{ $car->Immatriculation }} - {{ $car->ModelVehicule }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                            <button id="btn_valider" disabled class="btn btn-dark form-control form-control-lg" type="submit">VALIDER</button>
                                            </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th><i class="fas fa-lg fa-calendar mr-3" style="color:#252A37;"></i>MOIS</th>
                                                <th><i class="fas fa-lg fa-bus mr-3" style="color:#252A37;"></i>IMMATRICULATION</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>PRODUCTIVITE PREVUE</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>PRODUCTIVITE OBTENUE</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>CONTRIBUTION CARBURANT</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>ECART</th>
                                                <th><i class="fas fa-lg fa-bus mr-3" style="color:#252A37;"></i>NOMBRE DE VOYAGE</th>
                                                <th><i class="fas fa-lg fa-bus mr-3" style="color:#252A37;"></i>NOMBRE DE TOUR DE VILLE</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th><i class="fas fa-lg fa-calendar mr-3" style="color:#252A37;"></i>MOIS</th>
                                                <th><i class="fas fa-lg fa-bus mr-3" style="color:#252A37;"></i>IMMATRICULATION</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>PRODUCTIVITE PREVUE</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>PRODUCTIVITE OBTENUE</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>CONTRIBUTION CARBURANT</th>
                                                <th><i class="fas fa-lg fa-coins mr-3" style="color:#252A37;"></i>ECART</th>
                                                <th><i class="fas fa-lg fa-bus mr-3" style="color:#252A37;"></i>NOMBRE DE VOYAGE</th>
                                                <th><i class="fas fa-lg fa-bus mr-3" style="color:#252A37;"></i>NOMBRE DE TOUR DE VILLE</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>JANVIER</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }} {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_jan) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_jan }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_jan }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_jan }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_jan }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_jan }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_jan }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>FEVRIER</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }} {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_fev) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_fev }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_fev }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_fev }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_fev }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_fev }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_fev }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>MARS</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_mars) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_mars }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_mars }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_mars }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_mars }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_mars }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_mars }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>AVRIL</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_avr) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_avr }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_avr }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_avr }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_avr }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_avr }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_avr }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>MAI</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_mai) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_mai }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_mai }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_mai }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_mai }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_mai }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_mai }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>JUIN</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_jui) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_jui }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_jui }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_jui }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_jui }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_jui }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_jui }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>JUILLET</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_juil) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_juil }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_juil }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_juil }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_juil }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_juil }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_juil }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>AOUT</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_aou) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_aou }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_aou }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_aou }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_aou }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_aou }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_aou }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>SEPTEMBRE</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_sep) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_sep }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_sep }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_sep }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_sep }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_sep }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_sep }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>OCTOBRE</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_oct) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_oct }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_oct }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_oct }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_oct }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_oct }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_oct }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>NOVEMBRE</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_nov) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_nov }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_nov }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_nov }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_nov }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_nov }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_nov }}</label></td>
                                                    </tr>
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>DECCEMBRE</label></td>
                                                        <td><label>{{ $car_select->Immatriculation }}  {{ $car_select->ModelVehicule }}</label></td>
                                                        <td><label class="badge badge-success" style="font-size:1.5em;">{{ $car_select->objectif }}</label></td>
                                                        @if(intval($somme_dec) < intval($car_select->objectif))
                                                            <td><label style="font-size:1.5em;" class="badge badge-danger">{{ $somme_dec }}</label></td>
                                                        @else
                                                            <td><label style="font-size:1.5em;" class="badge badge-success">{{ $somme_dec }}</label></td>
                                                        @endif
                                                        <td><label style="font-size:1.5em">{{ $contribution_carburant_dec }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $car_select->objectif - $contribution_carburant_dec }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_voyage_dec }}</label></td>
                                                        <td><label style="font-size:1.5em">{{ $nbr_tour_ville_dec }}</label></td>
                                                    </tr>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    </div>
    <!-- /.container-fluid -->
      
    <script>
        $(function(){
            $(document).on('change', '#yyyy', function(){
                if($(this).val()){
                    $('#truck').prop('disabled', false);
                }else{
                    $('#truck').prop('disabled', true);
                    $('#btn_valider').prop('disabled', true);
                }
            })

            $(document).on('change', '#truck', function(){
                if($(this).val()){
                    if($('#yyyy').val()){
                        $('#btn_valider').prop('disabled', false);
                    }else{
                        $('#btn_valider').prop('disabled', true);
                    }
                }else{
                    $('#btn_valider').prop('disabled', true);
                }
            })
        })
    </script>
        <!-- Bootstrap core JavaScript-->
    <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ url('datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>

@endsection
