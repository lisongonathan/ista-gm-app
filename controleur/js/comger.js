$(document).ready(function(){
    //Surbrillance
    $('.choixPromotion').addClass("active")

    function getListIrregularStudent(matricule){
        var isOk = confirm("Êtes vous vraiment certain que l'étudiant ("+matricule+") est en ordre?")
        if(isOk){
            var str = window.location.href
            var str = new URL(str)
            var col = str.searchParams.get("col")

            console.log(col)
            $.post(
                "./controleur/php/API.php",
                {
                    regulier: matricule,
                    rubrique : col
                },
                function(data){
                    let dataJSON = JSON.parse(data)
                    if(dataJSON.code == 200){
                        alert("L'étudiant ayant le matricule => " + matricule +" a bien été enregistrer")
                        window.location.reload()
                    }else{
                        alert("Une erreur s'est produit lors de l'enregistrement de l'étudiant")
                        window.location.reload()
                    }
                }
            )
        }else{
            window.location.reload()
        }
    }

    $('.irregulier').change(function(){        
        getListIrregularStudent($(this).data("id"))

    })

    $('.regulier').click(function(){
        alert("Il est impossible de changer le statut d'un étudiant déjà enregistrer...")
        return false
    })

    //alert($('.find-student').val())

    $('.find-student').keyup(function(){
        console.log($(this).val())
        var keyWordIregulier = $(this).val()
        console.log(keyWordIregulier)
        var str = window.location.href
        var str = new URL(str)
        var col = str.searchParams.get("col")
        var id_section = str.searchParams.get("section")
        $.post(
            "./controleur/php/API.php",
            {
                word: keyWordIregulier,
                section: parseInt(id_section),
                rubrique: col
            },
            function(data){
                let dataJSON = JSON.parse(data)
                $('.list-items-irregulier').html("")
                let contenu = ""
                $.each(dataJSON.data, function(key, value){
                  contenu += '<tr class="unread">'+
                    '<td class="inbox-small-cells">'+
                      '<input type="checkbox" data-id="'+value.matricule+'" class="mail-checkbox irregulier">'+
                    '</td>'+
                    '<td class="view-message  nom"><a href="#">'+value.nom+'</a></td>'+
                    '<td class="view-message  post_nom"><a href="#">'+value.post_nom+'</a></td>'+
                    '<td class="view-message  prenom"><a href="#">'+value.prenom+'</a></td>'+
                    '<td class="view-message  matricule"><a href="#">'+value.matricule+'</a></td>'+
                    '<td class="view-message  text-right">'+value.solde+'</td>'+
                  '</tr>'
                  //alert($('.list-promotion').html())
                })
                $('.list-items-irregulier').append(contenu)

                $('.irregulier').change(function(){        
                    getListIrregularStudent($(this).data("id"))
            
                })
            
                $('.regulier').click(function(){
                    alert("Il est impossible de changer le statut d'un étudiant déjà enregistrer...")
                    return false
                })

            }
        )
    })


})