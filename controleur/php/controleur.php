<?php

/* -- LIEN MODELE - CONTRÔLEUR -- */
require "modele/modele.php";
//Connexion au compte					
require_once 'controleur/php/dompdf/autoload.inc.php';
require_once 'controleur/php/vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

/* CONTROLEURS BACKEND */
//Page login
function login(){
	//Message de bienvenu

    if (isset($_POST['submit'])) {

        if(isset($_POST['matricule']) AND !empty($_POST['matricule']) AND isset($_POST['mdp']) AND !empty($_POST['mdp']) AND isset($_POST['module']) AND !empty($_POST['module'])){
        
            $matricule = htmlspecialchars($_POST['matricule']);
            $module_user = (int) htmlspecialchars($_POST['module']);
            $mdp = htmlspecialchars($_POST['mdp']);
            
            switch ($module_user) {
                case 1:
                    # SECTION
                    if($dataUser = authSection($matricule, crypt($mdp, $matricule))){
                        $_SESSION['module'] = 'Section';

                        $_SESSION['id'] = $dataUser['id'];
                        $_SESSION['designation'] = $dataUser['designation'];
                        $_SESSION['description'] = $dataUser['description'];
                        $_SESSION['logo'] = $dataUser['logo'];
                        $_SESSION['id_president'] = $dataUser['id_president'];
                        $_SESSION['nom'] = $dataUser['nom'];
                        $_SESSION['post_nom'] = $dataUser['post_nom'];
                        $_SESSION['prenom'] = $dataUser['prenom'];
                        $_SESSION['sexe'] = $dataUser['sexe'];
                        $_SESSION['grade'] = $dataUser['grade'];

                        header('Location:index.php');
                    } else {
                        $msg = "Vous n'êtes pas enregistré dans le système, veuillez vous rapprocher du service académique...";
                    }
                    break;

                case 2:
                    # COMGER
                    if ($dataUser = authComger($matricule, crypt($mdp, $matricule))) {
                        $_SESSION['module'] = 'Comger';
                        $_SESSION['id'] = $dataUser['id'];
                        $_SESSION['nom'] = $dataUser['nom'];
                        $_SESSION['post_nom'] = $dataUser['post_nom'];
                        $_SESSION['prenom'] = $dataUser['prenom'];
                        $_SESSION['matricule'] = $dataUser['matricule'];
                        $_SESSION['grade'] = $dataUser['grade'];
                        $_SESSION['frais_academique'] = $dataUser['frais_academique'];
                        $_SESSION['enrol_1'] = $dataUser['enrol_1'];
                        $_SESSION['enrol_2'] = $dataUser['enrol_2'];

                        if ($_SESSION['grade'] == "SGAC") {
                            header('Location:index.php?sgac');
                        } else {
                            header('Location:index.php');
                        }
                    } else {
                        $msg = "Vous n'êtes pas enregistré dans le système, veuillez vous rapprocher du service académique...";
                    }
                    break;
                
                    
                case 3:
                    # TITULAIRE
                    if($dataUser = authEnseignant($matricule, crypt($mdp, $matricule))){
                        $_SESSION['module'] = 'Titulaire';
    
                        $_SESSION['id'] = $dataUser['id'];
                        $_SESSION['nom'] = $dataUser['nom'];
                        $_SESSION['post_nom'] = $dataUser['post_nom'];
                        $_SESSION['prenom'] = $dataUser['prenom'];
                        $_SESSION['sexe'] = $dataUser['sexe']; 
                        $_SESSION['grade'] = $dataUser['grade'];
                        $_SESSION['matricule'] = $dataUser['matricule'];
                        $_SESSION['statut'] = $dataUser['statut'];
                        $_SESSION['id_section'] = $dataUser['id_section'];
                        header('Location:index.php');

                    }else {
                        $msg = "Vous n'êtes pas enregistré dans le système, veuillez vous rapprocher du service académique...";
                    } 
                    break;
                    
                case 5:
                    #JURY
                    if($dataUser = authJury($matricule, $mdp)){
                        $_SESSION['module'] = 'Jury';
    
                        $_SESSION['id'] = $dataUser['id'];
                        $_SESSION['designation'] = $dataUser['designation'];
                        $_SESSION['mdp'] = $dataUser['mdp'];
                        $_SESSION['id_secretaire'] = $dataUser['id_sec'];
                        $_SESSION['statut'] = $dataUser['statut'];
                        header('Location:index.php');

                    }else {
                        $msg = "Vous n'êtes pas enregistré dans le système, veuillez vous rapprocher du service académique...";
                    }
                    break;

                default:
                    # ETUDIANT
                    if ($dataUser = authEtudiant($matricule, crypt($mdp, $matricule))) {
                        $_SESSION['module'] = 'Etudiant';
    
                        $_SESSION['id'] = $dataUser['id'];
                        $_SESSION['nom'] = $dataUser['nom'];
                        $_SESSION['post_nom'] = $dataUser['post_nom'];
                        $_SESSION['prenom'] = $dataUser['prenom'];
                        $_SESSION['sexe'] = $dataUser['sexe'];
                        $_SESSION['statut'] = $dataUser['statut'];
                        $_SESSION['matricule'] = $dataUser['matricule'];
                        $_SESSION['grade'] = $dataUser['grade'];
                        $_SESSION['id_promotion'] = $dataUser['id_promotion'];
                        $_SESSION['frais_academique'] = $dataUser['frais_academique'];
                        $_SESSION['enrol_1'] = $dataUser['enrol_1'];
                        $_SESSION['enrol_2'] = $dataUser['enrol_2'];
                        
                        header('Location:index.php');
                    } else {
                        $msg = "Vous n'êtes pas enregistré dans le système, veuillez vous rapprocher du service académique...";
                    }
                    break;
            }
    
        }else{
            $msg = "Veuillez remplir tous les champs svp...";
        }
    }else{

        $msg = "Veuillez entrer vos identifiants de connexion (code d'access, mot de passe et module)...";
    }

	//Lien vue - controleur
	require "vue/pages/login.php";
}

function accessEtudiant($id_promotion){     
    $dataStudents = getStudentsByPromo($id_promotion);
    
    $niveauOfPromotion = infoPromotion($id_promotion);  
    
    $systeme = '(' . $niveauOfPromotion['systeme'] . ')';
        
    //OUVERTURE TEMPLATE
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('vue/gabarit/assets/template_code_access.xlsx');
    $worksheet = $spreadsheet->getActiveSheet();
            
    //PROMOTION NIVEAU
    $worksheet->getCell('C2')->setValue($niveauOfPromotion['niveau']);
        
    //PROMOTION SECTION
    $worksheet->getCell('C3')->setValue($niveauOfPromotion['section']);
        
    //PROMOTION SYSTEME
    $worksheet->getCell('C4')->setValue($systeme);
        
    $L = 8;

    foreach ($dataStudents as $key => $value) {
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        //BORDURE
        $worksheet->getStyle('A' . $L)->applyFromArray($styleArray);

        //BORDURE
        $worksheet->getStyle('B' . $L)->applyFromArray($styleArray);

        //BORDURE
        $worksheet->getStyle('C' . $L)->applyFromArray($styleArray);

        //N° LIGNE
        $worksheet->getCell('A' . $L)->setValue($key+1);

        //ETUDIANT
        $worksheet->getCell('B' . $L)->setValue($value['nom'] . " " . $value['post_nom'] . " " . $value['prenom']);

        //Matricule
        $worksheet->getCell('C' . $L)->setValue($value['matricule']);

        $L++;
    } 

    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment;filename="ETUDIANTS_' . $niveauOfPromotion['niveau'] . '_' . $niveauOfPromotion['section'] . '_'. time() . '.xlsx"'); 

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
}

function accessEnseignant(){  
    $data = getAllEnseignant();

    $visiteurs = 0;
    $permanants = 0;
    
    foreach ($data as $key => $value) {
        if ($value['statut'] == 'visiteur') {
            $visiteurs++;
        } else {
            $permanants++;
        }
        
    }
        
    //OUVERTURE TEMPLATE
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('vue/gabarit/assets/template_code_access_enseignants.xlsx');
    $worksheet = $spreadsheet->getActiveSheet();
            
    //PROMOTION GRILLE
    $worksheet->getCell('C3')->setValue($visiteurs);
        
    //PROMOTION GRILLE
    $worksheet->getCell('C2')->setValue($permanants);
        
    $L = 6;

    foreach ($data as $key => $value) {
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        //BORDURE
        $worksheet->getStyle('A' . $L)->applyFromArray($styleArray);

        //BORDURE
        $worksheet->getStyle('B' . $L)->applyFromArray($styleArray);

        //BORDURE
        $worksheet->getStyle('C' . $L)->applyFromArray($styleArray);

        //N° LIGNE
        $worksheet->getCell('A' . $L)->setValue($key+1);

        //ETUDIANT
        $worksheet->getCell('B' . $L)->setValue($value['nom'] . " " . $value['post_nom'] . " " . $value['prenom']);

        //Matricule
        $worksheet->getCell('C' . $L)->setValue($value['matricule']);

        $L++;
    } 

    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment;filename="ENSEIGNANTS_' . time(). '.xlsx"'); 

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
}

function resetEnseignants() {
    $data = getAllEnseignant();
    
    foreach ($data as $key => $value) {
        $matricule = $value['id'] . '/' . rand($value['id'], $value['section']) . '/' . $value['nom'];
        
        $ref = array(
            'matricule' => $matricule,
            'id' => $value['id']
        );

        updateEnseignant($ref);
    }

    header('location:index.php?sgac');
    
}

function resetEtudiants() {
    $data = getAllStudents();
    
    foreach ($data as $key => $value) {
        $matricule = $value['id'] . '-' . rand($value['frais_academique'], time()) . '-' . $value['nom'];
        
        $ref = array(
            'matricule' => $matricule,
            'id' => $value['id']
        );

        updateEtudiant($ref);
    }

    header('location:index.php?sgac');
    
}

function signin(){
	//Message de bienvenu
    $itemsPromotions = getAllPromotions();

    if (isset($_POST['submit'])) {

        if(isset($_POST['matricule']) AND !empty($_POST['matricule']) AND isset($_POST['mdp']) AND !empty($_POST['mdp']) AND isset($_POST['c_mdp']) AND !empty($_POST['c_mdp']) AND isset($_POST['module']) AND !empty($_POST['module'])){
        
            $matricule = htmlspecialchars($_POST['matricule']);
            $module_user = (int) htmlspecialchars($_POST['module']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $c_mdp = htmlspecialchars($_POST['c_mdp']);

            if ($mdp == $c_mdp) {            
            
                switch ($module_user) {
                    case 1:
                        # ENSEIGNANT
                        $isExist = getEnseignantSignin($matricule);
                        if ($isExist) {
                            $msg = "Cette utilisateur possède déjà un compte";
                        } else {
                        
                            if($dataUser = signinEnseignant($matricule, crypt($mdp, $matricule))){    
                                header('Location:index.php');
                            } else {
                                $msg = "Un prombème est survenu lors de l'inscription, veuillez verifier votre code d'accès...";
                            }
                        }
                        break;
    
                    case 2:
                        # ETUDIANT
                        $isExist = getEtudiantSignin($matricule);
                        if ($isExist) {
                            # code...
                            $msg = "Cette utilisateur existe déjà dans la base de donnée";
                        } else {
                            # code...
                            if ($dataUser = signinEtudiant($matricule, crypt($mdp, $matricule))) {
                                header('Location:index.php');
                            } else {
                                $msg = "Un prombème est survenu lors de l'inscription, veuillez verifier votre code d'accès...";
                            }
                        }
                        
                        break;
                    
                        
                    case 3:
                        # ADMINISTRATIF
                        $isExist = getAdminSignin($matricule);
                        if ($isExist) {# code...
                            $msg = "Cette utilisateur existe déjà dans la base de donnée";
                        } else {
                                # code...
                            if($dataUser = signinAdmin($matricule, crypt($mdp, $matricule))){
                                header('Location:index.php');    
                            }else {
                          
                        }
                          $msg = "Un prombème est survenu lors de l'inscription, veuillez verifier votre code d'accès...";
                        } 
                        break;
                    default:
                        # N'IMPORTE QUOI
                        $msg = "Veuillez choisir un type d'utilisateur correct svp...";
                        break;
                }
            } else {
                $msg = "Le mot de passe doit être confirmer";
            }
    
        }else{
            $msg = "Veuillez remplir tous les champs svp...";
        }
    }else{

        $msg = "Veuillez entrer votre code d'access, choissiez votre mot de passe et et le type d'utilisateur";
    }

	//Lien vue - controleur
	require "vue/pages/signin.php";
}

//Page d'autorisation
function sgacd(){
    $itemsPromotions = getPromotions();

    require "vue/pages/academique.php";
}

//Page Tableau de bord
function dashboard(){

    if ($_SESSION['module'] == 'Comger') {
        $dataStat = getStatComger();
    }
    if ($_SESSION['module'] == 'Etudiant') {
        $dataStatSudent = getUnitesStudent($_SESSION['id_promotion']);
    }

	//Lien vue - controleur
	require "vue/pages/dashboard.php";
}
function bulletin($semestre){
    $infosBulletin = getDetailsPromotion($_SESSION['id_promotion']);
    $infoReleve = getDetailsReleve($_SESSION['id']);
    $dataCotes = getAllCotes($_SESSION['id_promotion'],  $_SESSION['id'], $semestre);
    $maxOfPromotion = getMaxByPromo($_SESSION['id_promotion']);
    $totObtByStudent = getByObtEtudiant($_SESSION['id']);
    $dataCours = getMatieresByPromo($_SESSION['id_promotion']);
    //print_r($dataCotes);
    if($infosBulletin['lblSysteme'] == "LMD"){
        $dataCredits = array(
            'ncv' => 0,
            'ncnv' => 0
        );

        foreach ($dataCours as $key => $value) {
            $data = getCoteEtudiant($_SESSION['id'], $value['id']);
            //print_r($data);
            if (isset($data['tp']) AND isset($data['td']) AND isset($data['examen'])) {
                if($data['tp'] + $data['td'] + $data['examen'] >= 10.0){
                    $dataCredits['ncv'] = $dataCredits['ncv'] + $value['credit'];
                }else {
                    $dataCredits['ncnv'] = $dataCredits['ncnv'] + $value['credit'];
                }
            } else {
                $dataCredits['ncnv'] = $dataCredits['ncnv'] + $value['credit'];
            }
            
        }
        $pourcentage = round(($totObtByStudent['OBT']/$maxOfPromotion['Maximum'])*100,2);
        if ($pourcentage >=50.0) {
            if ($pourcentage >= 60.0) {
                if ($pourcentage >= 70.0) {
                    if ($pourcentage >= 80.0) {
                        if ($pourcentage >= 90.0) {
                            $jury = "A";
                        } else {
                            $jury = "B";
                        }
                        
                    } else {
                        $jury = "C";
                    }
                    
                } else {
                    $jury = "D";
                }
                
            } else {
                $jury = "E";
            }
            
        } else {
            $jury = "X";
        }
        //print_r($dataCours);
    }else{
        $resultat = 0;
        $tot = 0;
        foreach ($dataCours as $key => $value) {
            $data = getAllCotes($_SESSION['id_promotion'], $_SESSION['id'], $semestre);            

            $counterLegers = 0;
            $counterGraves = 0;
            $counterManque = 0;

            foreach ($data as $key => $value) {
                //MANQUE DE LA COTE
                if (!isset($value['tp']) OR !isset($value['td']) OR !isset($value['examen'])) {                
                    $counterManque = $counterManque + 1;
                }
                
                //COTE COURS
                if (!empty($value['tp']) AND !empty($value['td']) AND !empty($value['examen'])) {                      
                    $resultat = $resultat + ($value['tp'] + $value['td'] + $value['examen'])*$value['credit'];
                    $tot = $tot + 20*$value['credit'];

                    $cote = $value['tp'] + $value['td'] + $value['examen'];
                    
                    if ($cote < 10) {
                        if ($cote < 8) {
                            $counterGraves = $counterGraves + 1;
                        }else{
                            $counterLegers = $counterLegers + 1;
                        }
                    }        
                }
            }                
        }

        //DELIBERATION
        if (!$counterManque) {
            
            $pourcentage = ($tot AND $resultat) ? ((float) $resultat/(float) $tot)*100 : '';
         
            if (empty($pourcentage)) {
                $jury = "Pas d'info.";
            }else {
                if ($pourcentage < 40.0) {
                    if ($counterManque >0) {
                        $jury = "ANAF";
                    } else {
                        $jury = "NAF";
                    }
                    
                } else {
                    if ($pourcentage < 50.0) {
                        $jury = "A";
                    } else {
                        if ($counterGraves > 0) {
                            $jury = "A";
                        }else{
                            if ($pourcentage <= 100.0 AND $counterManque > 0) {
                                $jury = "AA";
                            }
                            if ($pourcentage >= 50.0 AND $pourcentage <= 69.99) {
                                if ($counterLegers < 1) {
                                    $jury = "S";
                                } else {
                                    if ($counterLegers == 1 AND $pourcentage <= 54.99) {
                                        $jury = "S";
                                    }
                                    if ($counterLegers <= 2 AND $pourcentage >= 55.0 AND $pourcentage <=59.99) {
                                        $jury = "S";
                                    }
                                    if ($counterLegers <= 3 AND $pourcentage >= 60.0 AND $pourcentage <=69.99) {
                                        $jury = "S";
                                    }                     
                                }                    
                            } else {
                                if ($pourcentage <= 100.0) {
                                    if ($pourcentage <= 89.99) {
                                        if ($pourcentage <= 79.99) {
                                            $jury = "D";
                                        }else{
                                            $jury = "GD";
                                        }                        
                                    } else {
                                        $jury = "PGD";
                                    }                        
                                } 
            
                            } 
                        }
                        
                    }            
                }
            }
        } else {
            $pourcentage = "";
            $jury = "AA";
        }

    }
    
    //print_r($data);
	//Lien vue - controleur
	require "vue/pages/bulletin.php";
}

//Page Tableau de bord
function fichesCotation(){
    $promotion = (int) $_GET['fiche'];
    $matiere = getTitEcs($_SESSION['id'], $promotion, (int) $_GET['matiere']);
    $infoPromotion = infoPromotion($promotion);
    $dataStudents = getStudentsByPromo((int) $_GET['fiche']);
	//Lien vue - controleur
	require "vue/pages/fiche.php";
}
function grilleDeliberation(){
    $_SESSION['grille'] = (int) $_GET['grille'];
    $dataStudents = getStudentsByPromo((int) $_GET['grille']);
    $dataCours = getMatieresByPromo((int) $_GET['grille']);
    $niveauOfPromotion = infoPromotion((int) $_GET['grille']);
    $maxOfPromotion = getMaxByPromo((int) $_GET['grille']);
    $palmaress = getByObtPromo((int) $_GET['grille']);
    $effectifOfPromo = getEffByPromo((int) $_GET['grille']);
    if (!$maxOfPromotion['Maximum']) {
        $maxOfPromotion['Maximum'] = 1;
    }
    for ($i=5; $i >= 0; $i--) { 
        $participants[] = round(($i * $effectifOfPromo['participant']/5)*100/$effectifOfPromo['participant']);
    }

    foreach ($palmaress as $key => $value) {
        $dataPalmaress[] = array(
            "id" => $value['id'],
            "nom" => $value['nom'],
            "post_nom" => $value['post_nom'],
            "pourcentage" => round(($value['OBT']/$maxOfPromotion['Maximum'])*100, 2)
        );
    }
    $apA = 0;
    $apB = 0;
    $apC = 0;
    $apD = 0;
    $apE = 0;
    $apX = 0;
    foreach ($dataPalmaress as $value) {        
        if ($value['pourcentage'] >=50.0) {
            if ($value['pourcentage'] >= 60.0) {
                if ($value['pourcentage'] >= 70.0) {
                    if ($value['pourcentage'] >= 80.0) {
                        if ($value['pourcentage'] >= 90.0) {
                            $apA = $apA + 1;
                        } else {
                            $apB = $apB + 1;
                        }
                        
                    } else {
                        $apC = $apC + 1;
                    }
                    
                } else {
                    $apD = $apD + 1;
                }
                
            } else {
                $apE = $apE + 1;
            }
            
        } else {
            $apX = $apX + 1;
        }
    }

	//Lien vue - controleur
	require "vue/pages/grille.php";
}

function detailleGrille(){
    $dt = time();    
    
    // Affichage de quelque chose comme : Monday 8th of August 2005 03:12:46 PM
    $impression = date('d/m/Y H:i:s', $dt);

    $_SESSION['grille'] = (int) $_GET['grille'];
    $dataStudents = getStudentsByPromo((int) $_GET['grille']);
    $dataCours = getMatieresByPromo((int) $_GET['grille']);
    $niveauOfPromotion = infoPromotion((int) $_GET['grille']);
    $maxOfPromotion = getMaxByPromo((int) $_GET['grille']);
    $palmaress = getByObtPromo((int) $_GET['grille']);
    $effectifOfPromo = getEffByPromo((int) $_GET['grille']);
    $jury = getJury($_SESSION['id']);    
    
    $infoGrille = "GRILLE DE DELIBERATION : " . $niveauOfPromotion['niveau'] . " - " . $niveauOfPromotion['section'];

    if ($niveauOfPromotion['systeme'] == 'LMD') {
        
        //OUVERTURE TEMPLATE
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('vue/gabarit/assets/tempplateLMD.xlsx');
        $worksheet = $spreadsheet->getActiveSheet(); 
            
        //PROMOTION GRILLE
        $worksheet->getCell('C2')->setValue($impression);
            
        //PROMOTION GRILLE
        $worksheet->getCell('C3')->setValue($jury['president']);
            
        //PROMOTION GRILLE
        $worksheet->getCell('C4')->setValue($jury['secretaire']);
            
        //PROMOTION GRILLE
        $worksheet->getCell('A6')->setValue($infoGrille);
        
        for ($i=5; $i >= 0; $i--) { 
            $participants[] = round(($i * $effectifOfPromo['participant']/5)*100/$effectifOfPromo['participant']);
        }
    
        foreach ($dataCours as $key => $value) { 
            $j = $key +2;
            $EC = $value['intitule'];
            
            $worksheet->setCellValueByColumnAndRow($j, 8, $EC);    
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
            ];
            
            $worksheet->getStyle('A8')->applyFromArray($styleArray);

            $worksheet->setCellValueByColumnAndRow($j, 7, $value['credit']);
        }
        
        $worksheet->getCell('A7')->setValue('CREDIT');
        $worksheet->getCell('AA7')->setValue('Maximum');    
        $worksheet->getCell('AB7')->setValue('Total');
        $worksheet->getCell('AC7')->setValue('Pourcentage');
        $worksheet->getCell('AD7')->setValue('NCV');
        $worksheet->getCell('AE7')->setValue('NCNV');
        $worksheet->getCell('AF7')->setValue('Appréciation');
        $worksheet->getCell('AG7')->setValue('Capitalisation');
        
        $L = 9;
        foreach ($dataStudents as $key => $value) {
            $ncv = 0;
            $ncnv = 0;
            $tp = 0;
            $td = 0;
            $examen = 0;
        
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
            ];
            $worksheet->getStyle('A' . $L)->applyFromArray($styleArray);    
            $worksheet->getCell('A' . $L)->setValue($value['nom'] . " - " . $value['post_nom']);
            
            $M = 2;
            foreach ($dataCours as $k => $v) {
                $data = getCoteEtudiant($value['id'], $v['id']);
                $colName = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC');
                
                if(isset($data['tp'])){
                    $tp = (int) $data['tp']*$v['credit'];
                }else{
                    $tp = $tp + 0;
                }
    
                if(isset($data['td'])){
                    $td = (int) $data['td']*$v['credit'];
                }else{
                    $td = $td + 0;
                }
    
                if(isset($data['examen'])){
                    $examen =(int) $data['examen']*$v['credit'];
                }else{
                    $examen = $examen + 0;
                }
    
                if(isset($data['tp']) AND isset($data['td']) AND isset($data['examen'])){
                    if($data['tp'] + $data['td'] + $data['examen'] >= 10.0){                    
                        $ncv = $ncv + $v['credit'];
                    }else {
                        $ncnv = $ncnv + $v['credit'];
                    }                 
                    
                    $styleArray = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '00000000'],
                            ],
                        ],
                    ];
                    $worksheet->getStyle($colName[$k] . $L)->applyFromArray($styleArray);  
                    $totalEtudiant = $data['tp'] + $data['td'] + $data['examen'];
                    $worksheet->setCellValueByColumnAndRow($M, $L, $totalEtudiant); 
                }else{
                    $ncnv = $ncnv + $v['credit'];
                    $styleArray = [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                            ],
                        ],
                    ];
                    $worksheet->getStyle($colName[$k] . $L)->applyFromArray($styleArray);  
                    $totalEtudiant = " - ";
                    $worksheet->setCellValueByColumnAndRow($M, $L, $totalEtudiant); 
                }
    
                $max[] = 20*$v['credit'];
                $moyTot[] = ($tp+$td+$examen);
                $M++;
            }

            $den = array_sum($max);
            $num = getByObtEtudiant($value['id']);
            $pourcentage = ($num['OBT']/$den);
    
            $coeff = (float) $ncv/(float) ($ncv+$ncnv);
            $coeff = $coeff*100;
    
            if ($coeff  >= 70.0) { 
                if ($pourcentage >=50.0) {
                    if ($pourcentage >= 60.0) {
                        if ($pourcentage >= 70.0) {
                            if ($pourcentage >= 80.0) {
                                if ($pourcentage >= 90.0) {
                                    $ap = "A";
                                } else {
                                    $ap = "B";
                                }
                                
                            } else {
                                $ap = "C";
                            }
                            
                        } else {
                            $ap = "D";
                        }                
                    } else {
                        $ap = "E";
                    }
                } else {
                    $ap = "X";
                }
    
            } else {
                $ap = "NON";
            }
    
            if ($ncnv) {
                $cap = "DETTES";
            } else {
                $cap = "CAP";
            }

            $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
            ];
            
            $worksheet->getStyle('AA' . $L)->applyFromArray($styleArray);   
            $worksheet->getCell('AA' . $L)->setValue($den); 

            $worksheet->getStyle('AB' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AB' . $L)->setValue($num['OBT']);

            $worksheet->getStyle('AC' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AC' . $L)->setValue($pourcentage);

            $worksheet->getStyle('AD' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AD' . $L)->setValue($ncv);

            $worksheet->getStyle('AE' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AE' . $L)->setValue($ncnv);

            $worksheet->getStyle('AF' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AF' . $L)->setValue($ap);

            $worksheet->getStyle('AG' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AG' . $L)->setValue($cap);
             
            $max = array();
            $moyTot = array();

            $L++;
        } 
    
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename="GRILLE_' . $niveauOfPromotion['niveau'] . '_' . $niveauOfPromotion['section'] . '.xlsx"');  

    } else {
        
        //OUVERTURE TEMPLATE
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('vue/gabarit/assets/tempplateAS.xlsx');
        $worksheet = $spreadsheet->getActiveSheet(); 
            
        //PROMOTION GRILLE
        $worksheet->getCell('C2')->setValue($impression);
            
        //PROMOTION GRILLE
        $worksheet->getCell('C3')->setValue($jury['president']);
            
        //PROMOTION GRILLE
        $worksheet->getCell('C4')->setValue($jury['secretaire']);
            
        //PROMOTION GRILLE
        $worksheet->getCell('A6')->setValue($infoGrille);
    
        //LISTE DES MATIERES
    
        foreach ($dataCours as $key => $value) { 
            $j = $key +2;

            $EC = $value['intitule'];

            $worksheet->setCellValueByColumnAndRow($j, 8, $EC);    
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
            ];
            
            $worksheet->getStyle('A8')->applyFromArray($styleArray); 
            
            //LISTE DES CREDITS
            $worksheet->setCellValueByColumnAndRow($j, 7, $value['credit']);
        }

        $worksheet->getCell('A7')->setValue('PONDERATION');
        $worksheet->getCell('AA7')->setValue('Maximum');    
        $worksheet->getCell('AB7')->setValue('Total');
        $worksheet->getCell('AC7')->setValue('Pourcentage');
        $worksheet->getCell('AD7')->setValue('ECEHECS LEGERS');
        $worksheet->getCell('AE7')->setValue('ECHECS GRAVES');
        $worksheet->getCell('AF7')->setValue('MANQUE DES COTES');
        $worksheet->getCell('AG7')->setValue('DECISION DU JURY');

        //LISTE DES COTES         
        $L = 9;
        
        foreach ($dataStudents as $key => $value) {

            $counterLegers = 0;
            $counterGraves = 0;
            $counterManque = 0;
            $resultat = 0;

            $tp = 0;
            $td = 0;
            $examen = 0;
            
            //IDENTITES ETUDIANT
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
            ];
            $worksheet->getStyle('A' . $L)->applyFromArray($styleArray);    
            $worksheet->getCell('A' . $L)->setValue($value['nom'] . " - " . $value['post_nom']);
            

            $M = 2;
            foreach ($dataCours as $k => $v) {
                $data = getCoteEtudiant($value['id'], $v['id']);

                //LIGNE ETUDIANT
                $colName = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                
                //COTES ANNUEL ET EXAMEN
                if(isset($data['tp'])){
                    $tp = (int) $data['tp']*$v['credit'];
                }else{
                    $tp = $tp + 0;
                }
    
                if(isset($data['td'])){
                    $td = (int) $data['td']*$v['credit'];
                }else{
                    $td = $td + 0;
                }
    
                if(isset($data['examen'])){
                    $examen =(int) $data['examen']*$v['credit'];
                }else{
                    $examen = $examen + 0;
                }

                //TOTAL COURS    
                if(isset($data['tp']) AND isset($data['td']) AND isset($data['examen'])){

                    if($data['tp'] + $data['td'] + $data['examen'] < 10.0){ 

                        if ($data['tp'] + $data['td'] + $data['examen'] < 8.0) {
                            # code...
                            $counterGraves++;

                        } else {
                            # code...

                            $counterLegers++;
                        }
                    }else {

                        $counterGraves = $counterGraves + 0;
                        $counterLegers = $counterLegers + 0;
                    }                 
                    
                    $counterManque = $counterManque + 0;

                    //CELLLE COTE
                    $styleArray = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '00000000'],
                            ],
                        ],
                    ];

                    $worksheet->getStyle($colName[$k] . $L)->applyFromArray($styleArray);

                    $totalEtudiant = $data['tp'] + $data['td'] + $data['examen'];

                    $worksheet->setCellValueByColumnAndRow($M, $L, $totalEtudiant); 
                }else{
                    $counterManque++;
                    
                    //CELLULE COTE
                    $styleArray = [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                            ],
                        ],
                    ];
                    $worksheet->getStyle($colName[$k] . $L)->applyFromArray($styleArray);  
                    $totalEtudiant = " - ";
                    $worksheet->setCellValueByColumnAndRow($M, $L, $totalEtudiant); 
                }
    
                $max[] = 20*$v['credit'];
                $moyTot[] = ($tp+$td+$examen);

                //PROCHAIN COURS
                $M++;
            }

            //CALCUL DU POURCENTAGE
            $den = array_sum($max);
            $num = getByObtEtudiant($value['id']);
            $pourcentage = (isset($num['OBT'])) ? $num['OBT']/$den : 0 ;
            
            //DELIBERATION
            if ($pourcentage*100 < 40.0) {
                if ($counterManque >0) {
                    $jury = "ANAF";
                } else {
                    $jury = "NAF";
                }
                
            } else {
                if ($pourcentage*100 < 50.0) {
                    $jury = "A";
                } else {
                    if ($counterGraves > 0) {
                        $jury = "A";
                    }else{
                        if ($pourcentage*100 <= 100.0 AND $counterManque > 0) {
                            $jury = "AA";
                        }
                        if ($pourcentage*100 >= 50.0 AND $pourcentage*100 <= 69.99) {
                            if ($counterLegers < 1) {
                                $jury = "S";
                            } else {
                                if ($counterLegers == 1 AND $pourcentage*100 <= 54.99) {
                                    $jury = "S";
                                }
                                if ($counterLegers <= 2 AND $pourcentage*100 >= 55.0 AND $pourcentage*100 <=59.99) {
                                    $jury = "S";
                                }
                                if ($counterLegers <= 3 AND $pourcentage*100 >= 60.0 AND $pourcentage*100 <=69.99) {
                                    $jury = "S";
                                }                     
                            }                    
                        } else {
                            if ($pourcentage*100 <= 100.0) {
                                if ($pourcentage*100 <= 89.99) {
                                    if ($pourcentage*100 <= 79.99) {
                                        $jury = "D";
                                    }else{
                                        $jury = "GD";
                                    }                        
                                } else {
                                    $jury = "PGD";
                                }                        
                            } 
        
                        } 
                    }
                    
                }            
            }
            //REMPLISSAGE RESUME ETUDIANT
            $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
            ];
            
            #MAXIMUM
            $worksheet->getStyle('AA' . $L)->applyFromArray($styleArray);   
            $worksheet->getCell('AA' . $L)->setValue($den); 

            #TOTAL OBTENU
            $worksheet->getStyle('AB' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AB' . $L)->setValue($num['OBT']);

            #POURCENTAGE
            $worksheet->getStyle('AC' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AC' . $L)->setValue($pourcentage);

            #EC-LEGERS
            $worksheet->getStyle('AD' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AD' . $L)->setValue($counterLegers);

            #EC-GRAVES
            $worksheet->getStyle('AE' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AE' . $L)->setValue($counterGraves);

            #MANQUES
            $worksheet->getStyle('AF' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AF' . $L)->setValue($counterManque);

            #DECISION
            $worksheet->getStyle('AG' . $L)->applyFromArray($styleArray);  
            $worksheet->getCell('AG' . $L)->setValue($jury);
             
            $max = array();
            $moyTot = array();

            //PROCHAIN ETUDIAN
            $L++;
        } 
    
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename="GRILLE_' . $niveauOfPromotion['niveau'] . '_' . $niveauOfPromotion['section'] . '.xlsx"');  
    }

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
}

function deliberation($student, $promotion){
    //Pourcentage  
    $infosBulletin = getDetailsPromotion($promotion);  
    $maxOfPromotion = getMaxByPromo($promotion);
    $totObtByStudent = getByObtEtudiant($student);
    $dataCours = getMatieresByPromo((int) $_GET['grille']);
    $dataAncienSys = getAllCotesJury($promotion,  $student);
    $counterLegers = 0;
    $counterGraves = 0;
    $counterManque = 0;    
    $resultat = 0;
    $tot = 0;
    
    foreach ($dataAncienSys as $key => $value) {
      $tot = $tot + 20*$value['credit'];
      if (!isset($value['tp']) OR !isset($value['td']) OR !isset($value['examen'])) {                
        $counterManque = $counterManque + 1;
      }
      
      if (!empty($value['tp']) AND !empty($value['td']) AND !empty($value['examen'])) {                      
        $resultat = $resultat + ($value['tp'] + $value['td'] + $value['examen'])*$value['credit'];
        $cote = $value['tp'] + $value['td'] + $value['examen'];
        if ($cote < 9) {
          if ($cote < 8) {
            $counterGraves = $counterGraves + 1;
          }else{
            $counterLegers = $counterLegers + 1;
          }
        }        
      }
    }
    $dataCredits = array(
        'ncv' => 0,
        'ncnv' => 0
    );
    foreach ($dataCours as $key => $value) {
        $data = getCoteEtudiant($student, $value['id']);
        if (isset($data['tp']) AND isset($data['td']) AND isset($data['examen'])) {
            if($data['tp'] + $data['td'] + $data['examen'] >= 10.0){
                $dataCredits['ncv'] = $dataCredits['ncv'] + $value['credit'];
            }else {
                $dataCredits['ncnv'] = $dataCredits['ncnv'] + $value['credit'];
            }
        } else {
            $dataCredits['ncnv'] = $dataCredits['ncnv'] + $value['credit'];
        }
        
    }
    if (!$maxOfPromotion['Maximum']) {
        $maxOfPromotion['Maximum'] = 1;
    }
    if ($infosBulletin['lblSysteme'] == "LMD") {

        $pourcentage = round(($totObtByStudent['OBT']/$maxOfPromotion['Maximum'])*100,2);
        if ($pourcentage >=50.0) {
            if ($pourcentage >= 60.0) {
                if ($pourcentage >= 70.0) {
                    if ($pourcentage >= 80.0) {
                        if ($pourcentage >= 90.0) {
                            $ap = "A";
                        } else {
                            $ap = "B";
                        }
                        
                    } else {
                        $ap = "C";
                    }
                    
                } else {
                    $ap = "D";
                }
                
            } else {
                $ap = "E";
            }
            
        } else {
            $ap = "X";
        }

    }else{
        if (!$counterManque) {
            if(!$tot){
                $pourcentageA = "";
            }else{
                $pourcentageA = ((float) $resultat/(float) $tot)*100;
            }
            if (empty($pourcentageA)) {
                $ap = "Pas d'info.";
            }else {
                if ($pourcentageA < 40.0) {
                    if ($counterManque >0) {
                        $ap = "ANAF";
                    } else {
                        $ap = "NAF";
                    }
                    
                } else {
                    if ($pourcentageA < 50.0) {
                        $ap = "A";
                    } else {
                        if ($counterGraves > 0) {
                            $ap = "A";
                        }else{
                            if ($pourcentageA <= 100.0 AND $counterManque > 0) {
                                $ap = "AA";
                            }
                            if ($pourcentageA >= 50.0 AND $pourcentageA <= 69.99) {
                                if ($counterLegers < 1) {
                                    $ap = "S";
                                } else {
                                    if ($counterLegers == 1 AND $pourcentageA <= 54.99) {
                                        $ap = "S";
                                    }
                                    if ($counterLegers <= 2 AND $pourcentageA >= 55.0 AND $pourcentageA <=59.99) {
                                        $ap = "S";
                                    }
                                    if ($counterLegers <= 3 AND $pourcentageA >= 60.0 AND $pourcentageA <=69.99) {
                                        $ap = "S";
                                    }                     
                                }                    
                            } else {
                                if ($pourcentageA <= 100.0) {
                                    if ($pourcentageA <= 89.99) {
                                        if ($pourcentageA <= 79.99) {
                                            $ap = "D";
                                        }else{
                                            $ap = "GD";
                                        }                        
                                    } else {
                                        $ap = "PGD";
                                    }                        
                                } 
            
                            } 
                        }
                        
                    }            
                }
            }
        } else {
            $pourcentageA = "";
            $ap = "AA";
        }

    }
    

    //Lien vue - controleur
    require "vue/pages/deliberation.php";
}

function promotion(){
    $msg = "";
    $_SESSION['promotion'] = (int) $_GET['promotion'];
    //Données enseignants
    $dataEnseignant = getEnseignantSectionList($_SESSION['id']);

    //Données UE
    $dataUE = getUEs($_SESSION['id'], (int) $_GET['promotion']);

    //Données ECS
    $dataEC = getMatieresByPromo((int) $_GET['promotion']);

    if(isset($_POST['addCours'])){
        if (isset($_POST['cours-intitule']) AND !empty($_POST['cours-intitule']) AND isset($_POST['cours-code']) AND !empty($_POST['cours-code']) AND isset($_POST['cours-credit']) AND !empty($_POST['cours-credit']) AND isset($_POST['cours-semestre']) AND !empty($_POST['cours-semestre']) AND isset($_POST['cours-unite']) AND !empty($_POST['cours-unite'])) {
            $data = array(
                "intitule" => $_POST['cours-intitule'],
                "code" => $_POST['cours-code'],
                "credit" => $_POST['cours-credit'],
                "semestre" => $_POST['cours-semestre'],
                "unite" => $_POST['cours-unite']
            );
            if(addECS($data)){
                $msg = "Le cours a bien été ajouté...";
                header("location:index.php?promotion=" . $_GET['promotion']);
            } else {
                $msg = "Un problème est survu lors de l'ajout du cours...";
            }
        } else {
            $msg = "Veuillez remplir tous les champs svp...";
        }        
    }

    //Lien vue - controleur
    require "vue/pages/promotion.php";
}

function finance(){
    $dataSection = getPromotionsList($_SESSION['infoSection']);
    $currentSection = getCurrentSection($_SESSION['infoSection']);
    $listStudentRCurrentSection = getAllStudenRtCurrentSection($_SESSION['infoSection'], (int) $_GET['col']);
    $listStudentICurrentSection = getAllStudenItCurrentSection($_SESSION['infoSection'], (int) $_GET['col']);
    //Lien vue - controleur
    require "vue/pages/comger.php";
}
//Page d'erreur
function erreur($msgErreur){
	//Lien vue - controleur
	require "vue/pages/erreur.php";
}