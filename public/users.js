
$(document).on('click', '#btnAddUser', function(){

    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
    let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
    let good = true;
    let message = "";

    let tab = $('#conf_save_user').attr('data-utilisateurs');

    let utilisateurs = JSON.parse(tab);
    
    if(!$('#telephone').val().trim()){
            good = false;
            message+="Veuillez Renseigner Un Numéro De Téléphone !\n";
    }else{
        if(reg.test($('#telephone').val())){
            if($('#telephone').val().length == 9){
                if(parseInt($('#telephone').val().slice(0, 1)) != 6){
                    good = false;
                    message+="Format Du Numéro De Téléphone Incorrect !\n";            
                }else{
                    let second = parseInt($('#telephone').val().slice(1, 2));
                    if(second != 5 && second != 6 && second != 7 && second != 8 && second != 9){
                        good = false;
                        message+="Format Du Numéro De Téléphone Incorrect !\n";
                    }else{
                        let oui = true;
                        utilisateurs.forEach(utilisateur => {
                            if(parseInt(utilisateur.telephone) == parseInt($('#telephone').val().trim())){
                                oui = false;
                            }
                        });
                        if(!oui){
                            good = false;
                            message+="Veuillez Changer Le Numéro De Téléphone Car Déja Existant !\n";
                        }
                    }
                }
            }else{
                good = false;
                message+="Format Du Numéro De Téléphone Incorrect !\n";        
            }
      }else{
        good = false;
        message+="Format Du Numéro De Téléphone Incorrect !\n";        
      }  
    }
     

    if(!$('#roles').val().trim()){
        good = false;
        message+="Veuillez Choisir Un Role !\n";
    }       
    if(!good){
        good = false;
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $('#fullname_conf').replaceWith(`<span style="color: black; font-size: 15px;" id="fullname_conf">${$('#fullname').val()}</span>`);
        $('#phone_conf').replaceWith(`<span style="color: black; font-size: 15px;" id="phone_conf">${$("#telephone").val()}</span>`);
        $('#site_conf').replaceWith(`<span style="color: black; font-size: 15px;" id="site_conf">${$("#site_id option:selected").text()}</span>`);
        $('#username_conf').replaceWith(`<span style="color: black; font-size: 15px;" id="username_conf">${$("#login").val()}</span>`);
        $('#pass_conf').replaceWith(`<span style="color: black; font-size: 15px;" id="pass_conf">${$("#password").val()}</span>`);
        $('#role_conf').replaceWith(`<span style="color: black; font-size: 15px;" id="role_conf">${$("#roles option:selected").text()}</span>`);
        $('#car_conf').replaceWith(`<span style="color: black; font-size: 15px;" id="car_conf">${$("#vehicule_id option:selected").text()}</span>`);
        $('#modalconfirm_user').attr('data-backdrop', 'static');
        $('#modalconfirm_user').attr('data-keyboard', false);
        $('#modalconfirm_user').modal('show');
    }   
});

$(document).on('click', '#conf_save_user', function(){
    $.ajax({
        type: 'POST',
        url: "createUser",
        data: $('#userFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){
            if(data.length == 2){

                $(this).attr('data-utilisateurs', JSON.stringify(data[1]))
            
                let user = data[0];
                if(user){
                    $('#dataTable').prepend(`
                    <tr style="font-size:15px; color:black;">
                        <td><label> ${user.login ? user.login : ''} </label></td>
                        <td><label> ${user.fullname ? user.fullname : ''} </label></td>
                        <td><label> ${user.telephone} </label></td>
                        <td><label> ${user.sites ? user.sites.site_name : ''} </label></td>
                        <td><label></label></td>
                        <td> 
                            <button class="btn btn-sm btn-info mr-2" id="btnEdit" data-id=${user.id} data-fullname=${user.fullname}  data-DescriptionRegion=${user.fullname}><span class="icon text-white-80"><i class="fas fa-edit"></i></span>Editer</button>
                            <button class="btn btn-sm btn-danger mr-2" id="btnDelete" data-id=${user.id}><span class="icon text-white-80"><i class="fas fa-trash"></i></span>Suprrimer</button>
                            <button class="btn btn-sm btn-primary" id="btnView" data-intituleRegion="${user.fullname}  data-DescriptionRegion=${user.fullname} ><span class="icon text-white-80"><i class="fas fa-eye"></i></span>Vue</button>
                        </td>
                    </tr>
                    `)
                    $("#userFormInsert")[0].reset();
                    $('#modalconfirm_user').modal('toggle');
                }
            }else{
                $('#validation').val(data[0]);
                $('#errorvalidationsModals').attr('data-backdrop', 'static');
                $('#errorvalidationsModals').attr('data-keyboard', false);
                $('#errorvalidationsModals').modal('show');                
            }
         } 
        })
})

$(document).on('click', '#btnDelete', function(){
        if(confirm("Voulez-Vous Vraiment Supprimer Cette Utilisateur : "+ $(this).attr('data-fullname') +" ?") == true){
                $.ajax({
                    type: 'GET',
                    url: 'deleteUser',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    }
)

$(document).on('click', '#btnEdit', function(){

    let user = JSON.parse($(this).attr('data-user'));

    $('#idEditUser').val(user.id);
    $('#fullnames').val(user.fullname);
    $('#telephones').val(user.telephone);
    $('#site_ids').val(user.site_id);
    $('#logins').val(user.login);
    $('#passwords').val(user.password);
    $('#vehicule_ids').val(user.vehicule_id);
    $('#roles').val(user.roles.length > 0 ? user.roles[0].name : '');
});

$(document).on('click', '#btnEditUser', function(){

    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;

    let good = true;
    let message = "";

    let tab = $('#conf_save_user').attr('data-utilisateurs')

    let utilisateurs = JSON.parse(tab);
    

    if(!$('#fullnames').val().trim()){
    good = false;
    message+="Veuillez Renseigner Une Nom Complèt !\n";
    }

    if(!$('#telephones').val().trim()){
            good = false;
            message+="Veuillez Renseigner Un Numéro De Téléphone !\n";
    }else{
        if(reg.test($('#telephones').val())){
            if($('#telephones').val().length == 9){
                if(parseInt($('#telephones').val().slice(0, 1)) != 6){
                    good = false;
                    message+="Format Du Numéro De Téléphone Incorrect !\n";            
                }else{
                    let second = parseInt($('#telephones').val().slice(1, 2));
                    if(second != 5 && second != 6 && second != 7 && second != 8 && second != 9){
                        good = false;
                        message+="Format Du Numéro De Téléphone Incorrect !\n";
                    }else{
                        let Qte = 0;
                        let array = [];
                        
                        utilisateurs.forEach(utilisateur =>{
                            if(parseInt(utilisateur.id) != parseInt($('#idEditUser').val())){
                                array.push(utilisateur);
                            }
                        });
                        array.forEach(utilisateur => {
                            if(parseInt(utilisateur.telephone) == parseInt($('#telephones').val())){
                                Qte +=1;
                            }
                        });
                        if(Qte > 0){
                            good = false;
                            message+="Veuillez Changer Le Numéro De Téléphone Car Déja Existant !\n";
                        }
                    }
                }
            }else{
                good = false;
                message+="Format Du Numéro De Téléphone Incorrect !\n";        
            }    
        }else{
            good = false;
            message+="Format Du Numéro De Téléphone Incorrect !\n";        
          }  
    }
    // if(!$('#loginEditUser').val().trim()){
    //     good = false;
    //     message+="Veuillez Renseigner Un Nom D'utilisateur !\n";
    // }else{
    //     let Qte = 0;
    //     let array = [];
        
    //     utilisateurs.forEach(utilisateur =>{
    //         if(parseInt(utilisateur.id) != parseInt($('#idEditUser').val())){
    //             array.push(utilisateur);
    //         }
    //     });
    //     array.forEach(utilisateur => {
    //         if(utilisateur.login.trim().toLowerCase() == $('#loginEditUser').val().trim().toLowerCase()){
    //             Qte +=1;
    //         }
    //     });
    //     if(Qte > 0){
    //         good = false;
    //         message+="Veuillez Changer De Nom D'utilisateur Car Déja Existant !\n"; 
    //     }
    // }

    // if(!$('#passwordEditUser').val().trim()){
    //     good = false;
    //     message+="Veuillez Renseigner Un Mot De Passe !\n";
    // }else{
    //     if(!$('#confirm-passwordEditUser').val().trim()){
    //         good = false;
    //         message+="Veuillez Confirmer Votre Mot De Passe !\n"; 
    //     }else{
    //         if(!($('#passwordEditUser').val().trim() == $('#confirm-passwordEditUser').val().trim())){
    //             good = false;
    //             message+="Veuillez Renseigner Des Mot De Passe Identique !\n";        
    //         }
    //     }
    // }

    if(!$('#roles').val().trim()){
        good = false;
        message+="Veuillez Choisir Un Rôle !\n";
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
            url: "editUser",
            data: $('#userFormEdit').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            success: function(){
                    location.reload();
                } 
        });  
    }      
});

$(document).on('click', '#btnViewUser', function(){

    let user = JSON.parse($(this).attr('data-user'));

    $('#use_name').replaceWith(`<span class="badge badge-success" id="use_name">${user.login}</span>`)
    $('.form-group #name_user').val(user.fullname);
    $('.form-group #vehicule_user').val(user.vehicules ? user.vehicules.Immatriculation : '');
    $('.form-group #phone_user').val(user.telephone);
    $('.form-group #site_user').val(user.sites ? user.sites.site_name : '');
    $('.form-group #username').val(user.login ? user.login : '');
    $('.form-group #password_user').val($(this).attr('data-password'));
    if(user.roles.length > 1){
        let conc = "";
        for (let index = 0; index < user.roles.length; index++) {
            const elt = user.roles[index];
            conc += elt.name + "\n";
        }
        $('.form-group #role_user').val(conc);
    }else{
        $('.form-group #role_user').val(user.roles[0].name);
    }

})

$(document).on('click', '#btnExitEditUser', function(){
    $('#userFormEdit')[0].reset();
})

$(document).on('click', '#btnExitAddForm', function(){
    $('#userFormInsert')[0].reset();
});

$(document).on('click', '#btnCloseAddUser', function(){
    location.reload();
});