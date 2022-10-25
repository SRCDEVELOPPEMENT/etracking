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

                    if(region.id == site.region_id){
                        Qte +=1;
                        liv.push(livraison);
                    }
                }
                let QteEncours = 0;
                let QteEndomagee = 0;
                let QtePartielle = 0;
                let QteConforme = 0;
                for (let index = 0; index < liv.length; index++) {
                    const livraison = liv[index];
                    switch (livraison.state) {
                        case 'ENCOUR':
                            QteEncours +=1;
                            break;
                        case 'ENDOMAGEE':
                            QteEndomagee +=1;
                            break;
                        case 'PARTIELLE':
                            QtePartielle +=1;
                            break;
                        case 'CONFORME':
                            QteConforme +=1;
                            break;
                        default:
                            break;
                    }
                }
                $(`#encou${index}`).replaceWith(`<span id='encou${index}'>${QteEncours}</span>`);
                $(`#endom${index}`).replaceWith(`<span id='endom${index}'>${QteEndomagee}</span>`);
                $(`#partiel${index}`).replaceWith(`<span id='partiel${index}'>${QtePartielle}</span>`);
                $(`#conf${index}`).replaceWith(`<span id='conf${index}'>${QteConforme}</span>`);
                $(`#ch${index}`).replaceWith(`<span id="ch${index}">${Qte}</span>`);
            }
        }
    });

    $(document).on('click', '#symphos', function(){
        if($(this).val()){
            let livraisons = JSON.parse($(this).attr('data-livraison'));
            let regions = JSON.parse($(this).attr('data-regions'));
            let sites = JSON.parse($(this).attr('data-sites'));
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
                let QteEndomagee = 0;
                let QtePartielle = 0;
                let QteConforme = 0;

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
                    if(livraison.tonnage){
                        voyage +=1;
                    }else{
                        tour_ville +=1;
                    }

                    switch (livraison.state) {
                        case 'ENCOUR':
                            QteEncours +=1;
                            break;
                        case 'ENDOMAGEE':
                            QteEndomagee +=1;
                            break;
                        case 'PARTIELLE':
                            QtePartielle +=1;
                            break;
                        case 'CONFORME':
                            QteConforme +=1;
                            break;
                        default:
                            break;
                    }
                }
                $(`#staten${index}`).replaceWith(`<span id='staten${index}'>${QteEncours}</span>`);
                $(`#statentr${index}`).replaceWith(`<span id='statentr${index}'>${QteEndomagee}</span>`);
                $(`#statrecept${index}`).replaceWith(`<span id='statrecept${index}'>${QtePartielle}</span>`);
                $(`#statlivr${index}`).replaceWith(`<span id='statlivr${index}'>${QteConforme}</span>`);
                $(`#tube${index}`).replaceWith(`<span id='tube${index}'>${Qte}</span>`);
                $(`#voyage${index}`).replaceWith(`<span id='voyage${index}'>${voyage}</span>`);
                $(`#tour_ville${index}`).replaceWith(`<span id='tour_ville${index}'>${tour_ville}</span>`);
                $(`#incident_agence${index}`).replaceWith(`<span id='incident_agence${index}'>${liv.length > 0 ? (incident/liv.length) * 100 : 0}</span>`);
                $(`#avis_client${index}`).replaceWith(`<span id='avis_client${index}'>${liv.length > 0 ? (avis_client/liv.length) * 100 : 0}</span>`); 
            }
        }
    });

    $(document).on('change', '#car_livr', function(){
        if($(this).val()){
            let livraisons = JSON.parse($(this).attr('data-livraison'));
            let vehicules = JSON.parse($(this).attr('data-vehicules'));
            let tab = [];

            livraisons.forEach(livraison => {
                if(parseInt($(this).val()) == parseInt(livraison.created_at.slice(0,4))){
                    tab.push(livraison);
                }
            });

            for (let index = 0; index < vehicules.length; index++) {
                const vehicule = vehicules[index];
                
                let nbr_voyage = 0;
                let tour_dans_ville = 0;
                for (let index = 0; index < tab.length; index++) {
                    const livraison = tab[index];
                    if(livraison.tonnage){
                        if(parseInt(livraison.vehicule_id) == parseInt(vehicule.id)){
                            nbr_voyage +=1;
                        }
                    }else if(livraison.distance){
                        if(parseInt(livraison.vehicule_id) == parseInt(vehicule.id)){
                            tour_dans_ville +=1;
                        }
                    }
                }
                $(`#tour_dans_ville${index}`).replaceWith(`<span id='tour_dans_ville${index}'>${tour_dans_ville}</span>`);
                $(`#toto${index}`).replaceWith(`<span id='toto${index}'>${nbr_voyage}</span>`);
            }
        }
    });