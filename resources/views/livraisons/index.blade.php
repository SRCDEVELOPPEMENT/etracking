@extends('layouts.main')


@section('content')
    <?php include 'upload.php' ?>
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
                            @can('creer-livraison')
                                <button type="button" data-toggle="modal" data-target="#modalLivraison" data-backdrop="static" data-keyboard="false" class="btn btn-dark btn-icon-split">
                                                    <span class="icon text-white-80">
                                                        <i class="fas fa-plus" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg"></i>
                                                        <i style="font-size:10px;" class="fas fa-clock"></i>
                                                    </span>
                                                    <span class="text">Ajout Livraison</span>
                                </button>
                            @endcan
                            </div>
                        </div>
                    </p>
                    <?php 
                        $site_user_connecte = DB::table('sites')->where('id', '=', auth()->user()->site_id)->get();
                    ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="text-left" style="color:black; font-size:20px;">
                                    Liste Des Livraisons
                                </div>
                                <div class="col-md-10 text-right">
                                    <div class="dropdown float-left">
                                        <button style="background-color:#252A37;" class="btn dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i style="color:white;" class="fa fa-truck mr-2"></i>
                                            <i style="color:white;" class="fa fa-caret-down mr-2"></i>
                                            <span class="mr-3" style="color:white;">Selectionner Une Livraison
                                            </span>
                                            <i style="color:white;" class="fa fa-file-pdf mr-2"></i>
                                        </button>
                                        <div class="dropdown-menu animated--fade-in"
                                            aria-labelledby="dropdownMenuButton">
                                            @foreach($livraisons as $livraison)
                                            <a class="dropdown-item" href="{{ route('generate-livraison', ['id' => $livraison->id]) }}" name="statut">{{ $livraison->order_number }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <form action="livraison_informe">
                                    <button type="sumit" class="btn btn-sm btn-info mr-4">
                                        Livraisons Non Conforme
                                    </button>
                                    <a id="btnLoad" class="btn btn-sm btn-dark">
                                        Livraisons Global
                                    </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th>BON</th>
                                                <th>FRAIS LIVRAISON</th>
                                                <th>POINT DEPART</th>
                                                <th>DESTINATION</th>
                                                <th>CLIENT</th>
                                                <th>DATE LIVRAISON</th>
                                                <th>TYPE LIVRAISON</th>
                                                <th>STATUT</th>
                                                <th>ETAT INCIDENT</th>
                                                <th>ETAT LIVRAISON</th>
                                                <th>SATISFACTION CLIENT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th>BON</th>
                                                <th>FRAIS LIVRAISON</th>
                                                <th>POINT DEPART</th>
                                                <th>DESTINATION</th>
                                                <th>CLIENT</th>
                                                <th>DATE LIVRAISON</th>
                                                <th>TYPE LIVRAISON</th>
                                                <th>STATUT</th>
                                                <th>ETAT INCIDENT</th>
                                                <th>ETAT LIVRAISON</th>
                                                <th>SATISFACTION CLIENT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($livraisons as $livraison)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label style="font-size:1.3em;" class="badge badge-primary">{{ $livraison->order_number }}</label></td>
                                                        <td><label>{{ $livraison->amount_paye ? $livraison->amount_paye : $livraison->delivery_amount  }}</label></td>
                                                        @if(count($site_user_connecte) > 0)
                                                        <td><label>{{ $site_user_connecte[0]->site_name }}</label></td>
                                                        @else
                                                        <td><label></label></td>
                                                        @endif
                                                        <td><label>{{ $livraison->destination }}</label></td>
                                                        <td><label>{{ $livraison->nom_client }}  {{ $livraison->phone_client }}</label></td>
                                                        <td><label>{{ $livraison->really_delivery_date ? $livraison->really_delivery_date : $livraison->delivery_date }}</label></td>
                                                        <td><label style="font-size: 1.3em;">{{ $livraison->type_livraison }}</label></td>
                                                        <td><label style="font-size: 1.3em;">{{ $livraison->state }}</label></td>
                                                        <td><label style="font-size: 1.3em;">{{ $livraison->incident ? $livraison->incident : '' }}</label></td>
                                                        <td><label style="font-size: 1.3em;">{{ $livraison->etat_livraison ? $livraison->etat_livraison : '' }}</label></td>
                                                        <td><label style="font-size: 1.3em;">{{ $livraison->avis }}</label></td>
                                                        <td>
                                                            <div class="row">
                                                            @can('editer-livraison')
                                                            <button 
                                                                title="Editer Une Livraison"
                                                                {{$livraison->state != 'ANNULER' ? '' : 'disabled'}}
                                                                {{$livraison->state != 'LIVRER' ? '' : 'disabled'}}
                                                                class="btn btn-sm btn-warning mr-2 ml-2" 
                                                                id="btnEdit" 
                                                                data-livraisons="{{ $livraison }}" 
                                                                data-id="{{ $livraison->id }}">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-pen"></i>
                                                                </span>
                                                            </button>
                                                            @endcan
                                                            @can('supprimer-livraison')
                                                            <button 
                                                                title="Annuler Une Livraison"
                                                                data-toggle="modal" 
                                                                data-target="#annulation"
                                                                data-backdrop="static" 
                                                                data-keyboard="false"
                                                                {{$livraison->state != 'ANNULER' ? '' : 'disabled'}}
                                                                {{$livraison->state != 'LIVRER' ? '' : 'disabled'}}
                                                                class="btn btn-sm btn-danger mr-2" 
                                                                id="btnannul" 
                                                                data-id="{{ $livraison->id }}"
                                                                data-bx="{{ $livraison->order_number }}">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-times"></i>
                                                                </span>
                                                            </button>
                                                            @endcan
                                                            @can('livrer-livraison')
                                                            <button
                                                                id="btnlivi"
                                                                data-toggle="modal"
                                                                data-target="#livrais"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                class="btn btn-sm btn-lg btn-secondary mr-2"
                                                                title="Livraison"
                                                                data-livraison="{{ $livraison }}"
                                                                {{$livraison->state != 'LIVRER' ? '' : 'disabled'}}
                                                            >
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-clock"></i>
                                                                </span>
                                                            </button>
                                                            @endcan
                                                            @can('avis-client')
                                                            <button 
                                                                data-id="{{ $livraison->id }}"
                                                                data-livraison="{{ $livraison }}"
                                                                data-toggle="modal" 
                                                                data-target="#satisfaction" 
                                                                data-backdrop="static" 
                                                                data-keyboard="false"
                                                                id="satisfaction_client"
                                                                title="Avis Du Client"
                                                                {{$livraison->state != 'ANNULER' ? '' : 'disabled'}}
                                                                {{$livraison->state != 'ENCOUR' ? '' : 'disabled'}}
                                                                class="btn btn-sm btn-dark mr-2">
                                                                Avis
                                                            </button>
                                                            @endcan
                                                            @can('incident')
                                                            <button 
                                                                data-id="{{ $livraison->id }}"
                                                                data-livraison="{{ $livraison }}"
                                                                data-toggle="modal"
                                                                data-target="#incident"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                id="incident_livraison"
                                                                title="Incident Subvenue"
                                                                class="btn btn-sm btn-success mr-2"
                                                                {{$livraison->state != 'ENCOUR' ? '' : 'disabled'}}>
                                                                Incident
                                                            </button>
                                                            @endcan
                                                            <button
                                                                id="btnInfs"
                                                                data-toggle="modal" 
                                                                data-target="#viewInfoLiv" 
                                                                data-backdrop="static" 
                                                                data-keyboard="false"
                                                                class="btn btn-lg btn-info mr-2"
                                                                title="Information Supplémentaire"
                                                                data-livraison="{{ $livraison }}"
                                                            >
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-info"></i>
                                                                </span>
                                                            </button>
                                                            @can('upload-livraison')
                                                            <button
                                                            data-toggle="modal"
                                                            data-target="#upload_file"
                                                            data-backdrop="static"
                                                            data-keyboard="false"
                                                            title="Pièce Jointe"
                                                            data-file="{{ $livraison->filename }}"
                                                            data-id="{{ $livraison->id }}"
                                                            data-bx="{{ $livraison->order_number }}"
                                                            id="files"
                                                            class="btn btn-lg btn-primary mr-2">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-file"></i>
                                                                </span>
                                                            </button>
                                                            @endcan
                                                            </div>
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

    <div class="modal fade" id="modalLivraison" tabindex="-1" role="dialog" style="font-family:Century Gothic; color:black;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="modal-title">
                    <span class="icon text-white-80">
                        <i class="fas fa-plus" style="font-size:10px;"></i>
                        <i class="fas fa-truck fa-lg mr-3"></i>
                    </span>
                    Ajout Livraison
                </h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="livraisonFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                    <label for="">
                                                        <i style="color:#527C8F;" class="fa fa-hashtag fa-lg mr-1"></i>    
                                                        Numéro Du Bon <span style="color:red;">  *</span></label>
                                                        <input type="text" class="form-control"
                                                        id="order_number" name="order_number">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="">
                                                            <i style="color:#527C8F;" class="fa fa-user fa-lg mr-1"></i>
                                                            Nom Client <span style="color:red;">  *</span></label>
                                                        <input type="text" class="form-control"
                                                            id="nom_client" name="nom_client">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">
                                                            <i style="color:#527C8F;" class="fa fa-phone fa-lg mr-1"></i>
                                                            Téléphone Client<span style="color:red;">  *</span></label>
                                                        <input type="tel" class="form-control"
                                                            id="phone_client" name="phone_client">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <i style="color:#527C8F;" class="fa fa-truck-monster fa-lg mr-1"></i>
                                                    Type De Livraison <span style="color:red;"> *</span></label></br>
                                                    <select class="form-control" id="type_delivery" name="type_livraison">
                                                        <option value="">Séléctionner Un Type De Livraison</option>
                                                        <option value="0">Payante</option>
                                                        <option value="1">Gratuite Autorisé</option>
                                                        <option value="2">Zone Gratuite</option>
                                                        <option value="3">Prospection</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                        <label>
                                                        <i style="color:#527C8F;" class="fa fa-truck fa-lg mr-1"></i>
                                                        Véhicule <span style="color:red;">  *</span></label></br>
                                                        <select class="form-control" data-car="{{ $cars }}" data-recettes="{{ $recipes }}" id="vehicule_id" name="vehicule_id">
                                                            <option value="">Séléctionner Un Véhicule</option>
                                                            @foreach($cars as $car)
                                                                <option value="{{ $car->id }}">{{ $car->ModelVehicule }} - {{ $car->Immatriculation }} - {{ $car->tonnage }} Tonne</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <i style="color:#527C8F;" class="fa fa-cubes fa-lg mr-1"></i>
                                                    <label>Elément De Recètte</label></br>
                                                    <select class="form-control" data-r="{{ $recipes }}" id="recipe_id" name="recipe_id">
                                                        <option value="">Séléctionner Une Recètte</option>
                                                        @foreach($recipes as $recipe)
                                                            <option value="{{ $recipe->id }}">{{ $recipe->nature }} - {{ $recipe->value }} FCFA - {{ $recipe->itinerary }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                <div class="form-group col-md-6">
                                                        <label>
                                                            <i style="color:#527C8F;" class="fa fa-balance-scale fa-lg mr-1"></i>
                                                            Tonnage Cargaison En (Tonne)
                                                        </label></br>
                                                        <input type="number" min="1" class="form-control"
                                                            id="tonnage" name="tonnage">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>
                                                        <i style="color:#527C8F;" class="fa fa-list-ol fa-lg mr-1"></i>    
                                                        Distance (Kilomètre)</label></br>
                                                        <input type="number" min="1" class="form-control"
                                                            id="distance" name="distance">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>
                                                        <i style="color:#527C8F;" class="fa fa-road fa-lg mr-1"></i>    
                                                        Itinéraire <span style="color:red;">  *</span></label></br>
                                                        <input type="text" class="form-control"
                                                            id="itinerary" name="itinerary">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>
                                                        <i style="color:#527C8F;" class="fa fa-map fa-lg mr-1"></i>    
                                                        Destination <span style="color:red;">  *</span></label></br>
                                                        <select class="form-control" id="destination" name="destination">
                                                            <option value="">Séléctionner Une Destination</option>
                                                            @foreach($villes as $ville)
                                                                <option value="{{ $ville }}">{{ $ville }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>
                                                        <i style="color:#527C8F;" class="fa fa-coins fa-lg"></i>
                                                        <i style="color:#527C8F;" class="fa fa-coins fa-lg mr-1"></i>    
                                                        Montant A Payer (FCFA)</label></br>
                                                        <input type="text" class="form-control" disabled id="vue_amount">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>
                                                        <i style="color:#527C8F;" class="fa fa-coins fa-lg"></i>
                                                        <i style="color:#527C8F;" class="fa fa-coins fa-lg mr-1"></i>   
                                                        Montant Réellement Payer (FCFA)</label></br>
                                                        <input type="text" class="form-control" name="amount_paye" id="amount_paye">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                        <label>
                                                        <i style="color:#527C8F;" class="fa fa-calendar fa-lg mr-1"></i>    
                                                        Date Livraison<span style="color:red;">  *</span></label></br>
                                                        <input type="date" class="form-control"
                                                            id="delivery_date" name="delivery_date">
                                                    </div>
                                                <div class="form-group">
                                                    <label>
                                                    <i style="color:#527C8F;" class="fa fa-comments fa-lg mr-1"></i>    
                                                    Observation</label></br>
                                                    <textarea type="text" class="form-control" name="observation" id="observation"></textarea>
                                                </div>
                                                <div class="row">
                                                    <button type="button" id="btnAddLivraison" class="btn btn-primary col-md-5 mr-3 ml-3">
                                                        <i class="fas fa-check mr-1" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg"></i>
                                                        <i class="fas fa-clock fa-sm mr-2"></i>
                                                        Enrégistrer
                                                    </button>
                                                    <button type="button" id="btnAnnuler" class="btn btn-danger col-md-6">
                                                        <i class="fas fa-times" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg"></i>
                                                        <i class="fas fa-clock fa-sm mr-2"></i>
                                                        Annuler
                                                    </button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditlivraison" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                <i class="fas fa-pen mr-1" style="font-size:10px;"></i>
                <i class="fas fa-truck fa-lg"></i>
                <i class="fas fa-clock mr-3" style="font-size:10px;"></i>
                    </span>
                Edition Livraison <span class="badge badge-success" id="edit_livs"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="livraisonFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Numéro Du Bon <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="order_numbers" name="order_number">
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="">Nom Client <span style="color:red;">  *</span></label>
                                                        <input type="text" class="form-control"
                                                            id="nom_clients" name="nom_client">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Téléphone Client<span style="color:red;">  *</span></label>
                                                        <input type="tel" class="form-control"
                                                            id="phone_clients" name="phone_client">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Véhicule <span style="color:red;">  *</span></label></br>
                                                    <select class="form-control" id="vehicule_ids" name="vehicule_id">
                                                        <option value="">Séléctionner Un Véhicule</option>
                                                        @foreach($cars as $car)
                                                            <option value="{{ $car->id }}">{{ $car->Immatriculation }} - {{ $car->tonnage }} Tonne</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                        <label>Date Livraison<span style="color:red;">  *</span></label></br>
                                                        <input type="date" class="form-control"
                                                            id="delivery_dates" name="delivery_date">
                                                </div>
                                                    <div class="form-group">
                                                        <label>Itinéraire <span style="color:red;">  *</span></label></br>
                                                        <input type="text" class="form-control"
                                                            id="itinerarys" name="itinerary">
                                                    </div>
                                                <div class="form-group">
                                                    <label>Observation</label></br>
                                                    <textarea type="text" class="form-control" name="observation"></textarea>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <button type="button" id="btnEditLivraison" class="btn btn-primary col-md-6 mr-2 ml-2">
                                                        <i class="fas fa-check mr-1" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg mr-2"></i>Modifier
                                                    </button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5" data-dismiss="modal">
                                                        <i class="fas fa-times fa-lg mr-2"></i>
                                                        Fermer
                                                    </button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation Save Livraison -->
    <div class="modal fade" id="modalConfirmationSaveLivraison" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                                                                    <span  class="badge badge-success">
                                                                                                    NUMERO BON</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="order_number_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    ITINERAIRE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="itineraire_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    CLIENT</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="client_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    TONNAGE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="tonnage_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    DISTANCE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="distance_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    RECETTE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="recette_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    MONTANT</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="mt_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    MONTANT REELEMENT PAYER</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="mts_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    TYPE DE LIVRAISON</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="type_of_delivery"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    VEHICULE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="car_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    Date De Livraison</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="date_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    Observation</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="observation_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <tbody>
                                                        </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-livraisons="{{ $livraisons }}" id="conf_save_livraison" class="btn btn-primary">OUI</button>
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
                                          <textarea id="validation" disabled style="width:100%; height:300px ;border-style:none; background-color:white;resize: none;color:black; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>
    
   
    <!-- Modal Satisfaction -->
    <div style="font-family:Century Gothic;" class="modal fade" id="satisfaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                            Avis Client
                                            <span class="badge badge-success mr-3" id="satisft"></span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                                <table class="table-bordered">
                                                            <tbody style="font-size:20px; color:black;">
                                                                <tr>
                                                                    <td style="padding: 10px">Nom</td><td style="padding: 15px; width:7em;"><span id="nam_c"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding: 10px">Numéro</td><td style="padding: 15px; width:7em;"><span id="tel_c"></span></td>
                                                                </tr>
                                                            </tbody>
                                                </table>
                                                <div class="form-group mt-3">
                                                    <select class="form-control col-md-12" name="satisfaction" id="satis">
                                                        <option value="" style="font-weight:bold;">Avis Du Client</option>
                                                        <option value="Satisfait">Satisfait</option>
                                                        <option value="Non_Satisfait">Non Satisfait</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" style="font-weight:bold;">Commentaire (Quel Est Votre Appréciation Par Rapport A Votre Livraison ?)</label>
                                                    <textarea id="satiscomment" class="form-control"></textarea>
                                                </div>
                                      </div>
                                      <div class="modal-footer">
                                        <div class="row col-md-12">
                                            <button id="btnSubmitAvis" data-id="" type="button" class="btn btn-info col-md-12">Valider</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
    </div>
    

    <!-- Modal Incident -->
    <div class="modal fade" id="incident" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white; font-family:Century Gothic;">
                                            <i class="fa fa-tools fa-lg mr-3"></i>
                                            Incident
                                            <span class="badge badge-success mr-3" id="indanc"></span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                            <p>
                                                <span style="font-family:Century Gothic; font-size:20px; font-weight:bold;">
                                                    <i class="fa fa-info-circle fa-lg mr-3"></i>
                                                    Informations Client
                                                </span>
                                            </p>
                                            <table class="table-bordered">
                                                            <tbody style="font-size:20px; color:black;">
                                                                <tr>
                                                                    <td style="padding: 10px">Nom</td><td style="padding: 15px; width:7em;"><span id="nam"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding: 10px">Numéro</td><td style="padding: 15px; width:7em;"><span id="tel"></span></td>
                                                                </tr>
                                                            </tbody>
                                            </table>
                                            <p style="font-family:Century Gothic; font-size:15px; color:black; margin-top:2em;">
                                            <i class="fa fa-info-circle fa-lg mr-1"></i>
                                            Observation Faite A La Livraison</p>
                                            <textarea disabled id="obs" class="form-control" rows="3"></textarea>
                                            <div class="form-group mt-4">
                                                <select style="font-family:Century Gothic;" class="form-control col-md-12" name="incident" id="incidant">
                                                        <option value="">Etat De L'incident</option>
                                                        <option value="EnAttente">En Attente</option>
                                                        <option value="Clôturé">Clôturé</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="font-family:Century Gothic;">
                                                    <label for="" style="font-weight:bold;">Incident (De Quoi S'agit-il ? )</label>
                                                    <textarea id="incide_liv" class="form-control"></textarea>
                                            </div>
                                      </div>
                                      <div class="modal-footer">
                                        <div class="row col-md-12" style="font-family:Century Gothic;">
                                            <button id="btnSubmitIncident" data-id="" type="button" class="btn btn-success col-md-12">Valider</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
    </div>
    
    <!-- Modal View Livraison -->
    <div class="modal" id="viewInfoLiv" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xs">
                                  <div class="modal-content">
                                    <div class="modal-header bg-dark">
                                      <h5 class="modal-title" id="exampleModalLabel" style="color:#FFFFFF;font-weight: bold;">
                                      <i class="fas fa-info fa-lg mr-3"></i>
                                      Informations Livraison <span class="badge badge-success" id="number_bon"></span></h5>
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
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <span  style="color:black;">
                                                                        Numéro Du Bon</span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="numerobx">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <span  style="color:black;">Véhicule De Livraison</span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="vehi">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <span  style="color:black;">Itinéraire</span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="itin">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <span  style="color:black;">Montant Total A Payer</span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="background-color:white; border-style: none; font-weight:bolder;" disabled type="text" id="mt_a_paye">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span  style="color:black;">Observation</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                              <textarea style="background-color:white; border-style: none; font-weight:bolder;" name="" disabled id="obser" cols="30" rows="3"></textarea>
                                                                              </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span  style="color:black;">Incident</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                    <textarea style="background-color:white; border-style: none; font-weight:bolder;" name="" id="incidants" cols="30" rows="3"></textarea>
                                                                              </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span  style="color:black;">Avis Du Client</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                <textarea style="background-color:white; border-style: none; font-weight:bolder;" name="" id="avi" cols="30" rows="3"></textarea>
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
    <!-- Modal Fichier -->
    <div class="modal fade" id="upload_file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white; font-family:Century Gothic;">
                                        Pièces Jointes De La Livraison
                                        <span class="badge badge-success mr-3" id="fill"></span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                                <form action="upload.php" method="POST" enctype="multipart/form-data">
                                                    <!-- <input type="hidden" value="" name="ids" id="name_file"> -->
                                                    <input type="hidden" value="" name="id" id="idlivraison">
                                                    <div class="form-group mb-4">
                                                        <input style="font-family:Century Gothic;" type="file" id="inputfile" name="file">
                                                    </div>
                                                    @can('charger-fichier')
                                                    <div class="form-group">
                                                        <button id="btnloadfile" type="submit" style="font-family:Century Gothic;" name="submit" class="btn btn-dark col-md-12">
                                                            <i class="fa fa-upload fa-2x mr-3"></i>    
                                                            Charger Le Fichier De La Livraison
                                                        </button>
                                                    </div>
                                                    @endcan
                                                    <?php 
                                                        $role = auth()->user()->roles[0]->name;
                                                    ?>
                                                    @if($role !== "EMPLOYEE")
                                                    <div class="form-group">
                                                        <button type="submit" style="font-family:Century Gothic;" id="" name="submit_download" class="btn btn-dark col-md-12">
                                                            <i class="fa fa-download fa-2x mr-3"></i>
                                                            Télécharger Le Fichier De La Livraison
                                                        </button>
                                                    </div>
                                                    @endif
                                                </form>
                                      </div>
                                      <div class="modal-footer">
                                        <div class="row col-md-12"></div>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal Annulation -->
    <div class="modal fade" id="annulation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white; font-family:Century Gothic;">
                                            Motif D'annulation
                                            <span class="badge badge-success" id="motiff"></span>
                                        </h5>
                                        <button id="close_annulation_button" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="" style="font-weight:bold; font-family:Century Gothic;">Motif (De Quoi S'agit-il ? )</label>
                                                    <textarea id="motif_annulation" class="form-control" rows="4"></textarea>
                                                </div>
                                      </div>
                                      <div class="modal-footer">
                                        <div class="row col-md-12">
                                            <button style="font-family: Century Gothic; font-size:15px;" id="btn_annulation" data-id="" type="button" class="btn btn-danger col-md-12">
                                                <span class="icon text-white-80">
                                                    <i class="fas fa-lg fa-truck"></i>
                                                    <i class="fas fa-sm fa-times mr-3"></i>
                                                </span>
                                            Valider
                                            </button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal Livraison -->
    <div class="modal fade" id="livrais" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white; font-family:Century Gothic;">Livraison <span class="badge badge-success ml-4" id="bx"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                                <p>
                                                    <span style="font-family:Century Gothic; font-size:20px; font-weight:bold;">
                                                        <i class="fa fa-info-circle fa-lg mr-3"></i>
                                                        Informations Client
                                                    </span>
                                                </p>
                                                <table class="table-bordered">
                                                                <tbody style="font-size:20px; color:black;">
                                                                    <tr>
                                                                        <td style="padding: 10px">Nom</td><td style="padding: 15px; width:7em;"><span id="dem"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding: 10px">Numéro De Téléphone</td><td style="padding: 15px; width:7em;"><span id="telo"></span></td>
                                                                    </tr>
                                                                </tbody>
                                                </table>
                                                <hr>
                                                <div class="form-group mt-5">
                                                    <label for="" style="font-family: Century Gothic; font-weight:bold;">Date Réelle De Livraison</label>
                                                    <input type="date" class="form-control" name="" id="datelivs">
                                                </div>
                                                <div class="form-group">
                                                <label for="" style="font-family: Century Gothic; font-weight:bold;">Etat De La Livraison</label>
                                                    <select 
                                                                style="background-color: #EEF7FF;"
                                                                title="Etat Livraison"
                                                                class="form-control" 
                                                                name="etat_livraison"
                                                                id="etat_livs"
                                                            >
                                                                <option value="">Etat</option>
                                                                <option value="CONFORME">Conforme</option>
                                                                <option value="ENDOMAGEE">Endomagée</option>
                                                                <option value="PARTIELLE">Partielle</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                        <div class="form-group" style="font-family:Century Gothic;">
                                                            <label for="" style="font-weight:bold;">Observation (Remarque Au Sujet De La Livraison ? )</label>
                                                            <textarea id="observation_a_la_livraison" class="form-control" rows="3"></textarea>
                                                        </div>
                                                </div>
                                      </div>
                                      <div class="modal-footer">
                                        <div class="row col-md-12">
                                            <button style="font-family: Century Gothic; font-size:15px;" id="btns_livs" data-filename="" data-id="" type="button" class="btn btn-secondary col-md-12">
                                                <span class="icon text-white-80">
                                                    <i class="fas fa-lg fa-truck"></i>
                                                    <i class="fas fa-sm fa-check mr-3"></i>
                                                </span>
                                            Valider
                                            </button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('livraison.js') }}"></script>
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