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
                            <div class="col-md-6 text-right">
                                @can('creer-vehicule')
                                    <button type="button" data-toggle="modal" data-target="#modalVehicule" data-backdrop="static" data-keyboard="false" class="btn btn-dark btn-icon-split mr-5">
                                                        <span class="icon text-white-80">
                                                            <i class="fas fa-plus"></i>
                                                            <i class="fas fa-truck"></i>
                                                        </span>
                                                        <span class="text">Ajout Véhicule</span>
                                    </button>
                                @endcan
                                <a title="PDF Véhicule" href="{{ route('generate-vehicule') }}" type="button" class="btn mr-2" style="background-color:#252A37;color:white;"><i class="fas fa-file-pdf mr-2"></i>PDF Véhicules</a>
                            </div>
                        </div>
                    </p>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6 text-lg text-left" style="color:black;">
                                    Liste Des Véhicules
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th><i class="fas fa-lg fa-hashtag mr-3" style="color:#252A37;"></i>IMMATRICULATION</th>
                                                <th><i class="fas fa-lg fa-trademark mr-3" style="color:#252A37;"></i>TONNAGE</th>
                                                <th><i class="fas fa-lg fa-signal mr-3" style="color:#252A37;"></i>MODEL</th>
                                                <th><i class="fas fa-lg fa-hashtag mr-3" style="color:#252A37;"></i>STATUT</th>
                                                <th><i class="fas fa-lg fa-money mr-3" style="color:#252A37;"></i>OBJECTIF</th>
                                                <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                            <th><i class="fas fa-lg fa-hashtag mr-3" style="color:#252A37;"></i>IMMATRICULATION</th>
                                                <th><i class="fas fa-lg fa-trademark mr-3" style="color:#252A37;"></i>TONNAGE</th>
                                                <th><i class="fas fa-lg fa-signal mr-3" style="color:#252A37;"></i>MODEL</th>
                                                <th><i class="fas fa-lg fa-hashtag mr-3" style="color:#252A37;"></i>STATUT</th>
                                                <th><i class="fas fa-lg fa-money mr-3" style="color:#252A37;"></i>OBJECTIF</th>
                                                <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($vehicules as $vehicule)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>{{ $vehicule->Immatriculation }}</label></td>
                                                        <td><label>{{ $vehicule->tonnage }}</label></td>
                                                        <td><label>{{ $vehicule->ModelVehicule }}</label></td>
                                                        <td><label style="font-size:1.5em;">{{ $vehicule->StatutVehicule }}</label></td>
                                                        <td><label>{{ $vehicule->objectif }}</label></td>
                                                        <td>
                                                        @can('editer-vehicule')
                                                            <button class="btn btn-sm btn-info btn-icon-split mr-2" id="btnEdit"
                                                                 data-id="{{ $vehicule->id }}" 
                                                                 data-Immatriculation="{{ $vehicule->Immatriculation }}"  
                                                                 data-ModelVehicule="{{ $vehicule->ModelVehicule }}" 
                                                                 data-StatutVehicule="{{ $vehicule->StatutVehicule }}" 
                                                                 data-tonnage="{{ $vehicule->tonnage }}" >
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-pen"></i>
                                                                </span>
                                                                <span class="text">Editer</span>
                                                            </button>
                                                        @endcan
                                                        @can('supprimer-vehicule')
                                                            <button class="btn btn-sm btn-danger btn-icon-split" id="btnDelete" data-personnes="{{ $personnes }}" data-Immatriculation="{{ $vehicule->Immatriculation }}" data-id="{{ $vehicule->id }}">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-times"></i>
                                                                </span>
                                                                <span class="text">Supprimer</span>
                                                            </button>
                                                        @endcan
                                                        </td>

                                                    </tr>
                                                @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    </div>
    <!-- /.container-fluid -->
      
    <div class="modal fade" id="modalVehicule" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-dark text-white">
                    <h5 class="modal-title">
                        <span class="icon text-white-80">
                                <i class="fas fa-plus" style="font-size:10px;"></i>
                                <i class="fas fa-truck mr-3"></i>
                        </span>
                        Ajout Véhicule
                    </h5>
                    <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <form id="vehiculeFormInsert" autocomplete="off">
                        {{ csrf_field() }}
                            @csrf
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            id="Immatriculation" name="Immatriculation"
                                                            placeholder="Immatriculation">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control"
                                                            id="tonnage" name="tonnage" placeholder="Tonnage">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ModelVehicule" name="ModelVehicule" placeholder="Model Du Vehicule">
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control" id="StatutVehicule" name="StatutVehicule">
                                                            <option value="">Statut Du Véhicule</option>
                                                            @foreach($statuts as $statut)
                                                            <option value="{{ $statut }}">{{ $statut }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control form-control-user"
                                                            id="objectif" name="objectif" placeholder="Objectif Du Vehicule (FCFA)">
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <button type="button" id="btnSaveVehicule" class="btn btn-primary col-md-6 mr-4 ml-1">
                                                            <i class="fas fa-check mr-1" style="font-size:10px;"></i>
                                                            <i class="fas fa-lg fa-truck mr-2"></i>Enregistrer
                                                        </button>
                                                        <button type="button" id="btnReset" class="btn btn-danger col-md-5">
                                                            <i class="fas fa-times" style="font-size:10px;"></i>
                                                            <i class="fas fa-lg fa-truck mr-2"></i>
                                                            Annuler
                                                        </button>
                                                    </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditvehicule" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                    <span class="icon text-white-80">
                                <i class="fas fa-pen" style="font-size:10px;"></i>
                                <i class="fas fa-lg fa-truck mr-3"></i>
                        </span>
                    Edition Véhicule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vehiculeFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="Immatriculations" name="Immatriculation"
                                                        placeholder="Immatriculation">
                                                </div>
                                                <div class="form-group">
                                                    <input type="number" class="form-control"
                                                        id="tonnages" name="tonnage"
                                                        placeholder="Tonnage">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="ModelVehicules" name="ModelVehicule"
                                                        placeholder="Model Du Vehicule">
                                                </div>
                                                    <select class="form-control" id="StatutVehicules" name="StatutVehicule">
                                                        @for($i=0; $i < count($statuts); $i++)
                                                        <option value="{{ $statuts[$i] }}">{{ $statuts[$i] }}</option>
                                                        @endfor
                                                    </select>
                                                    <hr>
                                                <hr>
                                                <div class="row">
                                                    <button type="button" id="btnEditVehicule" class="btn btn-primary col-md-6 mr-2 ml-2"><i class="fas fa-check mr-1" style="font-size:10px;"></i><i class="fas fa-truck mr-3"></i>Modifier</button>
                                                    <button type="button" id="btnClear" class="btn btn-danger col-md-5"><i class="fas fa-times mr-1" style="font-size:10px;"></i><i class="fas fa-truck mr-2"></i>Annuler</button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVehiculeConfirm"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header  bg-info text-white">
                        <h5 class="modal-title">
                                                <i class="fas fa-check fa-lg mr-3"></i>    
                                                Confirmez-Vous Ces Informations ?
                        </h5>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered mb-2">
                            <tbody>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                            <i style="color:#E02D1B;" class="fas fa-hashtag mr-2"></i>
                                                                                                            <span class="badge badge-success">
                                                                                                            IMMATRICULATION</span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            <span style="color: black; font-size: 20px;" id="immatriculation_conf"></span>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        
                                                                                                            <td>
                                                                                                            <i style="color:#E02D1B;" class="fas fa-hashtag mr-2"></i>
                                                                                                            <span class="badge badge-success">
                                                                                                            TONNAGE</span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            <span style="color: black; font-size: 20px;" id="tonnage_conf"></span>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                            <i style="color:#E02D1B;" class="fas fa-truck mr-2"></i>
                                                                                                            <span  class="badge badge-success">
                                                                                                            MODEL</span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            <span style="color: black; font-size: 20px;" id="model_conf"></span>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <i style="color:#E02D1B;" class="fas fa-toolbox mr-2"></i>
                                                                                                                <span  class="badge badge-success">
                                                                                                                STATUT VEHICULE</span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span style="color: black; font-size: 20px;" id="statut_conf"></span>
                                                                                                            </td>
                                                                                                        </tr>
                            <tbody>
                        </table>
                    </div>
                <div class="modal-footer">
                        <button type="button" id="conf_save_vehicule" data-vehicules="{{ $cars }}" class="btn btn-primary">OUI</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal fade" id="errorvalidationsModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                          <textarea id="validation" disabled style="width:100%; height:160px ;border-style:none; background-color:white;resize: none;color:black; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('vehicules.js') }}"></script>
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
