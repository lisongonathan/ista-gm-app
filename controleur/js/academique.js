$(document).ready(function(){
    //SECURITE INFORMATION
    $('.etat-autorisation').html(' ')
    $('button').click(function(e){
        e.preventDefault()
    })
    //VALIDATION
    $('.validation').click(function(){
        let action = $('.action').val()
        if (action == "true") {
            let isOK = confirm("Voulez vous vraiment bloquer " + $('.departement').val())
            if(isOK){
                $.post(
                    "./controleur/php/API.php",
                    {
                        action: action,
                        qui: $('.departement').val()
                    },
                    function(data){
                        let dataJSON = JSON.parse(data)
    
                        if(dataJSON.code == 200){
                            alert(dataJSON.data)
                        }else{
                            alert("Un problème est survenu")
                        }
                    }
                )
            }
        } else {
            let mdp = $('.mdp-authorisation').val()
            let isOK = confirm("Voulez vous vraiment debloquer " + $('.departement').val())
            if(isOK){
                if (mdp) {
                    $.post(
                        "./controleur/php/API.php",
                        {
                            action: action,
                            who: $('.departement').val(),
                            mdp: mdp
                        },
                        function(data){
                            let dataJSON = JSON.parse(data)
        
                            if(dataJSON.code == 200){
                                alert(dataJSON.data)
                            }else{
                                alert("Un problème est survenu")
                            }
                        }
                    )
                    
                } else {
                    let mdp = prompt("Veuillez définir un mot de passe", "")
                    $.post(
                        "./controleur/php/API.php",
                        {
                            action: action,
                            who: $('.departement').val(),
                            mdp: mdp
                        },
                        function(data){
                            let dataJSON = JSON.parse(data)
        
                            if(dataJSON.code == 200){
                                alert(dataJSON.data)
                            }else{
                                alert("Un problème est survenu")
                            }
                        }
                    )
                }
            }
            
        }
    })

    //VERIFICATION
    $('.statut-tit').click(function(){
        $.post(
            "./controleur/php/API.php",
            {
                autorisation_tit: "true"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                
                if(dataJSON.code == 200){
                    if(dataJSON.data.statut == "true"){
                        let statut = "OUI"
                        let contenu = 'Insertion cote examen : '+statut+'<br/>'+
                        '<a class="" href="#">'+
                          'Mot de passe :'+dataJSON.data.access+
                          '</a>' 
                        $('.etat-autorisation').html(contenu)
                    }else{
                        let statut = "NON"
                        let contenu = 'Insertion cote examen : '+statut+'<br/>'
                        $('.etat-autorisation').html(contenu)
                    }
                }
                
            }
        )
        return false
    })
    
    $('.statut-jury').click(function(){
        $.post(
            "./controleur/php/API.php",
            {
                autorisation_jury: "true"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                
                if(dataJSON.code == 200){
                    if(dataJSON.data.statut == "true"){
                        let statut = "OUI"
                        let contenu = 'Modification cote examen : '+statut+'<br/>'+
                        '<a class="" href="#">'+
                          'Mot de passe :'+dataJSON.data.access+
                          '</a>' 
                        $('.etat-autorisation').html(contenu)
                    }else{
                        let statut = "NON"
                        let contenu = 'Modification cote examen : '+statut+'<br/>'
                        $('.etat-autorisation').html(contenu)
                    }
                }
            }
        )
    })
})