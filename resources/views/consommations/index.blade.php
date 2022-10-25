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
                            @can('creer-consommation')
                                <button type="button" data-toggle="modal" data-target="#modalAddConsommation" data-backdrop="static" data-keyboard="false" class="btn btn-dark btn-icon-split">
                                                    <span class="icon text-white-80">
                                                        <i class="fas fa-plus" style="font-size:10px;"></i>
                                                        <i class="fas fa-weight fa-lg"></i>
                                                    </span>
                                                    <span class="text">Ajout Consommation</span>
                                </button>
                            @endcan
                            </div>
                        </div>
                    </p>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="text-left" style="color:black; font-size:20px;">
                                    Liste Des Consommations
                                </div>
                                <div class="col-md-12 text-right"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th><i class="fas fa-lg fa-weight mr-3" style="color:#252A37;"></i>Tonnage</th>
                                                <th><i class="fas fa-lg fa-dollar-sign mr-3" style="color:#252A37;"></i>Valeur</th>
                                                <th><i class="fas fa-lg fa-dollar-sign mr-3" style="color:#252A37;"></i>kilométrage</th>
                                                <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                            <th><i class="fas fa-lg fa-weight mr-3" style="color:#252A37;"></i>Tonnage</th>
                                                <th><i class="fas fa-lg fa-dollar-sign mr-3" style="color:#252A37;"></i>Valeur</th>
                                                <th><i class="fas fa-lg fa-dollar-sign mr-3" style="color:#252A37;"></i>kilométrage</th>
                                                <th><i class="fas fa-lg fa-toolbox mr-3" style="color:#252A37;"></i>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($consommations as $conso)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label>{{ $conso->tonnaging }}</label></td>
                                                        <td><label>{{ $conso->montant }}</label></td>
                                                        <td><label>{{ $conso->kilometrage }}</label></td>
                                                        <td>
                                                            @can('editer-consommation')
                                                            <button class="btn btn-sm btn-info btn-icon-split mr-2" data-conso="{{ $conso }}" id="btnEdit">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-globe"></i>
                                                                    <i class="fas fa-sm fa-pen"></i>
                                                                </span>
                                                                <span class="text">Editer</span></button>
                                                            @endcan
                                                            @can('supprimer-consommation')
                                                            <button class="btn btn-sm btn-danger btn-icon-split mr-2" data-id="{{ $conso->id }}" id="btnDelete">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-globe"></i>
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
    
    <script>
        $(document).on('click', '#btnDelete', function(){
            if(confirm("Voulez-Vous Vraiment Supprimer Cette Consommation ?") == true){
                $.ajax({
                    type: 'DELETE',
                    url: 'deleteConsommation',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
                })
            }
        });

        $(document).on('click', '#btnEdit', function(){
            $('#setConsomm').attr('data-es', 1);
            let conso = JSON.parse($(this).attr('data-conso'));

            $("#ConsommationForm")[0].reset();
            
            $('.form-group #id_conso').val(conso.id);
            $('.form-group #tonnagings').val(conso.tonnaging);
            $('.form-group #montants').val(conso.montant);
            $('.form-group #kilometrages').val(conso.kilometrage);

            $('#modalAddConsommation').attr('data-backdrop', 'static');
            $('#modalAddConsommation').attr('data-keyboard', 'false');
            $('#modalAddConsommation').modal('show');
        })

        $(document).on('click', 'button[name="setConst"]', function(){
            if(parseInt($(this).attr('data-es')) == 1){
                $.ajax({
                    type: 'PUT',
                    url: 'editConsommation',
                    data: $('#ConsommationForm').serialize(),
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(value){
                        if(parseInt(value[0]) == 1){
                            location.reload();
                        }
                    }
                });
            }
        })
    </script>
    
    <!-- <script src="{{ url('regions.js') }}"></script> -->
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