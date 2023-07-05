$(document).ready(function(){
    //Surbrillance
    $('.choixPromotion a').toggleClass("active")
    $('.ue-item').hide()
    $('.addUnite-Ens').hide()
    $('.form-add-ec').hide()
    //Liste UE

    $('.addUnite-Ens').click(function(){
        $('.addUnite-Ens').hide()   
        $('.ue-item').hide()     
        $('#addUE-form').show()
    })

    function getUEs(){             
        $.post(
            "./controleur/php/API.php",
            {
                section: "current",
                promotion: "current"
            },
            function(response){
                let dataJSON = JSON.parse(response)

                let dataResp = dataJSON.data
                $('.list-ues').html('')
                $.each(dataResp, function(key, value){
                    let contenu ='<li class="active ue-detail-item" data-id='+value.id+'><a href="#"> <i class="fa fa-file-text-o"></i>'+ value.designation +'<span class="label label-danger pull-right inbox-notification">Supprimer</span></a></a>'+
                    '</li>'
                    $('.list-ues').append(contenu)
                    
                })
                
                $('.ue-detail-item a').click(function(){
                    $('.ue-detail-item').removeClass('active')
                    $(this).parent().addClass('active')

                    $('#addUE-form').hide()
                    $('.ue-item').show()
                    $('.addUnite-Ens').show()

                    let valeur_UE = $(this).parent().data("id")

                    $.post(
                        "./controleur/php/API.php",
                        {
                            UE: valeur_UE
                        },
                        function(dataAPI){
                            let data_JSON = JSON.parse(dataAPI)
            
                            let dataResponse = data_JSON.data

                            console.log(dataResponse)

                            $('.nom-ue').html(dataResponse.designation)
                            $('.code-ue').html(dataResponse.code)
                            $('.credits-ue').html(dataResponse.credits)
                            $('.ec-ue').html(dataResponse.ecs)
                        }
                    )                   

                })

                $('.ue-detail-item a span').click(function(){
                    let valeur_UE = $(this).parent().parent().data("id")

                    $.post(
                        "./controleur/php/API.php",
                        {
                            delUE: valeur_UE
                        },
                        function(msgAPI){
                            let message = JSON.parse(msgAPI)
                            alert(message.data)
                            getUEs()
                            $('.ue-item').hide()
                            $('#addUE-form').show()
                            $('.addUnite-Ens').hide()
                        }
                    )
                    return false;
                })
            }
        )
    }

    getUEs()
    setInterval(getUEs, 1000)

    $('#addUE-form').on('submit', function(e){
        e.preventDefault()
        let designation = $('#ue-designation').val()
        let code = $('#ue-code').val()
        if(designation.length && code.length){
            $.post(
                "./controleur/php/API.php",
                {
                    uE_designation: designation,
                    uE_code: code
                },
                function(response){
                    let dataJSON = JSON.parse(response)
                    alert(dataJSON.data)
                    getUEs()
                })
        }else{
            alert("Veuillez completer tous les champs")
        }
    })
    //Détail Enseignants
    $('.control-enseignant').hide()

    $('.bouton-ajout-enseignant').click(function(){
        $('.control-enseignant').show()
        $(this).hide()
        return false;
    })
    //
    function getEnseignants(){           
        $.post(
            "./controleur/php/API.php",
            {
                listEnseignants: "current"
            },
            function(response){
                let dataJSON = JSON.parse(response)

                let data = dataJSON.data
                $('.list-enseignant').html("")
                let contenu = ""
                $.each(data, function(key, value){
                    if(value.titulaire){
                        contenu = contenu + '<tr>'+
                                '<td>'+
                                    '<a href="basic_table.html#">'+value.matricule+'</a>'+
                                '</td>'+
                                '<td class="hidden-phone">'+value.prenom+'</td>'+
                                '<td class="hidden-phone">'+value.nom+'</td>'+
                                '<td class="hidden-phone">'+value.post_nom+'</td>'+
                                '<td class="hidden-phone">'+value.grade+'</td>'+
                                '<td><span class="label label-info label-mini">'+value.statut+'</span></td>'+
                                '<td>'+
                                    '<button class="btn btn-danger btn-xs suppEnseignant" data-id='+value.id+'><i class="fa fa-trash-o "></i></button>'+
                                '</td>'+
                            '</tr>'
                    }else{
                        contenu = "Aucune Information recupérer"
                    }
                    
                })

                $('.list-enseignant').append(contenu)
                
                $('.suppEnseignant').click(function(){
                    let value_Enseignant = $(this).data("id")
                    $.post(
                        "./controleur/php/API.php",
                        {
                            delEnseignant: value_Enseignant
                        },
                        function(msgAPI){
                            let message = JSON.parse(msgAPI)
                            alert(message.data)
                        }
                    )
                    return false;
                })
            }
        )

    }

    getEnseignants()
    setInterval(getEnseignants, 1000)

    $('.control-enseignant').on('submit', function(e){
        e.preventDefault()
        
        let id_titulaire = $(".id_titulaire").val()
        let id_unite = $(".id_unite").val()
        if(id_titulaire && id_unite){
            console.log("OK")
            $.post(
                "./controleur/php/API.php",
                {
                    addEC: true,
                    id: id_unite,
                    id_titulaire: id_titulaire
                },
                function(response){
                    let dataJSON = JSON.parse(response)
                    $('#intituleEC').val('')
		    $('#codeEC').val('')
		    $('#creditEC').val('')
		    $(".id_titulaire").val('')
		    $(".id_unite").val('')
                    getEnseignants()
                })
        }else{
            alert("Veuillez completer tous les champs")
        }
    })

    $('.addEC').click(function(){        
        $('.form-add-ec').show()
        $(this).hide()
    })

    $('.delete-matiere').click(function(e){
        e.preventDefault()

        let id = parseInt($(this).data("id"))

        let isOK = confirm("Voulez vous vraiment supprimer le cours "+ id)

        if(isOK){
            $.post(
                "./controleur/php/API.php",
                {
                    deleteMatiere: id
                },
                function(data){
                    window.location.reload()
                }
            )
        }
    })
})