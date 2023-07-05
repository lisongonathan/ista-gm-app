$(document).ready(function(){
    //Surbrillance
    $('.dashboard').addClass("active")
    //SECTION
    function getEffEtudiant(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectifEtudiants: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#etudiants-section').html(dataJSON.data)

            }
        )
    }

    getEffEtudiant()

    setInterval(getEffEtudiant, 1000);

    function getEffEnseignant(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectifEnseignant: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#enseignants-section').html(dataJSON.data)

            }
        )
    }

    getEffEnseignant()

    setInterval(getEffEnseignant, 1000);

    function getEffEC(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectifEC: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#ec-section').html(dataJSON.data)

            }
        )
    }

    getEffEC()

   setInterval(getEffEC, 1000);

   
   function getChefSection(){        
        $.post(
            "./controleur/php/API.php",
            {
                chefSection: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#chef-section').html(dataJSON.data.grade + ', ' + dataJSON.data.nom + ' ' + dataJSON.data.post_nom + ' ' + dataJSON.data.prenom)

            }
        )
    }

    getChefSection()

    setInterval(getChefSection, 1000);

   function getPromoSection(){        
        $.post(
            "./controleur/php/API.php",
            {
                promoSection: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#promotions-section').html("<i class='fa fa-home'></i>  Nombre de promotions : " + dataJSON.data)

            }
        )
    }

    getPromoSection()

    setInterval(getPromoSection, 1000);


   function getEffMISTA(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectM: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#effectifM-ista').html("<i class='fa fa-male'></i> Masculin " + dataJSON.data)
            }
        )
    }

    getEffMISTA()

    setInterval(getEffMISTA, 1000);

   function getEffFISTA(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectF: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#effectifF-ista').html("<i class='fa fa-female'></i> Féminin " + dataJSON.data)

            }
        )
    }

    getEffFISTA()

    setInterval(getEffFISTA, 1000);

    function statSection(){             
        $.post(
            "./controleur/php/API.php",
            {
                statSection: "All"
            },
            function(response){
                let dataJSON = JSON.parse(response)

                let coords = dataJSON.data
                $('.contenu-bd').html('')
                $.each(coords, function(key, value){
                    page = parseInt(value.promo)
                    var contenu = '<div class="col-md-4 col-sm-4 mb" onclick="location.assign(\'index.php?promotion='+page+'\');">'+
                    '<div class="darkblue-panel pn">' +
                        '<div class="darkblue-header">' +
                            '<h5>'+value.nom_promo+'</h5>'+
                        '</div>'+
                        '<h1 class="mt"><i class="fa fa-user fa-3x"></i></h1>'+
                        '<p> Nombre d\'étudiants : '+value.effectif+'</p>'+
                        '<footer>'+
                            '<div class="centered">'+
                                '<h5><i class="fa fa-trophy"></i> Nombre de credit(s) : '+value.credits +' </h5>'+
                            '</div>'+
                        '</footer>'+
                    '</div>'+
                '</div>'
                    
                    $('.contenu-bd').append(contenu)
                    //alert(value.nom_promo + " " + value.eff_promo + " " + value.credits)
                })
            }
        )
    }

    statSection()

    setInterval(statSection, 1000);

    $('.promo-detail').each(function(){
        alert($(this).html())
    })
    //COMGER


    //TITULAIRE

    function getMyStudentsT(){        
        $.post(
            "./controleur/php/API.php",
            {
                myStudents: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data.total)
                $('#students-titulaire').html(dataJSON.data.total)

            }
        )
    }

    getMyStudentsT()
    setInterval(getMyStudentsT, 1000)   

    function getMyCreditsT(){        
        $.post(
            "./controleur/php/API.php",
            {
                myCredits: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data.total)
                $('#credits-titulaire').html(dataJSON.data.total)

            }
        )
    }

    getMyCreditsT()
    setInterval(getMyCreditsT, 1000)
    
    function getMyPromosT(){        
        $.post(
            "./controleur/php/API.php",
            {
                myPromos: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data.total)
                $('#promotions-titulaire').html(dataJSON.data.total)

            }
        )
    }

    getMyPromosT()
    setInterval(getMyPromosT, 1000)


    function statTitulaire(){             
        $.post(
            "./controleur/php/API.php",
            {
                statTitulaire: "All"
            },
            function(response){
                let dataJSON = JSON.parse(response)

                let coords = dataJSON.data
                $('.contenu-bd-tit').html('')
                $.each(coords, function(key, value){
                    page = parseInt(value.promo)
                    var contenu ='<div class="col-md-4 col-sm-4 mb" onclick="location.assign(\'index.php?fiche='+page+'&matiere='+value.ref+'\');">'+
                    '<div class="darkblue-panel pn">' +
                        '<div class="darkblue-header">' +
                            '<h5>'+value.nom_promo+' | ' +value.class+'</h5>'+
                        '</div>'+
                        '<h1 class="mt"><i class="fa fa-user fa-3x"></i></h1>'+
                        '<p> Unite d\'enseignement : '+value.effectif+'</p>'+
                        '<footer>'+
                            '<div class="centered">'+
                                '<h5><i class="fa fa-trophy"></i> Nombre de credit(s) : '+value.credits +' </h5>'+
                            '</div>'+
                        '</footer>'+
                    '</div>'+
                '</div>'
                    
                    $('.contenu-bd-tit').append(contenu)
                    //alert(value.nom_promo + " " + value.eff_promo + " " + value.credits)
                })
            }
        )
    }

    statTitulaire()

    setInterval(statTitulaire, 1000);

    //ETUDIANT

    //JURY
    //Effectif Jury
    
    function getEffJury(){        
        $.post(
            "./controleur/php/API.php",
            {
                juryEtudiants: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data)
                $('#jury-etudiants').html(dataJSON.data.total)

            }
        )
    }

    getEffJury()
    setInterval(getEffJury, 1000);    
        
    function getECsJury(){        
        $.post(
            "./controleur/php/API.php",
            {
                juryECs: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data)
                $('#jury-ecs').html(dataJSON.data.total)

            }
        )
    }

    getECsJury()
    setInterval(getECsJury, 1000);
        
    function getPromoJury(){        
        $.post(
            "./controleur/php/API.php",
            {
                juryPromotions: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data)
                $('#jury-promotions').html(dataJSON.data.total)

            }
        )
    }

    getPromoJury()
    setInterval(getPromoJury, 1000);    
        
    function getPresJury(){        
        $.post(
            "./controleur/php/API.php",
            {
                juryPres: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data)
                $('#jury-president').html("Président du jury <br /> <strong>" + dataJSON.data.grade + " " + dataJSON.data.nom + " " + dataJSON.data.post_nom + " " + dataJSON.data.prenom + " (" + dataJSON.data.matricule + ")</strong>")

            }
        )
    }

    getPresJury()
    setInterval(getPresJury, 1000);
    

    function statJury(){             
        $.post(
            "./controleur/php/API.php",
            {
                statJury: "All"
            },
            function(response){
                let dataJSON = JSON.parse(response)

                let coords = dataJSON.data
                $('.contenu-bd-jury').html('')
                $.each(coords, function(key, value){
                    page = parseInt(value.promo)
                    var contenu = '<div class="col-md-4 col-sm-4 mb" onclick="location.assign(\'index.php?grille='+page+'\');">'+
                    '<div class="darkblue-panel pn">' +
                        '<div class="darkblue-header">' +
                            '<h5>'+value.nom_promo+'</h5>'+
                        '</div>'+
                        '<h1 class="mt"><i class="fa fa-user fa-3x"></i></h1>'+
                        '<p> Nombre d\'étudiants : '+value.effectif+'</p>'+
                        '<footer>'+
                            '<div class="centered">'+
                                '<h5><i class="fa fa-trophy"></i> Nombre de credit(s) : '+value.credits +' </h5>'+
                            '</div>'+
                        '</footer>'+
                    '</div>'+
                '</div>'
                    
                    $('.contenu-bd-jury').append(contenu)
                    //alert(value.nom_promo + " " + value.eff_promo + " " + value.credits)
                })
            }
        )
    }

    statJury()
    setInterval(statJury, 1000);
            
    function getBanniereComger(){        
        $.post(
            "./controleur/php/API.php",
            {
                enrol1: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data)
                $('#solde_enrol1').html(dataJSON.data + " CDF")

            }
        )  
        $.post(
            "./controleur/php/API.php",
            {
                enrol2: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data)
                $('#solde_enrol2').html(dataJSON.data + " CDF")

            }
        )
        $.post(
            "./controleur/php/API.php",
            {
                acadFrais: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                //console.log(dataJSON.data)
                $('#solde_frais').html(dataJSON.data + " CDF")

            }
        )
    }

    getBanniereComger()
    setInterval(getBanniereComger, 1000);

    
    $.post(
        "./controleur/php/API.php",
        { 
            statEtudiant: "All"
        },
        function(response){
            let respJSON = JSON.parse(response)

            let resp = respJSON.data
            $.each(resp, function(k, v){
                var contenu ='<div class="col-md-4 col-sm-4 mb">'+
                '<div class="darkblue-panel pn">' +
                    '<div class="darkblue-header">' +
                        '<h5>'+v.intitule+' | credit = '+ v.credit +'</h5>'+
                    '</div>'+
                    '<h1 class="mt"><i class="fa fa-user fa-3x"></i></h1>'+
                    '<p>'+v.nom+' '+v.post_nom+' (' +v.grade+ ')</p>'+
                    '<footer>'+
                        '<div class="centered">'+
                            '<h5><i class="fa fa-trophy"></i> TP : '+ v.tp +' <i class="fa fa-trophy"></i> TD : '+ v.td +' </h5>'+
                        '</div>'+
                    '</footer>'+
                '</div>'+
            '</div>'
                
                $('.moyAnnuel-etudiant').append(contenu)
                //alert(value.nom_promo + " " + value.eff_promo + " " + value.credits)
            })
        }
    )

    $('.desc').click(function(){        
        $('.moyAnnuel-etudiant').html("")        
        //$('#solde_enrol2').html(dataJSON.data + " CDF")
        let id = $(this).data("id")
        $.post(
            "./controleur/php/API.php",
            { 
                id_uniteCotes: id
            },
            function(response){
                let respJSON = JSON.parse(response)

                let resp = respJSON.data
                $.each(resp, function(k, v){
                    var contenu ='<div class="col-md-4 col-sm-4 mb">'+
                    '<div class="darkblue-panel pn">' +
                        '<div class="darkblue-header">' +
                            '<h5>'+v.intitule+' | credit = '+ v.credit +'</h5>'+
                        '</div>'+
                        '<h1 class="mt"><i class="fa fa-user fa-3x"></i></h1>'+
                        '<p>'+v.nom+' '+v.post_nom+' (' +v.grade+ ')</p>'+
                        '<footer>'+
                            '<div class="centered">'+
                                '<h5><i class="fa fa-trophy"></i> TP : '+ v.tp +' <i class="fa fa-trophy"></i> TD : '+ v.td +' </h5>'+
                            '</div>'+
                        '</footer>'+
                    '</div>'+
                '</div>'
                    
                    $('.moyAnnuel-etudiant').append(contenu)
                    //alert(value.nom_promo + " " + value.eff_promo + " " + value.credits)
                })
            }
        )
    })

    function statutEtudiant(){            
        $.post(
            "./controleur/php/API.php",
            { 
                statutEtudiant: "All"
            },
            function(response){
                let respJSON = JSON.parse(response)
                //console.log(respJSON)
                if(respJSON.data.frais_academique==500000 && respJSON.data.enrol_1==25000 && respJSON.data.enrol_2==25000){
                    $("#statut-etudiant").html('<button class="btn btn-theme"><i class="fa fa-home"></i> Régulier</button>')
                }else{
                    $("#statut-etudiant").html('<button class="btn btn-danger"><i class="fa fa-home"></i> Irrégulier</button>')
                }
                
            }
        )
    }

    statutEtudiant()

    setInterval(statutEtudiant, 1000)


})