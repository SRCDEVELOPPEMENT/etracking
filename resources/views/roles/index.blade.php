
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
                            @can('creer-role')
                                <button type="button" data-toggle="modal" data-target="#modalRole" data-backdrop="static" data-keyboard="false" class="btn btn-dark btn-icon-split">
                                                    <span class="icon text-white-80">
                                                        <i class="fas fa-plus" style="font-size:10px;"></i>
                                                        <i class="fas fa-user-lock fa-lg mr-2"></i>
                                                    </span>
                                                    <span class="text">Ajout Rôle</span>
                                </button>
                            @endcan
                        </div>
                      </div>
                    </p>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="color:black; font-size:20px;">
                            Liste Des Rôles
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th><i class="fas fa-lg fa-drum mr-3" style="color:#252A37;"></i>rôle</th>
                                                <th width="400px"><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th><i class="fas fa-lg fa-drum mr-3" style="color:#252A37;"></i>rôle </th>
                                                <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>ACTIONS</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($roles as $role)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td>
                                                            <label>{{ $role->name }}</label>
                                                        </td>
                                                        <td>
                                                            @can('editer-role')
                                                                <a class="btn btn-sm col-5 btn-info btn-icon-split mr-3" href="{{ route('roles.edit',$role->id) }}" data-id="{{ $role->id }}">
                                                                    <span class="icon text-white-80">
                                                                        <i class="fas fa-user-lock fa-lg"></i>
                                                                        <i class="fas fa-pen" style="font-size:10px;"></i>
                                                                    </span>
                                                                    <span class="text">Editer</span>
                                                                </a>
                                                            @endcan
                                                            @can('supprimer-role')
                                                                <button class="btn btn-sm col-5 btn-danger btn-icon-split mr-3" id="btnDelete" data-intituleRole="{{ $role->name }}" data-id="{{ $role->id }}">
                                                                    <span class="icon text-white-80">
                                                                        <i class="fas fa-user-lock fa-lg"></i>
                                                                        <i class="fas fa-times" style="font-size:10px;"></i>
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
      
    <div class="modal fade" id="modalRole" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                <i class="fas fa-plus" style="font-size:10px;"></i>
                <i class="fas fa-user-lock fa-lg mr-3"></i>
                </span>
                Ajout Rôle</h5>
                <button type="button" id="btnExit" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="roleFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                        @method('POST')
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="role" name="name"
                                                        placeholder="Rôle">
                                                </div>
                                                <form id="form_roles_add">
                                                    @foreach($permissions as $value)
                                                        <label style="font-size:25px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                        {{ $value->name }}</label>
                                                    <br/>
                                                    @endforeach
                                                </form>
                                                <hr>
                                                <div class="row">
                                                    <button type="button" id="btnSaveRole" class="btn btn-primary col-md-6 mr-4 ml-2"><i class="fas fa-save fa-lg mr-2"></i>Enregistrer Rôle</button>
                                                    <button type="button" id="btnFermer" class="btn btn-danger col-md-4"><i class="fas fa-times fa-sm"></i><i class="fas fa-trash fa-lg mr-2"></i>Annuler Rôle</button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                            <i class="fas fa-edit"></i>
                    </span>
                Edition Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="roleFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" data-ids type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="role" name="name"
                                                        placeholder="Role">
                                                </div>
                                                @foreach($permissions as $value)
                                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                    {{ $value->name }}</label>
                                                <br/>
                                                @endforeach                                                
                                                <hr>
                                                <button type="button" id="btnEditRole" class="btn btn-primary">Editer</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
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

    <script src="{{ url('roles.js') }}"></script>
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