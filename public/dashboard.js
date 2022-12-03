    $(document).on("change", '#region', function(){
        let colis = [];
        let courriers = JSON.parse($(this).attr('data-courriers'));
        let sites = JSON.parse($(this).attr('data-sites'));
        let regions = JSON.parse($(this).attr('data-regions'));
        
        if($(this).val()){

            courriers.forEach(courrier => {
                let site_courant = sites.find(site => parseInt(site.id) == parseInt(courrier.users.site_id));
                if(site_courant){
                    if(parseInt($(this).val()) == parseInt(site_courant.region_id)){
                        colis.push(courrier);
                    }
                }
            });
            var region = regions.find(region => parseInt(region.id) == parseInt($(this).val()));
            $('#name_region').replaceWith(`<span style="color:blue;" id="name_region">${region.intituleRegion}</span>`);
            $('#value_region').replaceWith(`<span id="value_region">${colis.length}</span>`);
        }
    });

    $(document).on('change', '#site', function(){
        let colis = [];
        let courriers = JSON.parse($(this).attr('data-courriers'));
        let sites = JSON.parse($(this).attr('data-sites'));

        if($(this).val()){
            select_site = sites.find(site => parseInt(site.id) == parseInt($(this).val()));
            courriers.forEach(courrier => {
                if(parseInt(courrier.site_exp_id) == parseInt($(this).val())){
                    colis.push(courrier);
                }
            });

            $('#name_site').replaceWith(`<span style="color:blue;" id="name_site">${select_site.intituleSite}</span>`);
            $('#value_site').replaceWith(`<span id="value_site">${colis.length}</span>`);
        }
    });

    $(document).on('change', '#dev', function(){
        if($('select[name="annees"]').val()){
            let livraisons = JSON.parse($(this).attr('data-livraison'));
            let regions = JSON.parse($(this).attr('data-regions'));
            let sites = JSON.parse($(this).attr('data-sites'));
            let tab = [];
            livraisons.forEach(livraison => {
                if(parseInt($(this).val()) == parseInt(livraison.created_at.slice(0,4))){
                    tab.push(livraison);
                }
            });

            for (let index = 0; index < regions.length; index++) {
                const region = regions[index];
                let Qte = 0;
                let liv = [];
                for (let index = 0; index < tab.length; index++) {
                    const livraison = tab[index];
                    
                    let site = sites.find(site => parseInt(site.id) == parseInt(livraison.users.site_id));
                    if(site){
                        if(region.id == site.region_id){
                            Qte +=1;
                            liv.push(livraison);
                        }
                    }
                }
                let QteEncours = 0;
                let QteLivrer = 0;
                let QteAnnuler = 0;
                for (let index = 0; index < liv.length; index++) {
                    const livraison = liv[index];
                    switch (livraison.state) {
                        case 'ENCOUR':
                            QteEncours +=1;
                            break;
                        case 'LIVRER':
                            QteLivrer +=1;
                            break;
                        case 'ANNULER':
                            QteAnnuler +=1;
                            break;
                        default:
                            break;
                    }
                }
                $(`#encou${index}`).replaceWith(`<span id='encou${index}'>${QteEncours}</span>`);
                $(`#endom${index}`).replaceWith(`<span id='endom${index}'>${QteLivrer}</span>`);
                $(`#partiel${index}`).replaceWith(`<span id='partiel${index}'>${QteAnnuler}</span>`);
                $(`#ch${index}`).replaceWith(`<span id="ch${index}">${Qte}</span>`);
            }
        }
    });

    $(document).on('click', '#symphos', function(){
        if($(this).val()){
            let livraisons = JSON.parse($(this).attr('data-livraison'));
            let regions = JSON.parse($(this).attr('data-regions'));
            let sites = JSON.parse($(this).attr('data-sites'));
            let users = JSON.parse($(this).attr('data-users'));

            let tab = [];

            livraisons.forEach(livraison => {
                if(parseInt($(this).val()) == parseInt(livraison.created_at.slice(0,4))){
                    tab.push(livraison);
                }
            });

            for (let index = 0; index < sites.length; index++) {
                const site = sites[index];
                let Qte = 0;
                let liv = [];
                for (let index = 0; index < tab.length; index++) {
                    const livraison = tab[index];
                    
                    if(parseInt(site.id) == parseInt(livraison.users.site_id)){
                        Qte +=1;
                        liv.push(livraison);
                    }
                }
                let QteEncours = 0;
                let QteLivrer = 0;
                let QteAnnuler = 0;

                let voyage = 0;
                let tour_ville = 0;
                let incident = 0;
                let avis_client = 0;

                for (let index = 0; index < liv.length; index++) {
                    const livraison = liv[index];

                    if(livraison.avis && livraison.avis == "Satisfait"){
                        avis_client +=1;
                    }

                    if(livraison.incident){
                        incident +=1;
                    }

                    let user = users.find(u => parseInt(u.id) == parseInt(livraison.user_id));
                    let site_user = sites.find(s => parseInt(s.id) == parseInt(user.site_id));    
                    if(site_user.ville == livraison.destination){
                        tour_ville +=1;
                    }else{
                        voyage +=1;
                    }

                    switch (livraison.state) {
                        case 'ENCOUR':
                            QteEncours +=1;
                            break;
                        case 'LIVRER':
                            QteLivrer +=1;
                            break;
                        case 'ANNULER':
                            QteAnnuler +=1;
                            break;
                        default:
                            break;
                    }
                }
                $(`#staten${index}`).replaceWith(`<span id='staten${index}'>${QteEncours}</span>`);
                $(`#statentr${index}`).replaceWith(`<span id='statentr${index}'>${QteLivrer}</span>`);
                $(`#statrecept${index}`).replaceWith(`<span id='statrecept${index}'>${QteAnnuler}</span>`);
                $(`#tube${index}`).replaceWith(`<span id='tube${index}'>${Qte}</span>`);
                $(`#voyage${index}`).replaceWith(`<span id='voyage${index}'>${voyage}</span>`);
                $(`#tour_ville${index}`).replaceWith(`<span id='tour_ville${index}'>${tour_ville}</span>`);
                $(`#incident_agence${index}`).replaceWith(`<span id='incident_agence${index}'>${liv.length > 0 ? (incident/liv.length) * 100 : 0}</span>`);
                $(`#avis_client${index}`).replaceWith(`<span id='avis_client${index}'>${liv.length > 0 ? (avis_client/liv.length) * 100 : 0}</span>`); 
            }
        }
    });

    $(function(){
        //LIVRAISON GLOBAL
        $('#totaux').append(`<option selected>${new Date().getFullYear()} </option>`);
        let livraisons = JSON.parse($('#totaux').attr('data-livraison'));

        let sites = JSON.parse($('#totaux').attr('data-sites'));
        let users = JSON.parse($('#totaux').attr('data-users'));
        let tab = [];
        let encours = 0;
        let livrer = 0;
        let annuler = 0;
        let tourVille = 0;
        let ligne = 0;
        let satisfaction = 0;
        let conforme = 0;
        let partielle = 0;
        let endomage = 0;
        let delais_respect = 0;
        let delais_non_respect = 0;

        livraisons.forEach(livraison => {
            if(parseInt(new Date().getFullYear()) == parseInt(livraison.created_at.slice(0,4))){
                tab.push(livraison);
            }
        });

        let element = 0;
        for (let index = 0; index < tab.length; index++) {
            const livraison = tab[index];
            switch (livraison.state) {
                case "ENCOUR":
                    encours +=1;
                    break;
                case "LIVRER":
                    livrer +=1;
                    break;
                case "ANNULER":
                    annuler +=1;
                    break;
            
                default:
                    break;
            }

            let user = users.find(u => parseInt(u.id) == parseInt(livraison.user_id));
            let site_user = sites.find(s => parseInt(s.id) == parseInt(user.site_id));
            if(site_user){
                if(site_user.ville == livraison.destination){
                    tourVille +=1;
                }else{
                    ligne +=1;
                }    
            }

            if(livraison.avis == "Satisfait"){
                element +=1;
            }

            if(livraison.really_delivery_date){
                let reel_datelivraison = livraison.really_delivery_date.replaceAll('-', '');
                let datelivraison = livraison.delivery_date.replaceAll('-', '');
                if((parseInt(reel_datelivraison) < parseInt(datelivraison)) || (parseInt(reel_datelivraison) == parseInt(datelivraison))){
                    delais_respect +=1;
                }else{
                    delais_non_respect +=1;
                }
            }

            switch (livraison.etat_livraison) {
                case "CONFORME":
                    conforme +=1;
                    break;
                case "PARTIELLE":
                    partielle +=1;
                    break;
                case "ENDOMAGEE":
                    endomage +=1;
                    break;
                default:
                    break;
            }
        }
        if(tab.length > 0){
            satisfaction = (parseInt(element)/tab.length) * 100;
        }

        $('#tot').replaceWith(`<span id="tot">${tab.length}</span>`)
        $('#encoursss').replaceWith(`<span id="encoursss">${encours}</span>`);
        $('#livree').replaceWith(`<span id="livree">${livrer}</span>`);
        $('#anulation').replaceWith(`<span id="anulation">${annuler}</span>`);
        $('#tville').replaceWith(`<span id="tville">${tourVille}</span>`);
        $('#lignevoyage').replaceWith(`<span id="lignevoyage">${ligne}</span>`);
        $('#satiste').replaceWith(`<span id="satiste">${satisfaction}</span>`);
        $('#confort').replaceWith(`<span id="confort">${conforme}</span>`);
        $('#part').replaceWith(`<span id="part">${partielle}</span>`);
        $('#endo').replaceWith(`<span id="endo">${endomage}</span>`);
        $('#lresp').replaceWith(`<span id="lresp">${delais_respect}</span>`);
        $('#lnonresp').replaceWith(`<span id="lnonresp">${delais_non_respect}</span>`);
    
        //LIVRAISON PAR REGION
        $('#dev').append(`<option selected>${new Date().getFullYear()} </option>`);
        let regions = JSON.parse($('#dev').attr('data-regions'));
        let tabe = [];
        livraisons.forEach(livraison => {
            if(parseInt(new Date().getFullYear()) == parseInt(livraison.created_at.slice(0,4))){
                tabe.push(livraison);
            }
        });

        for (let index = 0; index < regions.length; index++) {
            const region = regions[index];
            let Qte = 0;
            let liv = [];
            for (let index = 0; index < tabe.length; index++) {
                const livraison = tabe[index];
                
                let site = sites.find(site => parseInt(site.id) == parseInt(livraison.users.site_id));
                if(site){
                    if(region.id == site.region_id){
                        Qte +=1;
                        liv.push(livraison);
                    }
                }
            }
            let QteEncours = 0;
            let QteLivrer = 0;
            let QteAnnuler = 0;
            for (let index = 0; index < liv.length; index++) {
                const livraison = liv[index];
                switch (livraison.state) {
                    case 'ENCOUR':
                        QteEncours +=1;
                        break;
                    case 'LIVRER':
                        QteLivrer +=1;
                        break;
                    case 'ANNULER':
                        QteAnnuler +=1;
                        break;
                    default:
                        break;
                }
            }
            $(`#encou${index}`).replaceWith(`<span id='encou${index}'>${QteEncours}</span>`);
            $(`#endom${index}`).replaceWith(`<span id='endom${index}'>${QteLivrer}</span>`);
            $(`#partiel${index}`).replaceWith(`<span id='partiel${index}'>${QteAnnuler}</span>`);
            $(`#ch${index}`).replaceWith(`<span id="ch${index}">${Qte}</span>`);
        }

        //LIVRAISON PAR AGENCE
        $('#symphos').append(`<option selected>${new Date().getFullYear()} </option>`);

        let tabs = [];
        livraisons.forEach(livraison => {
            if(parseInt(new Date().getFullYear()) == parseInt(livraison.created_at.slice(0,4))){
                tabs.push(livraison);
            }
        });

        for (let index = 0; index < sites.length; index++) {
            const site = sites[index];
            let Qte = 0;
            let liv = [];
            for (let index = 0; index < tabs.length; index++) {
                const livraison = tabs[index];
                
                if(livraison.users.site_id){
                    if(parseInt(site.id) == parseInt(livraison.users.site_id)){
                        Qte +=1;
                        liv.push(livraison);
                    }
                }
            }
            let QteEncours = 0;
            let QteLivrer = 0;
            let QteAnnuler = 0;

            let voyage = 0;
            let tour_ville = 0;
            let incident = 0;
            let avis_client = 0;

            for (let index = 0; index < liv.length; index++) {
                const livraison = liv[index];

                if(livraison.avis && livraison.avis == "Satisfait"){
                    avis_client +=1;
                }

                if(livraison.incident){
                    incident +=1;
                }

                let user = users.find(u => parseInt(u.id) == parseInt(livraison.user_id));
                let site_user = sites.find(s => parseInt(s.id) == parseInt(user.site_id));
                if(site_user){
                    if(site_user.ville == livraison.destination){
                        tour_ville +=1;
                    }else{
                        voyage +=1;
                    }
                }

                switch (livraison.state) {
                    case 'ENCOUR':
                        QteEncours +=1;
                        break;
                    case 'LIVRER':
                        QteLivrer +=1;
                        break;
                    case 'ANNULER':
                        QteAnnuler +=1;
                        break;
                    default:
                        break;
                }
            }
            $(`#staten${index}`).replaceWith(`<span id='staten${index}'>${QteEncours}</span>`);
            $(`#statentr${index}`).replaceWith(`<span id='statentr${index}'>${QteLivrer}</span>`);
            $(`#statrecept${index}`).replaceWith(`<span id='statrecept${index}'>${QteAnnuler}</span>`);
            $(`#tube${index}`).replaceWith(`<span id='tube${index}'>${Qte}</span>`);
            $(`#voyage${index}`).replaceWith(`<span id='voyage${index}'>${voyage}</span>`);
            $(`#tour_ville${index}`).replaceWith(`<span id='tour_ville${index}'>${tour_ville}</span>`);
            $(`#incident_agence${index}`).replaceWith(`<span id='incident_agence${index}'>${liv.length > 0 ? (incident/liv.length) * 100 : 0}</span>`);
            $(`#avis_client${index}`).replaceWith(`<span id='avis_client${index}'>${liv.length > 0 ? (avis_client/liv.length) * 100 : 0}</span>`); 
        }

    });

    $(document).on('change', '#totaux', function(){
        if($(this).val()){
            let livraisons = JSON.parse($(this).attr('data-livraison'));

            let sites = JSON.parse($(this).attr('data-sites'));
            let users = JSON.parse($(this).attr('data-users'));
            let tab = [];
            let encours = 0;
            let livrer = 0;
            let annuler = 0;
            let tourVille = 0;
            let ligne = 0;
            let satisfaction = 0;
            let conforme = 0;
            let partielle = 0;
            let endomage = 0;
            let delais_respect = 0;
            let delais_non_respect = 0;

            livraisons.forEach(livraison => {
                if(parseInt($(this).val()) == parseInt(livraison.created_at.slice(0,4))){
                    tab.push(livraison);
                }
            });

            let element = 0;
            for (let index = 0; index < tab.length; index++) {
                const livraison = tab[index];
                switch (livraison.state) {
                    case "ENCOUR":
                        encours +=1;
                        break;
                    case "LIVRER":
                        livrer +=1;
                        break;
                    case "ANNULER":
                        annuler +=1;
                        break;
                
                    default:
                        break;
                }

                let user = users.find(u => parseInt(u.id) == parseInt(livraison.user_id));
                let site_user = sites.find(s => parseInt(s.id) == parseInt(user.site_id));
                if(site_user){
                    if(site_user.ville == livraison.destination){
                        tourVille +=1;
                    }else{
                        ligne +=1;
                    }    
                }

                if(livraison.avis == "Satisfait"){
                    element +=1;
                }

                if(livraison.really_delivery_date){
                    let reel_datelivraison = livraison.really_delivery_date.replaceAll('-', '');
                    let datelivraison = livraison.delivery_date.replaceAll('-', '');
                    if((parseInt(reel_datelivraison) < parseInt(datelivraison)) || (parseInt(reel_datelivraison) == parseInt(datelivraison))){
                        delais_respect +=1;
                    }else{
                        delais_non_respect +=1;
                    }
                }

                switch (livraison.etat_livraison) {
                    case "CONFORME":
                        conforme +=1;
                        break;
                    case "PARTIELLE":
                        partielle +=1;
                        break;
                    case "ENDOMAGEE":
                        endomage +=1;
                        break;
                    default:
                        break;
                }
            }
            if(tab.length > 0){
                satisfaction = (parseInt(element)/tab.length) * 100;
            }

            $('#tot').replaceWith(`<span id="tot">${tab.length}</span>`)
            $('#encoursss').replaceWith(`<span id="encoursss">${encours}</span>`);
            $('#livree').replaceWith(`<span id="livree">${livrer}</span>`);
            $('#anulation').replaceWith(`<span id="anulation">${annuler}</span>`);
            $('#tville').replaceWith(`<span id="tville">${tourVille}</span>`);
            $('#lignevoyage').replaceWith(`<span id="lignevoyage">${ligne}</span>`);
            $('#satiste').replaceWith(`<span id="satiste">${satisfaction}</span>`);
            $('#confort').replaceWith(`<span id="confort">${conforme}</span>`);
            $('#part').replaceWith(`<span id="part">${partielle}</span>`);
            $('#endo').replaceWith(`<span id="endo">${endomage}</span>`);
            $('#lresp').replaceWith(`<span id="lresp">${delais_respect}</span>`);
            $('#lnonresp').replaceWith(`<span id="lnonresp">${delais_non_respect}</span>`);
        }
    });

    $(document).on('change', '#trucks', function(){
        if($(this).val()){
            if($('#car_year').val()){

                let livraisons = JSON.parse($(this).attr('data-livraison'));
                let vehicules = JSON.parse($(this).attr('data-vehicules'));
                let sites = JSON.parse($(this).attr('data-sites'));
                let users = JSON.parse($(this).attr('data-users'));
                let livraison_of_car = [];
                let tab = [];
                let tourville = 0;
                let ligne = 0;

                for (let index = 0; index < livraisons.length; index++) {
                    const livraison = livraisons[index];
                    if(parseInt($('#car_year').val()) == parseInt(livraison.created_at.slice(0,4))){
                        tab.push(livraison);
                    }
                }

                for (let index = 0; index < tab.length; index++) {
                    const livraison = tab[index];
                    
                    if(livraison.vehicule_id == $(this).val()){
                        livraison_of_car.push(livraison);
                    }
                }
                
                let m_jan = 0;
                let m_fev = 0;
                let m_mar = 0;
                let m_avr = 0;
                let m_mai = 0;
                let m_jui = 0;
                let m_juit = 0;
                let m_aou = 0;
                let m_sep = 0;
                let m_oct = 0;
                let m_nov = 0;
                let m_dec = 0;

                for (let index = 0; index < livraison_of_car.length; index++) {
                    const delivery = livraison_of_car[index];
                    
                    let user = users.find(u => parseInt(u.id) == parseInt(delivery.user_id));
                    let site_user = sites.find(s => parseInt(s.id) == parseInt(user.site_id));    
                    if(site_user){
                        if(site_user.ville == delivery.destination){
                            tourville +=1;
                        }else{
                            ligne +=1;
                        }
                        switch (parseInt(delivery.created_at.slice(5,7))) {
                            case 1:
                                m_jan += parseInt(delivery.delivery_amount);
                                break;
                            case 2:
                                m_fev += parseInt(delivery.delivery_amount);
                                break;
                            case 3:
                                m_mar += parseInt(delivery.delivery_amount);
                                break;
                            case 4:
                                m_avr += parseInt(delivery.delivery_amount);
                                break;
                            case 5:
                                m_mai += parseInt(delivery.delivery_amount);
                                break;
                            case 6:
                                m_jui += parseInt(delivery.delivery_amount);
                                break;
                            case 7:
                                m_juit += parseInt(delivery.delivery_amount);
                                break;
                            case 8:
                                m_aou += parseInt(delivery.delivery_amount);
                                break;
                            case 9:
                                m_sep += parseInt(delivery.delivery_amount);
                                break;
                            case 10:
                                m_oct += parseInt(delivery.delivery_amount);
                                break;
                            case 11:
                                m_nov += parseInt(delivery.delivery_amount);
                                break;
                            case 12:
                                m_dec += parseInt(delivery.delivery_amount);
                                break;
                            default:
                                break;
                        }     
                    }
                }

                let car = vehicules.find(v => parseInt(v.id) == parseInt($(this).val()));
                $(`#hydra`).replaceWith(`<span id='hydra'>${tourville}</span>`);
                $(`#trave`).replaceWith(`<span id='trave'>${ligne}</span>`);
                $('#infos_car').replaceWith(`<span class="text-dark" id="infos_car">${car.ModelVehicule +' '+ car.Immatriculation}</span>`);
                
                $(`#jan`).replaceWith(`<span style="padding:6px;" id='jan'>${m_jan}</span>`);
                $(`#fev`).replaceWith(`<span style="padding:6px;" id='fev'>${m_fev}</span>`);
                $(`#mar`).replaceWith(`<span style="padding:6px;" id='mar'>${m_mar}</span>`);
                $(`#avr`).replaceWith(`<span style="padding:6px;" id='avr'>${m_avr}</span>`);
                $(`#mai`).replaceWith(`<span style="padding:6px;" id='mai'>${m_mai}</span>`);
                $(`#jui`).replaceWith(`<span style="padding:6px;" id='jui'>${m_jui}</span>`);
                $(`#juit`).replaceWith(`<span style="padding:6px;" id='juit'>${m_juit}</span>`);
                $(`#aou`).replaceWith(`<span style="padding:6px;" id='aou'>${m_aou}</span>`);
                $(`#sep`).replaceWith(`<span style="padding:6px;" id='sep'>${m_sep}</span>`);
                $(`#oct`).replaceWith(`<span style="padding:6px;" id='oct'>${m_oct}</span>`);
                $(`#nov`).replaceWith(`<span style="padding:6px;" id='nov'>${m_nov}</span>`);
                $(`#dec`).replaceWith(`<span style="padding:6px;" id='dec'>${m_dec}</span>`);

            }
        }
    });
