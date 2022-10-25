$('#btnAddRecette').on('click', function(){
    
    let good = true;
    let message = "";

    if(!$('#nature').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Nature !\n";
    }
    if(!$('#value').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Valeur !\n";
    }
    if(!$('#itinerary').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Itinéraire !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $('#nature_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="nature_conf">${$('#nature').val().trim()}</span>`);
        $('#valeur_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="valeur_conf">${$("#value").val()}</span>`);
        $('#car_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="car_conf">${$("#vehicule_id option:selected").text()}</span>`);
        $('#itinerary_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="itinerary_conf">${$("#itinerary").val()}</span>`);
        $('#modalConfirmationSaveRecette').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveRecette').attr('data-keyboard', false);
        $('#modalConfirmationSaveRecette').modal('show');
    }
});


$(document).on('click', '#conf_save_recette', function(){
    $.ajax({
        type: 'POST',
        url: "createRecette",
        data: $('#recetteFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){
            if(data.length == 2){
                $(this).attr('data-recettes', JSON.stringify(data[1]));

                let recette = data[0];
                if(recette){
                    $('#dataTable').prepend(`
                    <tr style="font-size:15px; color:black;">
                        <td><label>${recette.nature}</label></td>
                        <td><label>${recette.value}</label></td>
                        <td><label>${recette.itinerary}</label></td>
                        <td> 
                            <div class='row'>
                            <button class="btn btn-sm btn-info mr-2" id="btnEdit" data-id=${recette.id}><span class="icon text-white-80"><i class="fas fa-edit"></i></span>Editer</button>
                            <button class="btn btn-sm btn-danger mr-2" id="btnDelete" data-id=${recette.id}><span class="icon text-white-80"><i class="fas fa-trash"></i></span>Supprimer</button>
                            </div>
                        </td>
                    </tr>
                    `)
                    $("#recetteFormInsert")[0].reset();
                    $('#modalConfirmationSaveRecette').modal('toggle');
                }
            }
        }               
        })
});


$(document).on('click', '#btnEdit', function(){

    let id = $(this).attr('data-id');
    let nature = $(this).attr('data-nature');
    let value = $(this).attr('data-value');
    let car = $(this).attr('data-itinerary');
    let itinerary = $(this).attr('data-itinerary');
    $("#recetteFormEdit")[0].reset();
    
    let newRecipe = JSON.parse($(this).attr('data-recipe'));

    $('.form-group #id').val(id);
    $('.form-group #natures').val(nature);
    $('.form-group #values').val(value);
    $('.form-group #itinerarys').val(itinerary);
    $('.form-group #vehicule_ids').val(newRecipe.vehicule_id);
    
    $('#modalEditrecipe').attr('data-backdrop', 'static');
    $('#modalEditrecipe').attr('data-keyboard', 'false');
    $('#modalEditrecipe').modal('show');

})


$('#btnEditrecette').on('click', function(){

        let good = true;
        let message = "";

        if(!$('#natures').val().trim()){
            good = false;
            message+="Veuillez Renseigner Une Nature !\n";
        }
        if(!$('#values').val().trim()){
            good = false;
            message+="Veuillez Renseigner Une Valeur !\n";
        }
        if(!good){
            good = false;
            $('#validation').val(message);
            $('#errorvalidationsModals').attr('data-backdrop', 'static');
            $('#errorvalidationsModals').attr('data-keyboard', false);
            $('#errorvalidationsModals').modal('show');
        }else{
            $.ajax({
                type: 'POST',
                url: 'editRecette',
                data: $('#recetteFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        location.reload();
                    }else{
                        alert('Veuillez Modifier Votre Recètte Car Déja Existant');
                    }
                }
            })
        }
})


$(document).on('click', '#btnDelete', function(){
    // let sites = JSON.parse($(this).attr('data-sites'));
    // let good = true;

    // sites.forEach(site => {
    //     if(site.region_id == parseInt($(this).attr('data-id'))){good = false;}
    // });
    // if(good){
        if(confirm("Voulez-Vous Vraiment Supprimer Cette Recètte : "+ $(this).attr('data-nature') +" ?") == true){
                $.ajax({
                    type: 'GET',
                    url: 'deleteRecette',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    // }else{
    //     $('#validation').val("Vous Ne Pouvez Pas Supprimer Cette Région : "+ $(this).attr('data-intituleRegion') +" Car Il Est Associé A Un Site !");
    //     $('#errorvalidationsModals').attr('data-backdrop', 'static');
    //     $('#errorvalidationsModals').attr('data-keyboard', false);
    //     $('#errorvalidationsModals').modal('show');        
    // }
})

$(document).on('click', '#btnClose', function(){
    location.reload();
});

$(function() { 
    $('#btnExit').click(function() {
        $('#recetteFormInsert')[0].reset();
    }); 
}); 

