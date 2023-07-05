$(document).ready(function(){
    //Surbrillance
    $('.items_grille').addClass("active")
    $('.items_grille').html('Déliberation')
    

      /* Add event listener for opening and closing details
       * Note that the indicator for showing which row is open is not controlled by DataTables,
       * rather it is done here
       */
    $('.grillePromo').click(function(e){
        e.preventDefault()
        history.back()
    })
    var disabled = true

    $('.modCote').click(function(e) {
        e.preventDefault()
        $.post(
            "./controleur/php/API.php",
            {
                authorisation: "true"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                if(dataJSON.data.statut == 'true'){
                    if (disabled) {                        
                        $('input').prop('disabled', false)
                        
                    } else {                        
                        $('input').prop('disabled', true)
                    }
                    disabled = !disabled
                }else{
                    alert("Le service académique n'a pas encore authorisé la déliberation")
                }
            }
        )
    })

    let dataCotes = []
    const parseUrl = new URL(window.location.href)
    let etudiant = parseUrl.searchParams.get('deliberation')
    
    $('.btn-deliberation').click(function(e){
        e.preventDefault()
        $.post(
            "./controleur/php/API.php",
            {
                autorisation_jury: "true"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                if(dataJSON.data.statut == 'true'){
                    let codeAcess = prompt("Veuillez entrer le code de la délibération", "")
                    if (codeAcess == dataJSON.data.access) {

                        $('.cours').each(function(index, value){
                            let cours = $(this).data("id")         
                            let examen = parseFloat($(this).children(".examen").find('input').val())
                            let matiere = $(this).children(".intitule").html()
    
                            let studentExam = examen                
                            console.log(studentExam)
                            while (studentExam < 0 || studentExam > 10) {
                                studentExam = prompt("Veuillez entrer une valeur allant de 0 à 10, SVP!!!\nMoyenne Examen /10", "")
                                if(studentExam === ""){
                                    break
                                }                                         
                                studentExam = parseFloat(studentExam)
                            }

                            if (examen == "-") {
                                examen = ""
                            }
                
                            dataCotes.push({
                                    "cours" : cours,
                                    "examen" : studentExam,
                                    "etudiant" : parseInt(etudiant),
                                    "matiere" : matiere
                            })
                            
                        })
                        
                        alert("NB. Les matières n'ayant pas la cote de l'examen ne peuvent être prisent en compte")

                        $.each(dataCotes, function(key, item){
                            console.log(item.examen)
                            $.post(
                                "./controleur/php/API.php",
                                {
                                    idEtudiant: item.etudiant,
                                    idMatiere: item.cours
                                },
                                function(resp){
                                    let respJSON = JSON.parse(resp)

                                    if(respJSON.data.examen != null){
                                        $.post(
                                            "./controleur/php/API.php",
                                            {
                                                idEtudiantCoteExamen: item.etudiant,
                                                idMatiereCoteTD: item.cours,
                                                coteExamen: item.examen
                                            },
                                            function(reponse){
                                                let repJSON = JSON.parse(reponse)
                                                console.log(dataCotes.length, repJSON)
                                                setTimeout(window.location.reload(), 5000)
                                                
                                            }
                                        )
                                    }
                                }
                            )
                        })                        
                    } else {
                        alert("Le mot de passe n'est pas correcte")
                        location.reload()                   
                    }                 

                }else{
                    alert("Vous n'êtes pas authorisé à faire la déliberation...")
                    location.reload()
                }
            }
        )        
    })
    
})