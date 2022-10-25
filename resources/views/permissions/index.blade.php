@extends('layouts.main')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

            <!-- Page Heading -->

            <p class="mb-4">
            @can('creer-permission')
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
                            <button type="button" data-toggle="modal" data-target="#modalPermission" data-backdrop="static" data-keyboard="false" class="btn btn-dark btn-icon-split">
                                                <span class="icon text-white-80">
                                                    <i class="fas fa-sm fa-plus"></i>
                                                    <i class="fas fa-lock-open fa-lg"></i>
                                                </span>
                                                <span class="text">Ajout Permission</span>
                            </button>
                    </div>
                </div>
            @endcan
            </p>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header text-lg py-3" style="color:black;">
                            Liste Des Permissions De L'application
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th><i class="fas fa-lg fa-lock-open mr-3" style="color:#252A37;"></i>PERMISSION</th>
                                        <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tfoot class="bg-dark text-white">
                                    <tr>
                                        <th><i class="fas fa-lg fa-lock-open mr-3" style="color:#252A37;"></i>PERMISSION</th>
                                        <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                        @foreach($permissions as $permission)
                                            <tr>
                                                <td><label style="font-size:1.5em; color:black;">{{ $permission->name }}</label></td>
                                                <td>
                                                    @can('editer-permission')
                                                    <button class="btn btn-sm btn-info btn-icon-split mr-2" id="btnEdit" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                                        <span class="icon text-white-80">
                                                            <i class="fas fa-lock-open fa-lg"></i>
                                                            <i class="fas fa-sm fa-pen mr-2"></i>
                                                        </span>
                                                        <span class="text">Editer</span>
                                                    </button>
                                                    @endcan
                                                    @can('supprimer-permission')
                                                    <button class="btn btn-sm btn-danger btn-icon-split mr-2" 
                                                            id="btnDelete" 
                                                            data-id="{{ $permission->id }}"
                                                            data-roles_has_permissions="{{ $roles_has_permissions }}">
                                                        <span class="icon text-white-80">
                                                            <i class="fas fa-lock-open fa-lg"></i>
                                                            <i class="fas fa-sm fa-times mr-2"></i>
                                                        </span>
                                                        <span class="text">Supprimer</span>
                                                    </button>
                                                    @endcan
                                                    @can('voir-permission')
                                                    <button class="btn btn-sm btn-primary btn-icon-split" id="btnView" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                                        <span class="icon text-white-80">
                                                        <i class="fas fa-lock-open fa-lg"></i>
                                                            <i class="fas fa-sm fa-eye mr-2"></i>
                                                        </span>
                                                        <span class="text">Vue</span>
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

    
    <div class="modal fade" id="modalPermission" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                            <i class="fas fa-plus" style="font-size:10px;"></i>
                            <i class="fas fa-lock-open mr-3"></i>
                    </span>
                Ajout Permission</h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="permissionFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                    <label for="">Permission <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="name" name="name"
                                                        placeholder="EX: creer-permission | lister-permission">
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <button type="button"  id="btnAddPermission" class="btn btn-primary col-md-6 mr-2 ml-2">
                                                        <i class="fas fa-save" style="font-size:10px;"></i>    
                                                        <i class="fas fa-lock-open fa-lg mr-2"></i>
                                                        Enregistrer</button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5">
                                                        <i class="fas fa-times" style="font-size:10px;"></i>
                                                        <i class="fas fa-lock-open fa-lg mr-2"></i>
                                                        Annuler</button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalEditPermission" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                            <i class="fas fa-lock-open mr-3"></i>
                    </span>
                Edition Permission</h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="permissionFormEdit" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                    <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Permission <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="names" name="name"
                                                        placeholder="EX: creer-permission | lister-permission">
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <button type="button"  id="btnEditPermission" class="btn btn-primary col-md-6 mr-2 ml-2"><i class="fas fa-edit fa-lg mr-2"></i>Modifier</button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5" data-dismiss="modal"><i class="fas fa-times mr-2"></i>Fermer</button>
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
                                          <textarea id="validation" disabled style="width:100%; height:100px ;border-style:none; background-color:white;resize: none;color:black; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('permissions.js') }}"></script>
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