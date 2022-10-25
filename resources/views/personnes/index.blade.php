@extends('layouts.main')


@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid" style="font-family: 'Century Gothic';">

                    <!-- Page Heading -->

                    <p class="mb-2">
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
                                @can('creer-personne')
                                <button type="button" data-toggle="modal" data-target="#modalPersonne" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-icon-split mr-3">
                                                    <span class="icon text-white-80">
                                                        <i class="fas fa-plus"></i>
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <span class="text">Ajout Personne</span>
                                </button>
                                @endcan
                                <a title="PDF De Toute Les Personnes" href="{{ route('generate-personnes') }}" type="button" class="btn" style="background-color:#252A37;color:white;"><i class="fas fa-file-pdf mr-2"></i>PDF PERSONNE</a>
                            </div>
                        </div>  
                    </p>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6 text-lg text-left" style="color:black;">
                                        Liste Des Acteurs Intervenant Dans Le Systèm
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th><i class="fas fa-lg fa-signature mr-3" style="color:#252A37;"></i>NOM</th>
                                                <th><i class="fas fa-lg fa-hashtag mr-3" style="color:#252A37;"></i>MATRICULE</th>
                                                <th><i class="fas fa-lg fa-phone mr-3" style="color:#252A37;"></i>TELEPHONE </th>
                                                <th><i class="fas fa-lg fa-car mr-3" style="color:#252A37;"></i>VEHICULE </th>
                                                <th><i class="fas fa-lg fa-briefcase mr-3" style="color:#252A37;"></i>POSTE </th>
                                                <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-primary text-white">
                                            <tr>
                                            <th><i class="fas fa-lg fa-signature mr-3" style="color:#252A37;"></i>NOM</th>
                                                <th><i class="fas fa-lg fa-hashtag mr-3" style="color:#252A37;"></i>MATRICULE</th>
                                                <th><i class="fas fa-lg fa-phone mr-3" style="color:#252A37;"></i>TELEPHONE </th>
                                                <th><i class="fas fa-lg fa-car mr-3" style="color:#252A37;"></i>VEHICULE </th>
                                                <th><i class="fas fa-lg fa-briefcase mr-3" style="color:#252A37;"></i>POSTE </th>
                                                <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($persons as $personne)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>{{ $personne->fullname }}</label></td>
                                                        <td><label>{{ $personne->matricule }}</label></td>
                                                        <td><label>{{ $personne->telephone }}</label></td>
                                                        <td><label>{{ $personne->vehicules != NULL ? $personne->vehicules->Immatriculation : '' }}</label></td>
                                                        <td><label>{{ $personne->postes != NULL ? $personne->postes->intitulePoste : '' }}</label></td>
                                                        <td>
                                                            @can('editer-personne')
                                                            <button class="btn btn-sm btn-info mr-2"  id="btnEdit"  data-id="{{ $personne->id }}" data-telephone="{{ $personne->telephone }}" data-matricule="{{ $personne->matricule }}"  data-fullname="{{ $personne->fullname }}" data-vehicule_id="{{ $personne->vehicule_id }}" data-poste_id="{{ $personne->poste_id }}"><span class="icon text-white-80"><i class="fa fa-user-edit mr-2"></i></span>Editer</button>
                                                            @endcan
                                                            @can('supprimer-personne')
                                                            <button class="btn btn-sm btn-danger mr-2" id="btnDelete" data-courriers="{{ $courriers }}" data-fullname="{{ $personne->fullname }}" data-id="{{ $personne->id }}"><span class="icon text-white-80" ><i class="fas fa-user-minus mr-2"></i></span>Supprimer</button>
                                                            @endcan
                                                            @can('voir-personne')
                                                            <button class="btn btn-sm btn-primary" id="btnView" data-id="{{ $personne->id }}" data-telephone="{{ $personne->telephone }}"  data-fullname="{{ $personne->fullname }}" data-vehicule_id="{{ $personne->vehicule_id }}" data-poste_id="{{ $personne->poste_id }}" data-matricule="{{ $personne->matricule }}"><span class="icon text-white-80"><i class="fas fa-user"></i><i class="fas fa-sm fa-eye mr-2"></i></span>Vue</button>
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

    <div class="modal fade" id="modalPersonne" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-primary text-white">
                <h5 class="modal-title">
                    <span class="icon text-white-80">
                            <i class="fas fa-user-plus mr-3"></i>
                    </span>
                Ajout Personne</h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="personneFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                    <label for="">Nom <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="nom" name="fullname"
                                                        placeholder="EX: Tagne Jean">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Téléphone <span style="color:red;">  *</span></label>
                                                    <input type="tel" class="form-control"
                                                        id="phone" name="telephone">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Matricule</label>
                                                    <input type="text" class="form-control"
                                                        id="matricule" name="matricule">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="vehicule" name="vehicule_id">
                                                        <option value="">Selectionnez Un Véhicule</option>
                                                        @foreach($vehicules as $vehicule)
                                                        <option value="{{ $vehicule->id }}">{{ $vehicule->Immatriculation }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Date Affectation Du Véhicule</label>
                                                    <input type="date" class="form-control"
                                                        id="dateAffectation" name="dateAffectation">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="poste" name="poste_id">
                                                        <option value="">Selectionnez Un Poste</option>
                                                        @foreach($postes as $poste)
                                                        <option value="{{ $poste->id }}">{{ $poste->intitulePoste }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <button type="button" id="btnAddPersonne" data-personnes="{{ $persons }}" class="btn btn-primary col-md-6 mr-2 mr-3 ml-2"><i class="fas fa-lg fa-user"></i><i class="fas fa-check mr-2" style="font-size:10px;"></i>Enrégistrer</button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5"><i class="fas fa-lg fa-user-times mr-2"></i>Annuler</button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPersonne" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                            <i class="fas fa-user-edit mr-3"></i>
                    </span>
                Edition Personne</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="personneFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nom <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="noms" name="fullname"
                                                        placeholder="EX: Tagne Jean">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Téléphone <span style="color:red;">  *</span></label>
                                                    <input type="tel" class="form-control"
                                                        id="phones" name="telephone">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Matricule</label>
                                                    <input type="text" class="form-control"
                                                        id="matricules" name="matricule">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="vehicules" name="vehicule_id">
                                                        <option value="">Selectionnez Un Véhicule</option>
                                                        @foreach($vehicules as $vehicule)
                                                        <option value="{{ $vehicule->id }}">{{ $vehicule->Immatriculation }} - {{ $vehicule->MarqueVehicule }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="postes" name="poste_id">
                                                        <option value="">Selectionnez Un Poste</option>
                                                        @foreach($postes as $poste)
                                                        <option value="{{ $poste->id }}">{{ $poste->intitulePoste }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <button type="button" id="btnEditPersonne" class="btn btn-primary col-md-6 mr-2 ml-2"><i class="fas fa-lg fa-user-edit mr-2"></i>Editer</button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5" data-dismiss="modal"><i class="fas fa-lg fa-user-times mr-2"></i>Fermer</button>
                                                </div>
                    </form>
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
                                          <textarea id="validation" disabled style="width:100%; height:100px ;border-style:none; background-color:white;resize: none; color:black; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>
    
    <script src="{{ url('personnes.js') }}"></script>
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