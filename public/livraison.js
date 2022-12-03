$('#btnAddLivraison').on('click', async function(){
    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
    let good = true;
    let message = "";

    if(!$('#type_delivery').val().trim()){
        good = false;
        message+="Veuillez Séléctionner Un Type De Livraison !\n";
    }
    if(!$('#order_number').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Numéro De Bon De Commande !\n";
    }
    
    if(!$('#delivery_date').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Date De Livraison !\n";
    }else{
        let date_saisi = $('#delivery_date').val().split('-')[0] +""+ $('#delivery_date').val().split('-')[1] +""+ $('#delivery_date').val().split('-')[2];

        let date_today = new Date ().toISOString ().split ('T')[0];
        let today = date_today.split('-')[0] +""+ date_today.split('-')[1] +""+ date_today.split('-')[2];
        
        if(parseInt(date_saisi) < parseInt(today)){
            good = false;
            message+="Veuillez Renseigner Une Date De Livraison Ultérieure A La Date Actuelle !\n";
        }
    }

    if(!$('#vehicule_id').val().trim()){
        good = false;
        message+="Veuillez Choisir Un Véhicule De Livraison !\n";
    }
    if(!$('#itinerary').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Itinéraire !\n";
    }
    if(!$('#destination').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Destination !\n";
    }
    if(!$('#nom_client').val().trim()){
        good = false;
        message+="Veuillez Renseigner Le Nom Du Client !\n";
    }
    if(!$('#phone_client').val().trim()){
        good = false;
        message+="Veuillez Renseigner Le Téléphone Du Client !\n";
    }else{
        if(!reg.test($('#phone_client').val())){
            good = false;
            message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";
        }
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $('#type_of_delivery').replaceWith(`<span style="color: black; font-size: 20px;" id="type_of_delivery">${$("#type_delivery option:selected").text()}</span>`)
        $('#mt_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="mt_conf">${$('#vue_amount').val()}</span>`)
        $('#mt_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="mt_conf">${$('#vue_amount').val()}</span>`)
        $('#mts_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="mts_conf">${$('#amount_paye').val() ? $('#amount_paye').val() : ''}</span>`)
        $('#observation_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="observation_conf">${$('#observation').val().trim()}</span>`);   
        $('#client_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="client_conf">${$('#nom_client').val().trim() +' '+ $('#phone_client').val().trim()}</span>`);   
        $('#itineraire_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="itineraire_conf">${$('#itinerary').val().trim()}</span>`);
        $('#order_number_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="order_number_conf">${$('#order_number').val().trim()}</span>`);
        $('#destination_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="destination_conf">${$("#destination").val()}</span>`);
        $('#tonnage_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="tonnage_conf">${$("#tonnage").val()}</span>`);
        $('#distance_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="distance_conf">${$("#distance").val()}</span>`);
        $('#recette_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="recette_conf">${$("#recipe_id option:selected").text()}</span>`);
        $('#car_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="car_conf">${$("#vehicule_id option:selected").text()}</span>`);
        $('#date_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="date_conf">${$("#delivery_date").val()}</span>`);
        $('#modalConfirmationSaveLivraison').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveLivraison').attr('data-keyboard', false);
        $('#modalConfirmationSaveLivraison').modal('show');
    }    
});


$(document).on('click', '#conf_save_livraison', function(){
    $.ajax({
        type: 'POST',
        url: "createLivraison",
        data: $('#livraisonFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){
            if(data.length == 2){
                $(this).attr('data-livraisons', JSON.stringify(data[1]));

                let livraison = data[0];
                if(livraison){
                    $('#dataTable').prepend(`
                    <tr style="font-size:15px; color:black;">
                        <td><label>${livraison.order_number}</label></td>
                        <td><label>${livraison.delivery_amount ? livraison.delivery_amount : "0"}</label></td>
                        <td><label></label></td>
                        <td><label>${livraison.destination}</label></td>
                        <td><label>${livraison.nom_client +' '+ livraison.phone_client}</label></td>
                        <td><label>${livraison.delivery_date}</label></td>
                        <td><label>${livraison.type_livraison}</label></td>
                        <td><label>${livraison.state}</label></td>
                        <td><label>${livraison.incident ? livraison.incident : ""}</label></td>
                        <td><label>${livraison.etat_livraison ? livraison.etat_livraison : ""}</label></td>
                        <td><label>${livraison.avis ? livraison.avis : ''}</label></td>
                        <td> 
                            <div class='row'>
                                <button class="btn btn-sm btn-info mr-2" id="btnEdit"><span class="icon text-white-80"><i class="fas fa-edit"></i></span>Editer</button>
                                <button class="btn btn-sm btn-danger mr-2" id="btnDelete"><span class="icon text-white-80"><i class="fas fa-trash"></i></span>Supprimer</button>
                                <button id="btnlivi" class="btn btn-sm btn-lg btn-secondary mr-2"
                                                                title="Livraison"
                                                            >
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-clock"></i>
                                                                </span>
                                </button>
                                <button 
                                                                id="satisfaction_client"
                                                                title="Avis Du Client"
                                                                class="btn btn-sm btn-dark mr-2">
                                                                Avis
                                </button>
                                <button 
                                                                id="incident_livraison"
                                                                title="Incident Subvenue"
                                                                class="btn btn-sm btn-success mr-2"
                                                                Incident
                                </button>
                                <button
                                                                id="btnInfs"
                                                                class="btn btn-lg btn-info mr-2"
                                                                title="Information Supplémentaire"
                                                            >
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-info"></i>
                                                                </span>
                                </button>
                                <button
                                                            title="Pièce Jointe"
                                                            id="files"
                                                            class="btn btn-lg btn-primary mr-2">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-file"></i>
                                                                </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    `)
                    $("#livraisonFormInsert")[0].reset();
                    $('#modalConfirmationSaveLivraison').modal('toggle');
                }
            }else{
                $('#validation').val('Veuillez Modifier Votre Région Car Déja Existant !');
                $('#errorvalidationsModals').attr('data-backdrop', 'static');
                $('#errorvalidationsModals').attr('data-keyboard', false);
                $('#errorvalidationsModals').modal('show');        
            }
        }         
    })
});

$(document).on('click', '#btnLoad', function(){
    window.location.href = "/livraisons";
});

$(document).on('click', '#btnClose', function(){
    location.reload();
});



$(document).on('click', '#btnEdit', function(){

    let id = $(this).attr('data-id');
    let livraison = JSON.parse($(this).attr('data-livraisons'));
    $('#edit_livs').replaceWith(`<span class="badge badge-success" id="edit_livs">${livraison.order_number}</span>`);
    if(parseInt(livraison.distance) > 0){
        $('#tonnages').prop('disabled', true);
        $('#recipe_ids').prop('disabled', true);
        $('#recipe_ids').append(`<option selected value="">Selectionner Une Recètte</option>`);
    }else{
        $('#distances').prop('disabled', true);
    }

    $("#livraisonFormEdit")[0].reset();
    
    $('.form-group #id').val(id);
    $('.form-group #order_numbers').val(livraison.order_number);
    $('.form-group #states').val(livraison.state);
    $('.form-group #delivery_dates').val(livraison.delivery_date);
    $('.form-group #really_delivery_date').val(livraison.really_delivery_date);
    $('.form-group #destinations').val(livraison.destination);
    $('.form-group #tonnages').val(livraison.tonnage);
    $('.form-group #distances').val(livraison.distance);
    $('.form-group #recipe_ids').val(livraison.recipe_id);
    $('.form-group #vehicule_ids').val(livraison.vehicule_id);
    $('.form-group #nom_clients').val(livraison.nom_client);
    $('.form-group #phone_clients').val(livraison.phone_client);
    $('.form-group #itinerarys').val(livraison.itinerary);

    $('#modalEditlivraison').attr('data-backdrop', 'static');
    $('#modalEditlivraison').attr('data-keyboard', 'false');
    $('#modalEditlivraison').modal('show');

})


$('#btnEditLivraison').on('click', function(){
    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
        let good = true;
        let message = "";

        if(!$('#order_numbers').val().trim()){
            good = false;
            message+="Veuillez Renseigner Un Numéro De Bon De Commande !\n";
        }
        if(!$('#delivery_dates').val().trim()){
            good = false;
            message+="Veuillez Renseigner Une Date De Livraison !\n";
        }
        if(!$('#itinerarys').val().trim()){
            good = false;
            message+="Veuillez Renseigner Un Itinéraire !\n";
        }
        if(!$('#nom_clients').val().trim()){
            good = false;
            message+="Veuillez Renseigner Le Nom Du Client !\n";
        }
        if(!$('#phone_clients').val().trim()){
            good = false;
            message+="Veuillez Renseigner Le Téléphone Du Client !\n";
        }else{
            if(!reg.test($('#phone_clients').val())){
                good = false;
                message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";
            }
        }    
        if(!$('#vehicule_ids').val().trim()){
            good = false;
            message+="Veuillez Choisir Un Véhicule De Livraison !\n";
        }      
        if(!good){
            good = false;
            $('#validation').val(message);
            $('#errorvalidationsModals').attr('data-backdrop', 'static');
            $('#errorvalidationsModals').attr('data-keyboard', false);
            $('#errorvalidationsModals').modal('show');
        }else{
            $.ajax({
                type: 'PUT',
                url: 'editLivraison',
                data: $('#livraisonFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    console.log(data);
                    if(parseInt(data[0]) == 1){
                        location.reload();
                    }else{
                        alert('Veuillez Modifier Votre Livraison Car Déja Existant');
                    }
                }
            })
        }
})


$(document).on('click', '#btnannul', function(){
    $('#btn_annulation').attr('data-id', $(this).attr('data-id'));
    $('#motiff').replaceWith(`<span class="badge badge-success" id="motiff">${$(this).attr('data-bx')}</span>`);
});

$(document).on('click', '#close_annulation_button', function(){
    $('#motif_annulation').val('');
});
$(document).on('click', '#btn_annulation', function(){
    if($('#motif_annulation').val().trim()){
        if(confirm("Voulez-Vous Vraiment Annuler Cette Livraison ?") == true){
            $.ajax({
                type: 'GET',
                url: 'deleteLivraison',
                data: { 
                        id: $(this).attr('data-id'),
                        motif: $('#motif_annulation').val(),
                    },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(element){
                    if(parseInt(element[0]) == 1){
                        location.reload();
                    }
                }
        })
        } 
    }else{
        alert("Veuillez Renseigner Un Motif D'annulation !");
    }  
});

$(document).on('click', '#btnlivi', function(){
    let livraison = JSON.parse($(this).attr('data-livraison'));
    $('#dem').replaceWith(`<span id="dem">${livraison.nom_client}</span>`);
    $('#telo').replaceWith(`<span id="telo">${livraison.phone_client}</span>`)
    $('#btns_livs').attr('data-id', livraison.id);
    $('#btns_livs').attr('data-filename', livraison.filename);
    $('#bx').replaceWith(`<span class="badge badge-success ml-4">${livraison.order_number}</span>`)
});


$(document).on('click', '#btns_livs', function(){
    if($(this).attr('data-filename')){
        if($('#datelivs').val() && $('#etat_livs').val()){
        $.ajax({
            type: 'GET',
            url: 'doStatut',
            data: { statut_livraison: "LIVRER",
                    date: $('#datelivs').val(),
                    id: $(this).attr('data-id'),
                    etat_livraison: $('#etat_livs').val(),
                    obs: $('#observation_a_la_livraison').val(),
                  },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(element){
                if(parseInt(element[0]) == 1){
                    location.reload();
                }
            }
        });
        }else{
            alert('Veuillez Renseigner Une Date De Livraison Ou Un Etat De La Livraison !');
        }
    }else{
        alert("Veuillez Tout D'abord Chargé Le Fichier De Livraison !");
    }
});

$(document).on('change', '#inputfile', function(){
    if($(this).val()){
        $('#btnloadfile').prop('disabled', false);
    }else{
        $('#btnloadfile').prop('disabled', true);
    }
});

$(document).on('click', '#files', function(){
    if(!$(this).attr('data-file')){
        $('#btnloadfile').prop('disabled', true);
    }
    $('#idlivraison').val($(this).attr('data-id'));
    $('#fill').replaceWith(`<span class="badge badge-success mr-3" id="fill">${$(this).attr('data-bx')}</span>`);
});


$(document).on('click', '#satisfaction_client', function(){
    $('#btnSubmitAvis').attr('data-id', $(this).attr('data-id'));
    let livraison = JSON.parse($(this).attr('data-livraison'));
    $('#nam_c').replaceWith(`<span id="nam_c">${livraison.nom_client}</span>`);
    $('#tel_c').replaceWith(`<span id="tel_c">${livraison.phone_client}</span>`);
    $('#satisft').replaceWith(`<span class="badge badge-success mr-3" id="satisft">${livraison.order_number}</span>`);
    $('#satiscomment').val(livraison.commentaire_avis);
})


$(document).on('click', '#btnSubmitAvis', function(){
    if($('#satis').val()){
        $.ajax({
            type: 'PUT',
            url: 'give_avis_client',
            data: { 
                    avis: $('#satis').val(),
                    comment: $('#satiscomment').val(),
                    id: $(this).attr('data-id')
                  },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(element){
                if(parseInt(element[0]) == 1){
                    location.reload();
                }
            }
        });
    }else{
        alert('Veuillez Séléctionner Un Avis ?');
    }
})

$(document).on('click', '#incident_livraison', function(){
    $('#btnSubmitIncident').attr('data-id', $(this).attr('data-id'));
    let livraison = JSON.parse($(this).attr('data-livraison'));
    $('#obs').val(livraison.observation_a_la_livraison);
    $('#nam').replaceWith(`<span id="nam">${livraison.nom_client}</span>`);
    $('#tel').replaceWith(`<span id="tel">${livraison.phone_client}</span>`);
    $('#indanc').replaceWith(`<span class="badge badge-success mr-3" id="indanc">${livraison.order_number}</span>`);
    $('#incide_liv').val(livraison.commentaire_incident);
});

$(document).on('click', '#btnSubmitIncident', function(){
    if($('#incidant').val()){
        $.ajax({
            type: 'PUT',
            url: 'set_incident',
            data: { 
                    incidant: $('#incidant').val(),
                    incide_liv: $('#incide_liv').val(),
                    id: $(this).attr('data-id')
                  },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(element){
                if(parseInt(element[0]) == 1){
                    location.reload();
                }
            }
        });
    }else{
        alert('Veuillez Séléctionner L\'état De L\'incident ?');
    }
});


$(document).on('input', '#tonnage', function(){
    if($('#tonnage').val() && $('select[id="recipe_id"]').val()){
        let recettes = JSON.parse($('select[id="recipe_id"]').attr('data-r'));
        let rectte_selectionne = recettes.find(r => r.id == $('select[id="recipe_id"]').val());
        if(!rectte_selectionne.kilometrage){
            let montant = parseInt($(this).val()) * rectte_selectionne.value;
            $('#vue_amount').val(montant);    
        }
    }else{
        $('#vue_amount').val('');
    }
});


//edit livraison
// $(document).on('input', '#tonnages', function(){
//     if($('#tonnages').val() || $('#recipe_id').val()){
//         $('#distances').prop('disabled', true);
//     }else{
//         $('#distances').prop('disabled', false);
//     }
// });

// $(document).on('change', '#recipe_ids', function(){
//     if($('#recipe_ids').val()){
//         $('#distances').prop('disabled', true);
//     }else{
//         $('#distances').prop('disabled', false);
//     }
// });

// $(document).on('input', '#distances', function(){
//     if($('#distances').val()){
//         $('#tonnages').prop('disabled', true);
//         $('#recipe_ids').prop('disabled', true);
//     }else{
//         $('#tonnages').prop('disabled', false);
//         $('#recipe_ids').prop('disabled', false);
//     }
// });

$(document).on('click', '#btnAnnuler', function(){
    $("#livraisonFormInsert")[0].reset();
    $('#modalLivraison').modal('toggle');
    $('#recipe_id').prop('disabled', false);
    $('#distance').prop('disabled', false);
    $('#tonnage').prop('disabled', false);
    $('#vue_amount').prop('disabled', false);
    location.reload();
});


$(document).on('change', '#type_delivery', function(){
    if($(this).val() == 2 || $(this).val() == 3){
        $('#vue_amount').val('');
        $('#amount_paye').val(0.0);
        $('#tonnage').val('');
        $('#tonnage').prop('disabled', true);
        $('#recipe_id').prop('disabled', true);
        $('#recipe_id').append(`<option value="" selected></option>`);
        $('#distance').val('');
        $('#distance').prop('disabled', true);
        $('#consommation_id').prop('disabled', true);
        $('#amount_paye').prop('disabled', true);
    }else if($(this).val() == 1){
        $('#tonnage').prop('disabled', false);
        $('#tonnage').val('');
        $('#recipe_id').prop('disabled', false);
        $('#recipe_id').append(`<option value="" selected></option>`);
        $('#distance').val('');
        $('#distance').prop('disabled', false);
        $('#amount_paye').prop('disabled', true);
        $('#amount_paye').val(0);
        $('#vue_amount').val('');
    }else{
        $('#amount_paye').val('');
        $('#vue_amount').val('');
        $('#tonnage').prop('disabled', false);
        $('#recipe_id').prop('disabled', false);
        $('#recipe_id').append(`<option value="" selected></option>`);
        $('#distance').prop('disabled', false);
        $('#distance').val('');
        $('#tonnage').prop('disabled', false);
        $('#tonnage').val('');
        $('#consommation_id').prop('disabled', false);
        $('#amount_paye').prop('disabled', false);
    }
});

$(document).on('change', '#recipe_id', function(){
    if($(this).val()){
        $('#distance').val('');
        $('#vue_amount').val('');
        $('#amount_paye').val('');
        $('#tonnage').val('');
    }
});



$(document).on('input', '#distance', function(){
    if($('#distance').val() && $('#tonnage').val() && $('#recipe_id').val()){
        let montant;

        let recettes = JSON.parse($('select[id="recipe_id"]').attr('data-r'));
        let recette_selectionne = recettes.find(r => parseInt(r.id) == parseInt($('select[id="recipe_id"]').val()));
        if(recette_selectionne.kilometrage){
            if(parseInt($('#distance').val()) < parseInt(recette_selectionne.kilometrage)){
                montant = parseInt($('#tonnage').val()) * recette_selectionne.value;
            }
        }else{
            montant = parseInt($('#tonnage').val()) * recette_selectionne.value;
        }
        $('#vue_amount').val(montant);
    }else{
        $('#vue_amount').val('');
    }
})


$(document).on('click', '#btnInfs', function(){
    let livraison = JSON.parse($(this).attr('data-livraison'));
    $('#number_bon').replaceWith(`<span class="badge badge-success" id="number_bon">${livraison.order_number}</span>`)
    $('#numerobx').val(livraison.order_number);
    $('#itin').val(livraison.itinerary);
    $('#obser').val(livraison.observation);
    $('#incidants').val(livraison.commentaire_incident ? livraison.commentaire_incident : 'AUCUN INCIDENT');
    $('#avi').val(livraison.commentaire_avis ? livraison.commentaire_avis : 'AUCUN COMMENTAIRE');
    $('#vehi').val(livraison.vehicules.Immatriculation + '  ' + livraison.vehicules.ModelVehicule);
    $('#mt_a_paye').val(livraison.delivery_amount);
});