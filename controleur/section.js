$(document).ready(function(){ 
    $('.ue-ok').hide();
    $('.ue-no').hide();

    $('.annulerBtn').click(function (e) { 
        e.preventDefault();
        
        window.history.back()
        
    })

    $('.delEC').click(function (e) { 
        e.preventDefault();

        let id = parseInt($(this).data("id"))

        let isOK = confirm("Voulez vous vraiment supprimer ce cours ?")

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
        
    });

    $('.updateEC').click(function (e) { 
        e.preventDefault();

        let id = parseInt($(this).data("id"))

        window.location.href='index.php?editCours=' + id
        
    });

    $('#addUE-form').on('click', function(e){
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
                    if(dataJSON.code == 200){
                        $('#ue-designation').val('')
                        $('#ue-code').val('')
                        $('.ue-ok').fadeIn('slow', function(){window.history.back()});
                    }else{
                        $('.ue-no').fadeIn('slow');
                    }
                })
        }else{
            alert("Veuillez completer tous les champs")
        }
    })

    $('.suppUe').click(function (e) { 
        e.preventDefault();

        let id = parseInt($(this).data("id"))

        let isOK = confirm("Voulez vous vraiment supprimer cette unite ?")

        if(isOK){
            $.post(
                "./controleur/php/API.php",
                {
                    delUE: id
                },
                function(data){
                    const response = JSON.parse(data)
                    alert(response.data)
                    window.location.reload()
                }
            )
        }
        
    });


    $('.updateUe').click(function (e) { 
        e.preventDefault();

        let id = parseInt($(this).data("id"))

        const isOK = confirm('Souhaiter vous changer l\'intitule de l\'UE ?')
        if (isOK) {
            const intitule = prompt('Modifier l\'intitule ici...')
            if(intitule){
        
                if(isOK){
                    $.post(
                        "./controleur/php/API.php",
                        {
                            updateEC: id,
                            designation: intitule
                        },
                        function(data){
                            const response = JSON.parse(data)

                            alert(response.data)
                            const isOK = confirm('Souhaiter vous aussichanger le code de l\'UE ?')
                
                            if (isOK) {                
                                const code = prompt('Modifier le code ici...')
                                if (code) {
                        
                                    if(isOK){
                                        $.post(
                                            "./controleur/php/API.php",
                                            {
                                                updateEC: id,
                                                code: code
                                            },
                                            function(data){
                                                const response = JSON.parse(data)
                    
                                                alert(response.data)
                                                //window.location.reload()
                                            }
                                        )
                                    }
                                    
                                }
                            } 
                            //window.location.reload()
                        }
                    )
                }
            }

        } else {
            const isOK = confirm('Souhaiter vous changer le code de l\'UE ?')

            if (isOK) {                
                const code = prompt('Modifier le code ici...')
                if (code) {
        
                    if(isOK){
                        $.post(
                            "./controleur/php/API.php",
                            {
                                updateEC: id,
                                code: code
                            },
                            function(data){
                                const response = JSON.parse(data)    
                                alert(response.data)
                                //window.location.reload()
                            }
                        )
                    }
                    
                }
            } else {
                //window.location.reload()
            }
            
        }
        
    });

    function getAllPromotions(){
      $.post(
        "./controleur/php/API.php",
        {
          promoOfSection: "all"
        },
        function(data){
              let dataJSON = JSON.parse(data)

              let nbrePromotion = 0

              $('.list-promotion').each(function (index, element) {
                // element == this
                let contenu = $(this).html()
                $(this).html('')
                if (index == 0) {
                    $.each(dataJSON.data, function(key, value){  
                      nbrePromotion += 1            
                      if(value.orientation){
                          const orientation = value.orientation
                          contenu += '<li><a title="Tous les Enseignants" href="index.php?enseignants='+value.promo+'"><span class="mini-sub-pro">'+value.class+' '+orientation+'</span></a></li>'
                      }else{
                          const orientation = ""
                          contenu += '<li><a title="Tous les Enseignants Professors" href="index.php?enseignants='+value.promo+'"><span class="mini-sub-pro">'+value.class+' '+orientation+'</span></a></li>'
                      }
                    })
                    
                    $(this).prepend(contenu)
                    
                } else if(index == 1){

                    $.each(dataJSON.data, function(key, value){  
                        nbrePromotion += 1            
                        if(value.orientation){
                            const orientation = value.orientation
                            contenu += '<li><a title="Tous les Etudiants" href="index.php?etudiants='+value.promo+'"><span class="mini-sub-pro">'+value.class+' '+orientation+'</span></a></li>'
                        }else{
                            const orientation = ""
                            contenu += '<li><a title="Tous les Etudiants" href="index.php?etudiants='+value.promo+'"><span class="mini-sub-pro">'+value.class+' '+orientation+'</span></a></li>'
                        }
                      })
                      
                      $(this).prepend(contenu)
                } else {
                    $.each(dataJSON.data, function(key, value){  
                      nbrePromotion += 1            
                      if(value.orientation){
                          const orientation = value.orientation
                          contenu += '<li><a title="Tous les cours" href="index.php?promotion='+value.promo+'"><span class="mini-sub-pro">'+value.class+' '+orientation+'</span></a></li>'
                      }else{
                          const orientation = ""
                          contenu += '<li><a title="Tous les cours" href="index.php?promotion='+value.promo+'"><span class="mini-sub-pro">'+value.class+' '+orientation+'</span></a></li>'
                      }
                    })
                    
                    $(this).prepend(contenu)
                    
                }
              
              $('.nbrePromo').html(nbrePromotion + ' Promotions')
              nbrePromotion = 0
              });

        }
      )        
    }
    getAllPromotions()
    //setInterval(getAllPromotions,10000)
   
   function getChefSection(){        
        $.post(
            "./controleur/php/API.php",
            {
                chefSection: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('.chefSection').prepend(dataJSON.data.grade + ', ' + dataJSON.data.nom + '<br> ' + dataJSON.data.post_nom)
                console.log($('.chefSection').html(), dataJSON.data.nom)
            }
        )
    }
    getChefSection()
    //setInterval(getChefSection, 1000);

    function getEffEtudiant(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectifEtudiants: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)
                const total = parseInt(dataJSON.data)

                window.localStorage.setItem('EFT', total)

            }
        )
    }

    getEffEtudiant()

    //setInterval(getEffEtudiant, 1000);

    function getEffEnseignant(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectifEnseignant: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('.nbreTitulaires').html(dataJSON.data)

            }
        )
    }

    getEffEnseignant()

    //setInterval(getEffEnseignant, 1000);

    function getEffMISTA(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectM: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#effectifM-ista').prepend(dataJSON.data)
            }
        )
    }

    getEffMISTA()

    //setInterval(getEffMISTA, 1000);

    function getEffFISTA(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectF: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('#effectifF-ista').prepend(dataJSON.data)

            }
        )
    }

    getEffFISTA()

    //setInterval(getEffFISTA, 1000);

    const cibleEnrol = parseInt(window.localStorage.getItem('EFT'))*10
    $('.enrol').html(cibleEnrol)   

    function getEffEC(){        
        $.post(
            "./controleur/php/API.php",
            {
                effectifEC: "All"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                $('.cours-s').html(dataJSON.data)

            }
        )
    }

    getEffEC()

   //setInterval(getEffEC, 1000);

   $('.add_etudiant').click(function (e) { 
    e.preventDefault();

    let dataStudent = {
        'NOM' : $('.nom_etudiant').val(),
        'POST-NOM' : $('.post_nom_etudiant').val(),
        'PRENOM' : $('.prenom_etudiant').val(),
        'NATIONALITE' : $('.nationalite_etudiant').val(),
        'DATE DE NAISSANCE' : $('.date_etudiant').val(),
        'LIEU DE NAISSANCE' : $('.nom_etudiant').val(),
        'SEXE' : $('.sexe_etudiant').val(),
        'DIPLOME' : $('.diplome_etudiant').val(),
        'PROMOTION' : $('.promotion_etudiant').val(),
        'AJAC' : $('.ajac_etudiant').val(),
        'FRAIS ACADEMQIUE': $('.frais_acad_etudiant').val(),
        'FRAIS CONNEXE S1': parseFloat($('.frais_connexe_s1').val()),
        'FRAIS CONNEXE S2' : parseFloat($('.frais_connexe_s2').val())
    }

    if(dataStudent.dettes){
        alert("Vous signifierez plus tard les éléments constitutifs à reprendre")

    }
    
    $.each(dataStudent, function(key, value) {
        if(value){
            console.log(value)
        }else{
            console.log('Vous devrez completer ', key)
            
            let info = prompt('Veuillez Completer le ' + key, '')
            
            while(!info){
                info = prompt('Veuillez Completer le ' + key, '')
            }

            dataStudent[key] = info
            
        }
    })

    $.post(
        "./controleur/php/API.php",
        {
            new_student :dataStudent
        },
        function (data) {
            const dataJSON = JSON.parse(data)

            if(dataJSON.code == 200){
                alert(dataJSON.data)
                window.location.reload()
            }else{
                alert(dataJSON.data)
            }
        }
    );  
    
   });

  })

