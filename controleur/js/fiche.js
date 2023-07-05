

$(document).ready(function(){
    //Surbrillance
    $('.itemsFiches').addClass("active")

    var disabled = true

    $('.unlock-exam').click(function(e) {
        e.preventDefault()
        $.post(
            "./controleur/php/API.php",
            {
                authorisationTit: "true"
            },
            function(data){
                let dataJSON = JSON.parse(data)

                if(dataJSON.data.statut == 'true'){
                    if (disabled) {                        
                        $('.cote-examen, .rat-e').prop('disabled', false)
                        
                    } else {                        
                        $('.cote-examen, .rat-e').prop('disabled', true)
                    }
                    disabled = !disabled
                }else{
                    alert("La transcription des cotes de l'examen n'est pas encore autorisée")
                }
            }
        )
    })

    $('.valid-cote').click(function(e){
        e.preventDefault()
        let addCotes = 0
        let currCotes = 0
        let pourcentage = parseFloat(0)
        let isOK = confirm("L'insertion des cotes est une opération irreversible souhaiter vous vraiment le faire ??")
        
        if(isOK){
            $.each($('.etudiant-id'), function(key, value){  
                //console.log($(this).data('id'))   
                let idEtudiant = $(this).data('id')
               
                let n =  parseInt(key) + 1
                //console.log(n, idEtudiant, $('.etudiant-id:nth-child('+n+') td a.description').html())
                let noms_etudiant = $('.etudiant-id:nth-child('+n+') td a.description').html()
                let tp = $('.etudiant-id:nth-child('+n+') td input.m-tp').val()
                let td = $('.etudiant-id:nth-child('+n+') td input.m-td').val()
                let examen = $('.etudiant-id:nth-child('+n+') td input.cote-examen').val()
                //console.log(noms_etudiant, tp, td, examen)

                //console.log(examen)

                let studentTP = parseFloat(tp)                

                while (studentTP < 0 || studentTP > 5) {
                    studentTP = prompt("Veuillez entrer une valeur allant de 0 à 5, pour l'étudiant "+noms_etudiant+" SVP!!!\nMoyenne TP /5", "")
                    if(studentTP === ""){
                        break
                    }                                         
                    studentTP = parseFloat(studentTP)
                }

                let studentTD = parseFloat(td)
                

                while (studentTD < 0 || studentTD > 5) {
                    studentTD = prompt("Veuillez entrer une valeur allant de 0 à 5, pour l'étudiant "+noms_etudiant+" SVP!!!\nMoyenne TD /5", "")
                    if(studentTD === ""){
                        break
                    }                                         
                    studentTD = parseFloat(studentTD)
                }
    
                let studentExam = parseFloat(examen)                

                while (studentExam < 0 || studentExam > 10) {
                    studentExam = prompt("Veuillez entrer une valeur allant de 0 à 10, pour l'étudiant "+noms_etudiant+" SVP!!!\nMoyenne Examen /10", "")
                    if(studentExam === ""){
                        break
                    }                                         
                    studentExam = parseFloat(studentExam)
                }

                const parseUrl = new URL(window.location.href)
                let matiere = parseUrl.searchParams.get('matiere')

                //console.log(studentExam, studentTP, studentTD, $('.etudiant-id').length)

                if(studentTP){
                    if(studentTD){
                       
                        addCotes = addCotes + 1
                        //console.log(addCotes) 
                    }
                }
                if(studentExam){                    
                    addCotes = addCotes + 1
                }

                if(studentTP){
                    if(studentTD){
                        
                                    
                        $.post(
                            "./controleur/php/API.php",
                            {
                                coteTD: studentTD,
                                coteTP: studentTP,
                                idEtudiantCoteTD: idEtudiant,
                                idMatiereCoteTD: matiere
                            },
                            function(reponse){                                 
                                currCotes = currCotes + 1
                                pourcentage = parseInt(currCotes*100/addCotes)                   
                                $('.chargementDonnees').html('<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: '+pourcentage+'%"></div>')                          
                                console.log('currCotes : ' + currCotes, 'Total cotes : ' + addCotes, 'Pourcentage : ' + pourcentage) 
                                if(pourcentage == 100.0){
                                    setTimeout(window.location.reload(), 4000)
                                }
                                
                            }
                        )
                    }
                }

                if(studentExam){                 
                    $.post(
                        "./controleur/php/API.php",
                        {
                            coteExamen: studentExam,
                            idEtudiantCoteExamen: idEtudiant,
                            idMatiereCoteTD: matiere
                        },
                        function(resp){    
                            currCotes = currCotes + 1
                            pourcentage = parseInt(currCotes*100/addCotes)                   
                            $('.chargementDonnees').html('<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: '+pourcentage+'%"></div>')                          
                            console.log('currCotes : ' + currCotes, 'Total cotes : ' + addCotes, 'Pourcentage : ' + pourcentage) 
                            if(pourcentage == 100.0){
                                setTimeout(window.location.reload(), 4000)
                            }
                        }
                    ) 
                }
                
            })
              
        }          
    })



    $('.retour-dash').click(function(e){
        e.preventDefault()
        window.location.replace("index.php")
    })

})