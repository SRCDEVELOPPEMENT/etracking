$('#btnAddRegion').on('click', function(){
    
    let good = true;
    let message = "";

    if(!$('#region').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Région !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $('#region_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="region_conf">${$('#region').val().trim()}</span>`);
        $('#desc_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="desc_conf">${$("#Description").val()}</span>`);
        $('#modalConfirmationSaveRegion').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveRegion').attr('data-keyboard', false);
        $('#modalConfirmationSaveRegion').modal('show');
    }    
});


$(document).on('click', '#conf_save_region', function(){
    $.ajax({
        type: 'POST',
        url: "createRegion",
        data: $('#regionFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){
            if(data.length == 2){
                $(this).attr('data-regions', JSON.stringify(data[1]));

                let region = data[0];
                if(region){
                    $('#dataTable').prepend(`
                    <tr style="font-size:15px; color:black;">
                        <td><label>${region.region_name}</label></td>
                        <td> 
                            <div class='row'>
                            <button class="btn btn-sm btn-info mr-2" id="btnEdit" data-id=${region.id} data-intituleRegion=${region.region_name}><span class="icon text-white-80"><i class="fas fa-edit"></i></span>Editer</button>
                            <button class="btn btn-sm btn-danger mr-2" id="btnDelete" data-id=${region.id}><span class="icon text-white-80"><i class="fas fa-trash"></i></span>Supprimer</button>
                            </div>
                        </td>
                    </tr>
                    `)
                    $("#regionFormInsert")[0].reset();
                    $('#modalConfirmationSaveRegion').modal('toggle');
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


$(document).on('click', '#btnEdit', function(){

    let id = $(this).attr('data-id');
    let region = $(this).attr('data-intituleRegion');

    $("#regionFormEdit")[0].reset();
    
    $('.form-group #id').val(id);
    $('.form-group #regions').val(region);
    
    $('#modalEditregion').attr('data-backdrop', 'static');
    $('#modalEditregion').attr('data-keyboard', 'false');
    $('#modalEditregion').modal('show');

})


$('#btnEditregion').on('click', function(){

        let good = true;
        let message = "";

        if(!$('#regions').val().trim()){
            good = false;
            message+="Veuillez Renseigner Une Région !\n";
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
                url: 'editRegion',
                data: $('#regionFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        location.reload();
                    }else{
                        alert('Veuillez Modifier Votre Région Car Déja Existant');
                    }
                }
            })
        }
})


$(document).on('click', '#btnDelete', function(){
    let sites = JSON.parse($(this).attr('data-sites'));
    let good = true;

    sites.forEach(site => {
        if(site.region_id == parseInt($(this).attr('data-id'))){good = false;}
    });
    if(good){
        if(confirm("Voulez-Vous Vraiment Supprimer Cette Région : "+ $(this).attr('data-intituleRegion') +" ?") == true){
                $.ajax({
                    type: 'GET',
                    url: 'deleteRegion',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    }else{
        $('#validation').val("Vous Ne Pouvez Pas Supprimer Cette Région : "+ $(this).attr('data-intituleRegion') +" Car Il Est Associé A Un Site !");
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');        
    }
})

$(document).on('click', '#btnClose', function(){
    location.reload();
});

$(function() { 
    $('#btnExit').click(function() {
        $('#regionFormInsert')[0].reset();
    }); 
}); 

