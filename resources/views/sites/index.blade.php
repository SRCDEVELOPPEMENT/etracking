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
                                        @can('creer-site')
                                            <button type="button" data-toggle="modal" data-target="#modalSite" data-backdrop="static" data-keyboard="false" class="btn btn-dark btn-icon-split mr-3">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-plus" style="font-size:10px;"></i>
                                                                    <i class="fas fa-lg fa-city"></i>
                                                                </span>
                                                                <span class="text">Ajout Site</span>
                                            </button>
                                        @endcan
                                        <a title="PDF Site" href="{{ route('generate-site') }}" type="button" class="btn mr-2" style="background-color:#252A37;color:white;"><i class="fas fa-file-pdf fa-lg mr-2"></i>PDF Site</a>
                                </div>
                            </div>
                        </p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header text-lg py-3" style="color:black;">
                                 Liste Des Sites Du Systèm
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                <th><i class="fas fa-lg fa-city mr-3" style="color:#252A37;"></i>SITE</th>
                                                    <th><i class="fas fa-lg fa-suitcase mr-3" style="color:#252A37;"></i>TYPE SITE</th>
                                                    <th><i class="fas fa-lg fa-globe mr-3" style="color:#252A37;"></i>VILLE SITE</th>
                                                    <th><i class="fas fa-lg fa-globe mr-3" style="color:#252A37;"></i>REGION SITE</th>
                                                    <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tfoot class="bg-dark text-white">
                                                <tr>
                                                    <th><i class="fas fa-lg fa-city mr-3" style="color:#252A37;"></i>SITE</th>
                                                    <th><i class="fas fa-lg fa-suitcase mr-3" style="color:#252A37;"></i>TYPE SITE</th>
                                                    <th><i class="fas fa-lg fa-globe mr-3" style="color:#252A37;"></i>VILLE SITE</th>
                                                    <th><i class="fas fa-lg fa-globe mr-3" style="color:#252A37;"></i>REGION SITE</th>
                                                    <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                    @foreach($sits as $site)
                                                        <tr style="font-size:15px; color:black;">
                                                            <td><label>{{ $site->site_name }}</label></td>
                                                            <td><label>{{ $site->site_type }}</label></td>
                                                            <td><label>{{ $site->ville }}</label></td>
                                                            <td><label>{{ $site->regions->region_name }}</td>
                                                            <td>
                                                                @can('editer-site')
                                                                <button class="btn btn-sm btn-info btn-icon-split mr-2" data-site="{{ $site }}" id="btnEdit" data-id="{{ $site->id }}" data-intituleSite="{{ $site->site_name }}">
                                                                    <span class="icon text-white-80">
                                                                        <i class="fas fa-lg fa-city"></i>
                                                                        <i class="fas fa-sm fa-pen mr-2"></i>
                                                                    </span>
                                                                    <span class="text">Editer</span>
                                                                </button>
                                                                @endcan
                                                                @can('supprimer-site')
                                                                <button class="btn btn-sm btn-danger btn-icon-split" id="btnDelete" data-users="{{ $users }}" data-site_name="{{ $site->site_name }}" data-id="{{ $site->id }}">
                                                                    <span class="icon text-white-80">
                                                                        <i class="fas fa-lg fa-city"></i>
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
    
    <div class="modal fade" id="modalSite" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                            <i class="fas fa-plus" style="font-size:10px;"></i>
                            <i class="fas fa-lg fa-city mr-3"></i>
                    </span>
                Ajout Site</h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="siteFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="site" name="site_name"
                                                        placeholder="Site">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="site_type" name="site_type">
                                                        <option value="">Type Du Site</option>
                                                        <option value="AGENCE">AGENCE</option>
                                                        <option value="MAGASIN">MAGASIN</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="site_ville" name="ville">
                                                        <option value="">Ville Du Site</option>
                                                        @foreach($villes as $ville)
                                                        <option value="{{ $ville }}">{{ $ville }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="region" name="region_id">
                                                    <option value="">Région Du Site</option>
                                                    @foreach($regions as $region)
                                                    <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <button  type="button" id="btnSaveSite" class="btn btn-primary col-md-5 mr-3 ml-3">
                                                        <i class="fas fa-sm fa-check" ></i>
                                                        <i class="fas fa-lg fa-city mr-2"></i>
                                                        Enrégistrer</button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5">
                                                        <i class="fas fa-sm fa-times"></i>
                                                        <i class="fas fa-lg fa-city mr-2"></i>
                                                        Annuler</button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditSite" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                            <i class="fas fa-pen" style="font-size:10px;"></i>
                            <i class="fas fa-lg fa-city mr-3"></i>
                    </span>
                Edition Site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="siteFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="sites" name="site_name"
                                                        placeholder="Site">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="site_types" name="site_type">
                                                    <option value="">Type De Site</option>
                                                    <option value="AGENCE">AGENCE</option>
                                                    <option value="MAGASIN">MAGASIN</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="site_villes" name="ville">
                                                        <option value="">Ville Du Site</option>
                                                        @foreach($villes as $ville)
                                                        <option value="{{ $ville }}">{{ $ville }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" id="regions" name="region_id">
                                                    <option value="">Région Du Site</option>
                                                    @foreach($regions as $region)
                                                    <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                <hr>
                                                <button type="button" id="btnEditSite" class="btn btn-primary col-md-6 mr-2 ml-2"><i class="fas fa-check mr-1" style="font-size:10px;"></i><i class="fas fa-city mr-2"></i>Modifier</button>
                                                <button type="button" id="btnExit_site" class="btn btn-danger col-md-5"><i class="fas fa-trash mr-2 mr-2"></i>Annuler</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation Save Site -->
    <div class="modal fade" id="modalConfirmationSaveSite" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                                                                    <i style="color:#E02D1B;" class="fas fa-home mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    SITE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="site_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-globe mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    REGION</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="region_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-info mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    TYPE DE SITE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="type_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <tbody>
                                                        </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="conf_save_site" data-sites="{{ $sits }}" class="btn btn-primary">OUI</button>
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
                                          <textarea id="validation" disabled style="width:100%;border-style:none;height:200px;background-color:white;resize: none;color:black; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('sites.js') }}"></script>

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