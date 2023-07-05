<?php
session_start();

/* -- LIEN MODELE - CONTRÔLEUR -- */
require "../../modele/modele.php";

/* API */
if (isset($_POST['effectifEtudiants'])) {
    # code...
    if (isset($_SESSION['id_section'])) {
        $id = (int) $_SESSION['id_section'];
    } else {
        $id = (int) $_SESSION['id'];
    }
    if($data = getEffectifSection($id)){

        $response = array(
            "code" => 200,
            "data" => $data['effectif']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}


if (isset($_POST['effectifEnseignant'])) {
    # code...
    if($data = getEnseignantSection($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data['titulaire']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['effectifEC'])) {
    # code...
    if($data = getECSection($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data['effectif']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['chefSection'])) {
    # code...
    if($data = getChefSection($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => array(
                "grade" => $data['grade'],
                "nom" => $data['nom'],
                "post_nom" => $data['post_nom'],
                "prenom" => $data['prenom']
            )
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['promoSection'])) {
    # code...
    if($data = getPromoSection($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data['total']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}


if (isset($_POST['effectM'])) {
    # code...
    if (isset($_SESSION['id_section'])) {
        $id = (int) $_SESSION['id_section'];
    } else {
        $id = (int) $_SESSION['id'];
    }
    
    if($data = getEffectifM($id)){

        $response = array(
            "code" => 200,
            "data" => $data['total']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}


if (isset($_POST['effectF'])) {
    # code...
    if (isset($_SESSION['id_section'])) {
        $id = (int) $_SESSION['id_section'];
    } else {
        $id = (int) $_SESSION['id'];
    }

    if($data = getEffectifF($id)){

        $response = array(
            "code" => 200,
            "data" => $data['total']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['statSection'])) {
    # code...
    if($data = getStatSection($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}


if (isset($_POST['promotions'])) {
    # code...
    if($data = getPromotionsList($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['section']) AND isset($_POST['promotion'])) {
    if($data = getUEs($_SESSION['id'], $_SESSION['promotion'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code...
}

if (isset($_POST['uE_designation']) AND isset($_POST['uE_code'])) {
    if($data = addUE($_SESSION['promotion'], $_POST['uE_designation'], $_POST['uE_code'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if (isset($_POST['new_student'])) {
    foreach ($_POST['new_student'] as $key => $value) {
        switch ($key) {
            case 'NOM':
                $data['nom'] = $value;
                break;

            case 'POST-NOM':
                $data['post_nom'] = $value;
                break;

            case 'PRENOM':
                $data['prenom'] = $value;
                break;

            case 'NATIONALITE':
                $data['nationalite'] = $value;
                break;

            case 'DATE DE NAISSANCE':
                $data['date_naiss'] = $value;
                break;                

            case 'SEXE':
                $data['sexe'] = $value;
                break;            

            case 'DIPLOME':
                $data['diplome'] = $value;
                break;         

            case 'PROMOTION':
                $data['id_promotion'] = $value;
                break;             

            case 'FRAIS ACADEMIQUE':
                $data['acad_frais'] = $value;
                break;                     

            case 'FRAIS CONNEXE S1':
                $data['connexe_frais'] = $value;
                break;                     

            case 'FRAIS CONNEXE S2':
                $data['connexe_frais_s2'] = $value;
                break;
    
            default:
                $data['dettes'];
                break;
        }
        $data['code_access'] = time()%2023 . '/' . date('Y');
    }

    if(addStud($data)){
        $response = array(
            "code" => 200,
            "data" => "L'étudiant a bien été ajouté"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Un problème est survenu lors de l'inscription"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if(isset($_POST['UE'])){
    if($data = getDetailUE($_POST['UE'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if(isset($_POST['delUE'])){
    if($data = deleteUE($_POST['delUE'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if(isset($_POST['updateEC'])){
    if (isset($_POST['designation'])) {
    
        if($data = updateUEbyDesignation($_POST['updateEC'], $_POST['designation'])){
            $response = array(
                "code" => 200,
                "data" => $data
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }else {
            $response = array(
                "code" => 400,
                "data" => "Aucune infomation"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }
    } else {
    
        if($data = updateUEbyCode($_POST['updateEC'], $_POST['code'])){
            $response = array(
                "code" => 200,
                "data" => $data
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }else {
            $response = array(
                "code" => 400,
                "data" => "Aucune infomation"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }
    }
    # code..
}

if (isset($_POST['listEnseignants'])) {
    if($data = getEnseignant($_SESSION['promotion'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code.
}



if(isset($_POST['delEnseignant'])){
    if($data = deleteEnseignant($_POST['delEnseignant'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if(isset($_POST['addEC'])){
    $data = array(
        'id'=>$_POST['id'],
        'titulaire'=>$_POST['id_titulaire']
    );
    if($data = updateECS($data)){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if(isset($_POST['myStudents'])){
    if($data = getStudentsTitulaire($_SESSION['id'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if(isset($_POST['myCredits'])){
    if($data = getCreditsTitulaire($_SESSION['id'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}

if(isset($_POST['myPromos'])){
    if($data = getPromosTitulaire($_SESSION['id'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    # code..
}


if (isset($_POST['statTitulaire'])) {
    # code...
    if($data = getStatTitulaire($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['juryEtudiants'])) {
    # code...
    if($data = getEffectifJury($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['juryECs'])) {
    # code...
    if($data = getECsJury($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['juryPromotions'])) {
    # code...
    if($data = getPromosJury($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['juryPres'])) {
    # code...
    if($data = getPresJury($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['statJury'])) {
    # code...
    if($data = getStatJury($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['grille'])) {
    # code...
    if($data = getGrilleList($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['enrol1'])) {
    # code...
    if($data = getEnrol1()){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['enrol2'])) {
    # code...
    if($data = getEnrol2()){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['acadFrais'])) {
    # code...
    if($data = getFraisAcad()){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['promoOfSection'])) {
    # code...
    if($data = getPromotionsList($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['statEtudiant'])) {
    # code...
    if($data = getECsStudent($_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['id_uniteCotes'])) {
    # code...
    if($data = getECsStudentById((int) $_POST['id_uniteCotes'], (int) $_SESSION['id'])){

        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['updateUser'])) {
    # code...
    switch ($_SESSION['module']) {
        case 'Etudiant':
            if(updateStudent($_POST['updateUser'], $_SESSION['id'])){
                $_SESSION['nom'] = (!empty($_POST['updateUser']['nom'])) ? $_POST['updateUser']['nom'] : $_SESSION['nom'];
                $_SESSION['post_nom'] = (!empty($_POST['updateUser']['post_nom'])) ? $_POST['updateUser']['post_nom'] : $_SESSION['post_nom'];
                $_SESSION['prenom'] = (!empty($_POST['updateUser']['prenom'])) ? $_POST['updateUser']['prenom'] : $_SESSION['prenom'];
                $_SESSION['sexe'] = (!empty($_POST['updateUser']['sexe'])) ? $_POST['updateUser']['sexe'] : $_SESSION['sexe'];
                
                $response = array(
                    "code" => 200
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }else {
                $response = array(
                    "code" => 400
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }
            break;
        
        default:
            if(updateTeacher($_POST['updateUser'], $_SESSION['id'])){
                $_SESSION['nom'] = (!empty($_POST['updateUser']['nom'])) ? $_POST['updateUser']['nom'] : $_SESSION['nom'];
                $_SESSION['post_nom'] = (!empty($_POST['updateUser']['post_nom'])) ? $_POST['updateUser']['post_nom'] : $_SESSION['post_nom'];
                $_SESSION['prenom'] = (!empty($_POST['updateUser']['prenom'])) ? $_POST['updateUser']['prenom'] : $_SESSION['prenom'];
                $_SESSION['sexe'] = (!empty($_POST['updateUser']['sexe'])) ? $_POST['updateUser']['sexe'] : $_SESSION['sexe'];
                
                $response = array(
                    "code" => 200
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }else {
                $response = array(
                    "code" => 400
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }
            break;
    }
}

if (isset($_POST['fichesCotes'])) {
    # code...
    if($data = getPromosListTitulaire((int) $_SESSION['id'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['ficheCotationList'])) {
    # code...
    if($data = getFicheCotationList((int) $_SESSION['promotion'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}
if (isset($_POST['ficheCotationListJury'])) {
    # code...
    if($data = getFicheCotationList((int) $_SESSION['grille'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['keyWordFicheCotation'])) {
    # code...
    if($data = getFicheCotationListKeyword((int) $_POST['promotion'], $_POST['keyWordFicheCotation'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['idEtudiant']) AND isset($_POST['idMatiere'])) {
    # code...
    if($data = getCoteEtudiant((int) $_POST['idEtudiant'], (int) $_POST['idMatiere'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['idEtudiantCote']) AND isset($_POST['idMatiereCote'])) {
    # code...
    if($data = getCoteEtudiantTD((int) $_POST['idEtudiantCote'], (int) $_POST['idMatiereCote'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['idEtudiantCoteTD']) AND isset($_POST['idMatiereCoteTD']) AND isset($_POST['coteTD'])) {
    # code...
    if($data = updateCoteEtudiantTD((int) $_POST['idEtudiantCoteTD'], (int) $_POST['idMatiereCoteTD'], (int) $_POST['coteTD'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}


if (isset($_POST['idEtudiantCoteTP']) AND isset($_POST['idMatiereCoteTP']) AND isset($_POST['coteTP'])) {
    # code...
    if($data = updateCoteEtudiantTP((int) $_POST['idEtudiantCoteTP'], (int) $_POST['idMatiereCoteTP'], (float) $_POST['coteTP'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['idEtudiantCoteTD']) AND isset($_POST['idMatiereCoteTD']) AND isset($_POST['coteTD']) AND isset($_POST['coteTP'])) {
    # code...
    if($data = setCoteEtudiant($_POST['idEtudiantCoteTD'], $_POST['idMatiereCoteTD'], floatval($_POST['coteTD']), floatval($_POST['coteTP']))){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['idEtudiantCoteExamen']) AND isset($_POST['idMatiereCoteTD']) AND isset($_POST['coteExamen'])) {
    # code...
    if($data = updateCoteEtudiantExamen($_POST['idEtudiantCoteExamen'], $_POST['idMatiereCoteTD'], floatval($_POST['coteExamen']))){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if(isset($_POST['statutEtudiant'])){
    $data = getStatutEtudiant($_SESSION['id']);
    $response = array(
        "code" => 200,
        "data" => $data
    );

    echo json_encode($response, JSON_FORCE_OBJECT);
}

if (isset($_POST['regulier']) AND isset($_POST['rubrique'])) {
    # code...
    if($data = updateFinEtudiant($_POST['regulier'], (int) $_POST['rubrique'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['section']) AND isset($_POST['rubrique']) AND isset($_POST['word'])) {
    # code...
    if($data = getAllStudenRtCurrentSectionByWord($_POST['section'], $_POST['rubrique'], $_POST['word'])){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['authorisation'])) {
    # code...
    if($data = getAuthorisation()){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['authorisationTit'])) {
    # code...
    if($data = getAuthorisationTit()){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['codeAccess'])) {
    # code...
    $data = getAuthorisationForTit();
    if($_POST['codeAccess'] == $data['access']){
        $response = array(
            "code" => 200,
            "data" => "OK"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['myReleve'])) {
    # code...
    $data = getAllCotes($_SESSION['id_promotion'],  $_SESSION['id']);
    if(count($data) > 0){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if(isset($_POST['grilleByPromotion'])){
    $data = infoPromotion((int) $_POST['grilleByPromotion']);
    if(count($data) > 0){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }

}

if(isset($_POST['coteByGrille'])){

    //Matières
    $data = getMatieresGrilleByPromo((int) $_POST['coteByGrille']);
    
    //Cotes étudiant par matière
    foreach ($data as $key => $value) {
        $cotes = getCotesAllPromotionByMatiere($value['id_promotion']);

        foreach ($cotes as $k => $v) {
            $resp[] = array(
                "id" => $value['id'],
                "intitule" => $value['cours'],
                "credit" => $value['credit'],
                "resultat" => array(
                    "id" => $v['id'],
                    "nom" => $v['nom'],
                    "post_nom" => $v['post_nom'],
                    "prenom" => $v['prenom'],
                    "tp" => $v['tp'],
                    "td" => $v['td'],
                    "examen" => $v['examen']
                )
            );
        }
    }
    if(count($resp) > 0){
        $response = array(
            "code" => 200,
            "data" => $resp
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }

}

if (isset($_POST['coursByPromo'])) {
    $data = getMatieresGrilleByPromo((int) $_POST['coursByPromo']);
    if(count($data) > 0){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['autorisation_tit'])) {
    $data = getAuthorisationForTit();
    if(count($data) > 0){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['autorisation_jury'])) {
    $data = getAuthorisationForJury();
    if(count($data) > 0){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['action']) AND isset($_POST['qui'])) {
    switch ($_POST['qui']) {
        case 'TITULAIRE':
            $data = updateStatutTitulaire();
            if($data){
                $response = array(
                    "code" => 200,
                    "data" => "LES TITULAIRES NE PEUVENT PLUS INSERER LA COTE DE L'EXAMEN"
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }else {
                $response = array(
                    "code" => 400,
                    "data" => "Aucune infomation"
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }
            break;
        
        default:
        $data = updateStatutJury();
        if($data){
            $response = array(
                "code" => 200,
                "data" => "LES BUREAUX DU JURY NE PEUVENT PLUS INSERER LA COTE DE L'EXAMEN"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }else {
            $response = array(
                "code" => 400,
                "data" => "Aucune infomation"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }
            break;
    }
}

if (isset($_POST['action']) AND isset($_POST['who']) AND isset($_POST['mdp'])) {
    switch ($_POST['who']) {
        case 'TITULAIRE':
            $data = updateMdpTitulaire($_POST['mdp']);
            if($data){
                $response = array(
                    "code" => 200,
                    "data" => "LES TITULAIRES PEUVENT INSERER LA COTE DE L'EXAMEN"
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }else {
                $response = array(
                    "code" => 400,
                    "data" => "Aucune infomation"
                );
        
                echo json_encode($response, JSON_FORCE_OBJECT);
            }
            break;
        
        default:
        $data = updateMdpJury($_POST['mdp']);
        if($data){
            $response = array(
                "code" => 200,
                "data" => "LES BUREAUX DU JURY PEUVENT INSERER LA COTE DE L'EXAMEN"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }else {
            $response = array(
                "code" => 400,
                "data" => "Aucune infomation"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }
            break;
    }
}

if (isset($_POST['deleteMatiere'])) {
    $data = deleteMatiere((int) $_POST['deleteMatiere']);
    if($data){
        $response = array(
            "code" => 200
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if(isset($_POST['updateMatiereById']) AND isset($_POST['data'])){
    $data = null;
    foreach ($_POST['data'] as $key => $value) {
        switch ($key) {
            case 'intitule':
                if (!empty($value)) {
                    $data = updateIntituleByMatiere($_POST['updateMatiereById'], $value);
                }
                break;
            
            case 'credit':
                if (!empty($value)) {
                    $data = updateCreditByMatiere($_POST['updateMatiereById'], $value);
                }
                break;
            
            case 'code':
                if (!empty($value)) {
                    $data = updateCodeByMatiere($_POST['updateMatiereById'], $value);
                }
                break;
            
            case 'semestre':
                if (!empty($value)) {
                    $data = updateSemestreByMatiere($_POST['updateMatiereById'], $value);
                }
                break;

            default:
                if (!empty($value)) {
                    $data = updateUniteByMatiere($_POST['updateMatiereById'], $value);
                }
                break;
        }
    }

    if($data){
        $response = array(
            "code" => 200,
            "data" => "La modification s'est faite"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['sectionsAB'])) {
    $data = getSectionList();
    if($data){
        $response = array(
            "code" => 200,
            "data" => $data
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }else {
        $response = array(
            "code" => 400,
            "data" => "Aucune infomation"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}

if (isset($_POST['enseignant']) AND isset($_POST['mdp'])) {

    $id = htmlspecialchars($_POST['enseignant']);
    $addr = htmlspecialchars($_POST['addr']);
    $tel = htmlspecialchars($_POST['tel']);
    $mdp = htmlspecialchars($_POST['mdp']);

    $isExist = getEnseignantSignin($tel);
    if ($isExist) {
        $response = array(
            "code" => 400,
            "data" => "Cette utilisateur possède déjà un compte"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    } else {
    
        if($dataUser = signinEnseignant($id, sha1($mdp), $addr, $tel)){
            $response = array(
                "code" => 200,
                "data" => "Votre compte a été créer avec succès !"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        } else {
            $response = array(
                "code" => 400,
                "data" => "Un prombème est survenu lors de l'inscription, changer de numero de téléphone..."
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }
    }
    
}

if (isset($_POST['etudiant']) AND isset($_POST['mdp'])) {

    $id = htmlspecialchars($_POST['etudiant']);
    $addr = htmlspecialchars($_POST['addr']);
    $tel = htmlspecialchars($_POST['tel']);
    $mdp = htmlspecialchars($_POST['mdp']);

    $isExist = getEtudiantSignin($tel);
    if ($isExist) {
        $response = array(
            "code" => 400,
            "data" => "Cette utilisateur possède déjà un compte"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    } else {
    
        if($dataUser = signinEtudiant($id, sha1($mdp), $addr, $tel)){
            $response = array(
                "code" => 200,
                "data" => "Votre compte a été créer avec succès !"
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        } else {
            $response = array(
                "code" => 400,
                "data" => "Un prombème est survenu lors de l'inscription, verifier l'exactitude de vos informations..."
            );
    
            echo json_encode($response, JSON_FORCE_OBJECT);
        }
    }
    
}

if (isset($_POST['authSection']) AND isset($_POST['mdp'])) {

    $codeAccess = htmlspecialchars($_POST['authSection']);
    $mdp = htmlspecialchars($_POST['mdp']);

    if($dataUser = authSection($codeAccess, $mdp)){
        $_SESSION['module'] = 'Section';
        $_SESSION['id'] = $dataUser['id'];
        $_SESSION['designation'] = $dataUser['designation'];
        $_SESSION['description'] = $dataUser['description'];
        $_SESSION['logo'] = $dataUser['logo'];
        $_SESSION['id_president'] = $dataUser['id_chef'];
        $_SESSION['nom'] = $dataUser['nom'];
        $_SESSION['post_nom'] = $dataUser['post_nom'];
        $_SESSION['prenom'] = $dataUser['prenom'];
        $_SESSION['sexe'] = $dataUser['sexe'];
        $_SESSION['grade'] = $dataUser['grade'];

        $response = array(
            "code" => 200,
            "data" => "Bienvenu Mr le secretaire de section : " . $_SESSION['designation']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    } else {
        $response = array(
            "code" => 400,
            "data" => "Cette utilisateur ne possède pas un compte"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    
}

if (isset($_POST['authSection']) AND isset($_POST['mdp'])) {

    $codeAccess = htmlspecialchars($_POST['authSection']);
    $mdp = htmlspecialchars($_POST['mdp']);

    if($dataUser = authSection($codeAccess, $mdp)){
        $_SESSION['module'] = 'Section';
        $_SESSION['id'] = $dataUser['id'];
        $_SESSION['designation'] = $dataUser['designation'];
        $_SESSION['description'] = $dataUser['description'];
        $_SESSION['logo'] = $dataUser['logo'];
        $_SESSION['id_president'] = $dataUser['id_chef'];
        $_SESSION['nom'] = $dataUser['nom'];
        $_SESSION['post_nom'] = $dataUser['post_nom'];
        $_SESSION['prenom'] = $dataUser['prenom'];
        $_SESSION['sexe'] = $dataUser['sexe'];
        $_SESSION['grade'] = $dataUser['grade'];

        $response = array(
            "code" => 200,
            "data" => "Bienvenu Mr le secretaire de section : " . $_SESSION['designation']
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    } else {
        $response = array(
            "code" => 400,
            "data" => "Cette utilisateur ne possède pas un compte"
        );

        echo json_encode($response, JSON_FORCE_OBJECT);
    }
    
}