<?php

/* -- API-BASE DE DONNEES -- */
function getBdd(){
	//Instancie l'objet PDO associé
	$bdd = new PDO(
			'mysql:host=mysql-ista-gm.alwaysdata.net;dbname=ista-gm_bdd',
			'ista-gm_root',
			'mot2p@sse'
		);

	//renvoie de l'objet PDO associé
	return $bdd;
}

/* 
	-- SQL-CONNEXION -- 
*/

//ID ETUDIANTS
function getAllPromotions(){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT niveau.id, niveau.intitule
	FROM niveau
	");

	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getPromotions(){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT promotion.id, niveau.intitule, section.designation
	FROM promotion
	INNER JOIN niveau ON niveau.id = promotion.id_niveau
	INNER JOIN section ON section.id = promotion.id_section
	");

	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getAllEnseignant(){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT enseignant.nom, enseignant.post_nom, enseignant.prenom, enseignant.matricule, enseignant.statut, enseignant.id
	FROM enseignant");

	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

//AFFECTATION CODE D'ACCEES
function getAllStudents(){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT *
							FROM etudiant

	");

	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

//AFFECTATION CODE D'ACCEES
function getAllStudentsByPromo($id){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT etudiant.nom, etudiant.post_nom, etudiant.matricule, etudiant.id
						FROM (SELECT promotion.id
							FROM niveau
							INNER JOIN promotion ON promotion.id_niveau = niveau.id
							WHERE niveau.id = ?) AS dPromo
						INNER JOIN etudiant
						ON etudiant.id_promotion = dPromo.id
	");

	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getStudentsByPromo($id){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom,  etudiant.matricule, etudiant.id, etudiant.id_promotion
						FROM etudiant
						WHERE etudiant.id_promotion = ?
	");

	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}


//0.Inscription
function getEnseignantSignin($matricule){
	//Connexion BD
	$bdd = getBdd();
	
	//Verification code d'accés
	$req = $bdd -> prepare("SELECT mdp
		FROM enseignant
		WHERE matricule = ?
	");

	//Data utilisateur
	$req -> execute(array($matricule));

	//Data BD
	$data = $req -> fetch(PDO::FETCH_ASSOC);

	return 	$data['mdp'];

}
function getEtudiantSignin($matricule){
	//Connexion BD
	$bdd = getBdd();
	
	//Verification code d'accés
	$req = $bdd -> prepare("SELECT mdp
		FROM etudiant
		WHERE matricule = ?
	");

	//Data utilisateur
	$req -> execute(array($matricule));

	//Data BD
	$data = $req -> fetch(PDO::FETCH_ASSOC);

	return 	$data['mdp'];

}
function getStatutEtudiant($id){
	//Connexion BD
	$bdd = getBdd();
	
	//Verification code d'accés
	$req = $bdd -> prepare("SELECT statut, frais_academique, enrol_1, enrol_2
		FROM etudiant
		WHERE id = ?
	");

	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	$data = $req -> fetch(PDO::FETCH_ASSOC);

	return 	$data;

}

function getAdminSignin($matricule){
	//Connexion BD
	$bdd = getBdd();
	
	//Verification code d'accés
	$req = $bdd -> prepare("SELECT mdp
		FROM administration
		WHERE matricule = ?
	");

	//Data utilisateur
	$req -> execute(array($matricule));
	
	//Data BD
	$data = $req -> fetch(PDO::FETCH_ASSOC);

	return 	$data['mdp'];

}

function signinEnseignant($matricule, $mdp){
	//Connexion BD
	$bdd = getBdd();
	
	//Verification code d'accés
	$req = $bdd -> prepare("SELECT id
		FROM enseignant
		WHERE matricule = ?
	");

	//Data utilisateur
	$req -> execute(array($matricule));

	//Data BD
	$data = $req -> fetch(PDO::FETCH_ASSOC);

	if ($data['mdp']) {
		return false;
	} else {

		//Enregistrement mot de passe utilisateur
		$req = $bdd -> prepare("UPDATE enseignant SET enseignant.mdp = ? WHERE matricule = ?");

		//Data utilisateur
		$req -> execute(array($mdp, $matricule));

		return true;
	}
}

function signinEtudiant($matricule, $mdp){
	//Connexion BD
	$bdd = getBdd();	
	
	//Verification code d'accés
	$req = $bdd -> prepare("SELECT id
		FROM etudiant
		WHERE matricule = ?
	");

	//Data utilisateur
	$req -> execute(array($matricule));

	//Data BD
	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Enregistrement mot de passe utilisateur
	$req = $bdd -> prepare("UPDATE etudiant SET etudiant.mdp = ? WHERE id = ?");

	//Data utilisateur
	$req -> execute(array($mdp, $data['id']));

	if($req){			
		//Generation bulletin
		$req = $bdd -> query("SELECT id
							FROM anne_acad
							ORDER BY id DESC
							LIMIT 0,1 
		");
		
		$anne = $req -> fetch(PDO::FETCH_ASSOC);
			
		//Generation bulletin
		$req = $bdd -> prepare("INSERT INTO releve(id_etudiant, num_ref, id_annee) VALUES (?, ?, ?)");

		//Data utilisateur
		$req -> execute(array($data['id'], time(), $anne['id']));

		return true;
	}
}

function signinAdmin($matricule, $mdp){
	//Connexion BD
	$bdd = getBdd();
	
	//Verification code d'accés
	$req = $bdd -> prepare("SELECT id
		FROM administration
		WHERE matricule = ?
	");

	//Data utilisateur
	$req -> execute(array($matricule));

	//Data BD
	$data = $req -> fetch(PDO::FETCH_ASSOC);

	if ($data['id']) {

		//Enregistrement mot de passe utilisateur
		$req = $bdd -> prepare("UPDATE administration SET administration.mdp = ? WHERE id = ?");

		//Data utilisateur
		$req -> execute(array($mdp, $data['id']));

		return true;

	} else {
		return false;
	}
}

//1. Authentification
function authEnseignant($data, $mdp){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT *
		FROM enseignant
		WHERE matricule = ? AND mdp =?
	");

	//Data utilisateur
	$req -> execute(array($data, $mdp));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function authJury($data, $mdp){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT jury.id, jury.designation, jury.mdp, jury.id_sec, jury.statut
		FROM enseignant
        INNER JOIN jury
        ON enseignant.id = jury.id_sec
		WHERE jury.mdp = ? AND matricule=?
	");

	//Data utilisateur
	$req -> execute(array($mdp, $data));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getJury($id){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT dJury.id, dJury.designation, dJury.president, CONCAT(enseignant.grade, ' ', enseignant.nom, ' ', enseignant.post_nom)  AS 'secretaire'
							FROM (SELECT jury.id, jury.designation, CONCAT(enseignant.grade, ' ', enseignant.nom, ' ', enseignant.post_nom)  AS 'president', jury.id_sec
									FROM jury
									INNER JOIN enseignant ON enseignant.id = jury.id_president
									WHERE jury.id = ?) AS dJury
							INNER JOIN enseignant ON enseignant.id = dJury.id_sec
	");

	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}


function authSection($data, $mdp){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT section.id, section.designation, section.description, section.logo, section.id_president, enseignant.nom, enseignant.post_nom, enseignant.prenom, enseignant.sexe, enseignant.grade
		FROM enseignant
        INNER JOIN section
        ON enseignant.id = section.id_secretaire
		WHERE matricule = ? AND mdp=?
	");

	//Data utilisateur
	$req -> execute(array($data, $mdp));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function authComger($data, $mdp){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT *
		FROM administration
		WHERE matricule = ? AND mdp=?
	");

	//Data utilisateur
	$req -> execute(array($data, $mdp));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function authEtudiant($data, $mdp){
	//Connexion BD
	$bdd = getBdd();

	//Authentification
	$req = $bdd -> prepare("SELECT *
		FROM etudiant
		WHERE matricule = ? AND mdp=?
	");

	//Data utilisateur
	$req -> execute(array($data, $mdp));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

//2. Dashboard Section
function getEffectifSection($section){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS effectif
                    FROM (SELECT promotion.id_section
                        FROM etudiant
                        INNER JOIN promotion
                        ON etudiant.id_promotion = promotion.id ) AS listEtudiant
                    INNER JOIN section
                    ON section.id = listEtudiant.id_section
                    WHERE listEtudiant.id_section = ?
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getEnseignantSection($section){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS effectif
                    FROM enseignant
                    INNER JOIN section
                    ON section.id = enseignant.id_section
                    WHERE section.id = ?
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getECSection($section){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS effectif
                            FROM (
                                SELECT enseignant.id_section
                                FROM matiere
                                INNER JOIN enseignant
                                ON matiere.id_titulaire = enseignant.id
                            ) AS list
                            INNER JOIN section
                            ON section.id = list.id_section
                            WHERE section.id = ?
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getChefSection($section){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT nom, post_nom, prenom, grade
                            FROM enseignant
                            INNER JOIN section
                            ON enseignant.id = section.id_president
                            WHERE section.id = ?
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getPromoSection($section){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS total
                            FROM promotion
                            INNER JOIN section
                            ON promotion.id_section = section.id
                            WHERE section.id = ?
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getEffectifM($section){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS total
                            FROM (SELECT id
                            	FROM etudiant
                            	WHERE sexe='M') AS list
    ");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getEffectifF($section){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS total
                            FROM (SELECT id
                            	FROM etudiant
                            	WHERE sexe='F') AS list
    ");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getStatSection($section){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT promo, effectif, credits, niveau.intitule AS nom_promo
					FROM (SELECT effectif, SUM(credit) AS credits, promo, niv
					    FROM (SELECT effectif, unite.designation, unite.id, promo, niv
					        FROM (SELECT COUNT(*) AS effectif, promo, niv
					            FROM (
					                SELECT promotion.id AS promo, promotion.id_niveau AS niv
					                FROM section
					                INNER JOIN promotion
					                ON section.id = promotion.id_section
					                WHERE section.id = ?) AS class
					            INNER JOIN etudiant
					            ON class.promo = etudiant.id_promotion
					            GROUP BY niv) AS detailPromo
					        LEFT JOIN unite
					        ON unite.id_promotion = detailPromo.promo) AS uniteDetail
					    INNER JOIN matiere
					    ON uniteDetail.id = matiere.id_unite
					    GROUP BY niv) AS resultatDetail
					INNER JOIN niveau
					ON niveau.id = resultatDetail.niv
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getPromotionsList($section){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT niveau.intitule AS class, promo
					FROM (
					    SELECT promotion.id AS promo, promotion.id_niveau
					    FROM promotion
					    INNER JOIN section
					    ON promotion.id_section = section.id
					    WHERE section.id = ?) AS detailClass
					INNER JOIN niveau
					ON detailClass.id_niveau = niveau.id
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getUEs($session, $promotion){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT unite.id, unite.designation, unite.code
						FROM unite
						INNER JOIN promotion
						ON unite.id_promotion = promotion.id
						WHERE promotion.id_section = ? AND promotion.id = ?
					");

	//Data utilisateur
	$req -> execute(array($session, $promotion));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function addUE($promotion, $designation, $code){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("INSERT INTO unite(designation, id_promotion, code) VALUES (?, ?, ?)
					");

	//Data utilisateur
	$req -> execute(array($designation, $promotion, $code));

	//Data BD
	return "Unité d'enseignement ajouté";
}


function getDetailUE($ue){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT unite.designation, unite.code, SUM(matiere.credit) AS credits, COUNT(matiere.id) AS ecs
							FROM unite
							INNER JOIN matiere
							ON unite.id = matiere.id_unite
							WHERE unite.id=?
	");

	//Data utilisateur
	$req -> execute(array($ue));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function deleteUE($unite){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("DELETE FROM unite WHERE id=?");

	//Data utilisateur
	$req -> execute(array($unite));

	//Data BD
	return "Unité d'enseignement supprimé";
}


function getEnseignant($promotion){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT titulaire, grade, nom, prenom, post_nom, matricule, statut
FROM (
    SELECT enseignant.id AS titulaire, enseignant.statut, enseignant.grade, enseignant.nom, enseignant.post_nom, enseignant.prenom, enseignant.matricule, matiere.id_unite
    FROM enseignant
    INNER JOIN matiere
    ON enseignant.id = matiere.id_titulaire) AS detailCours
INNER JOIN unite
ON unite.id = detailCours.id_unite
WHERE unite.id_promotion=?
GROUP BY nom
	");

	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}


function deleteEnseignant($enseignant){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("DELETE FROM enseignant WHERE id=?");

	//Data utilisateur
	$req -> execute(array($enseignant));

	//Data BD
	return "Enseignant supprimé";
}

function addEnseignant($data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("INSERT INTO enseignant(nom, post_nom, prenom, sexe, matricule, grade, statut, id_section) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

	//Data utilisateur
	$req -> execute(array($data['nom'], $data['post_nom'], $data['prenom'], $data['sexe'], $data['matricule'], $data['grade'], $data['statut'], $data['section']));

	//Data BD
	return TRUE;
}

function updateEnseignant($data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE enseignant SET matricule = ?, mdp = '' WHERE id = ?");

	//Data utilisateur
	$req -> execute(array($data['matricule'], $data['id']));

	//Data BD
	return TRUE;
}

function updateEtudiant($data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE etudiant SET matricule = ?, mdp = '' WHERE id = ?");

	//Data utilisateur
	$req -> execute(array($data['matricule'], $data['id']));

	//Data BD
	return TRUE;
}


function addStud($data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("INSERT INTO etudiant(nom, post_nom, matricule, sexe, id_promotion, nationalite, origine) VALUES (?,?,?,?,?,?,?)");

	//Data utilisateur
	$req -> execute(array($data['nom'], $data['post_nom'], $data['matricule'], $data['sexe'], $data['promotion'], $data['nationalite'], $data['origine']));

	//Data BD
	return TRUE;
}

function addECS($data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("INSERT INTO matiere(intitue, credit, id_unite, code, semestre) VALUES (?,?,?,?,?)");

	//Data utilisateur
	$req -> execute(array($data['intitule'], $data['credit'], $data['unite'], $data['code'], $data['semestre']));

	//Data BD
	return TRUE;
}

function updateECS($data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE matiere SET id_titulaire=? WHERE id=?");

	//Data utilisateur
	$req -> execute(array($data['titulaire'], $data['id']));

	//Data BD
	return TRUE;
}

function getEnseignantSectionList($section){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT id, grade, nom, post_nom, matricule
							FROM enseignant
					");

	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}



function getStudentsTitulaire($titulaire){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(id_etudiant) AS total
    FROM (
        SELECT matiere.id AS cours
        FROM matiere
        INNER JOIN enseignant
        ON enseignant.id = matiere.id_titulaire
		WHERE enseignant.id=?) AS detailTitulaire
    INNER JOIN fiche_cotation
    ON fiche_cotation.id_matiere = detailTitulaire.cours
					");

	//Data utilisateur
	$req -> execute(array($titulaire));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getCreditsTitulaire($titulaire){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT SUM(matiere.credit) AS total
						FROM matiere
						INNER JOIN enseignant
						ON matiere.id_titulaire = enseignant.id
						WHERE enseignant.id = ?
					");

	//Data utilisateur
	$req -> execute(array($titulaire));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getPromosTitulaire($titulaire){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(unite.id_promotion) AS total
							FROM (
								SELECT matiere.id_unite
								FROM matiere
								INNER JOIN enseignant
								ON matiere.id_titulaire = enseignant.id
								WHERE enseignant.id=?)AS detailTitulaire
							INNER JOIN unite
							ON detailTitulaire.id_unite = unite.id
					");

	//Data utilisateur
	$req -> execute(array($titulaire));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getPromosListTitulaire($titulaire){
    
	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT dUnite.id_promotion AS id, matiere.intitue AS intitule, dUnite.class, matiere.id AS id_matiere
	FROM (
		SELECT unite.id_promotion, dPromo.intitule AS class, unite.id, unite.code
		FROM(
			SELECT niveau.intitule, promotion.id
			FROM niveau
			INNER JOIN promotion
			ON niveau.id = promotion.id_niveau
		) AS dPromo
		INNER JOIN unite ON unite.id_promotion = dPromo.id
	) AS dUnite
	INNER JOIN matiere
	ON dUnite.id = matiere.id_unite
	WHERE matiere.id_titulaire=?
					");

	//Data utilisateur
	$req -> execute(array($titulaire));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getStatTitulaire($titulaire){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT dUnite.id_promotion AS promo, matiere.intitue AS nom_promo, dUnite.class, dUnite.code AS effectif, matiere.credit AS credits, matiere.id AS ref
	FROM (
		SELECT unite.id_promotion, dPromo.intitule AS class, unite.id, unite.code
		FROM(
			SELECT niveau.intitule, promotion.id
			FROM niveau
			INNER JOIN promotion
			ON niveau.id = promotion.id_niveau
		) AS dPromo
		INNER JOIN unite ON unite.id_promotion = dPromo.id
	) AS dUnite
	INNER JOIN matiere
	ON dUnite.id = matiere.id_unite
	WHERE matiere.id_titulaire=?
    ");
    
	//Data utilisateur
	$req -> execute(array($titulaire));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getEffectifJury($jury){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(etudiant.id) AS total
    FROM(SELECT promotion.id
        FROM (SELECT section.id
            FROM section
            INNER JOIN jury
            ON jury.id = section.id_jury
             WHERE jury.id = ?) AS detailSection
        INNER JOIN promotion
        ON detailSection.id = promotion.id_section) AS detailPromo
    INNER JOIN etudiant
    ON etudiant.id_promotion = detailPromo.id
    ");
    
	//Data utilisateur
	$req -> execute(array($jury));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getECsJury($jury){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(matiere.id) AS total
	FROM (SELECT unite.id
		FROM (
			SELECT promotion.id
			FROM promotion
			INNER JOIN section
			ON promotion.id_section = section.id
			WHERE section.id_jury = ?) AS detailPromo
		INNER JOIN unite
		ON detailPromo.id = unite.id_promotion) AS detailUnite
	INNER JOIN matiere
	ON matiere.id_unite = detailUnite.id
    ");
    
	//Data utilisateur
	$req -> execute(array($jury));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getPromosJury($jury){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(promotion.id) AS total
        FROM (SELECT section.id
            FROM section
            INNER JOIN jury
            ON jury.id = section.id_jury
             WHERE jury.id = ?) AS detailSection
        INNER JOIN promotion
        ON detailSection.id = promotion.id_section
    ");
    
	//Data utilisateur
	$req -> execute(array($jury));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}


function getPresJury($jury){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT enseignant.nom, enseignant.post_nom, enseignant.prenom, enseignant.matricule, enseignant.grade
	FROM enseignant
	INNER JOIN section
	ON enseignant.id_section = section.id
	WHERE enseignant.id = section.id_president AND section.id_jury=?
    ");
    
	//Data utilisateur
	$req -> execute(array($jury));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getStatJury($section){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT promo, effectif, credits, niveau.intitule AS nom_promo
					FROM (SELECT effectif, SUM(credit) AS credits, promo, niv
					    FROM (SELECT effectif, unite.designation, unite.id, promo, niv
					        FROM (SELECT COUNT(*) AS effectif, promo, niv
					            FROM (
					                SELECT promotion.id AS promo, promotion.id_niveau AS niv
					                FROM section
					                INNER JOIN promotion
					                ON section.id = promotion.id_section
					                WHERE section.id_jury = ?) AS class
					            INNER JOIN etudiant
					            ON class.promo = etudiant.id_promotion
					            GROUP BY niv) AS detailPromo
					        LEFT JOIN unite
					        ON unite.id_promotion = detailPromo.promo) AS uniteDetail
					    INNER JOIN matiere
					    ON uniteDetail.id = matiere.id_unite
					    GROUP BY niv) AS resultatDetail
					INNER JOIN niveau
					ON niveau.id = resultatDetail.niv
    ");
    
	//Data utilisateur
	$req -> execute(array($section));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getGrilleList($jury){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT niveau.intitule AS class, promo
					FROM (
					    SELECT promotion.id AS promo, promotion.id_niveau
					    FROM promotion
					    INNER JOIN section
					    ON promotion.id_section = section.id
					    WHERE section.id_jury = ?) AS detailClass
					INNER JOIN niveau
					ON detailClass.id_niveau = niveau.id
    ");
    
	//Data utilisateur
	$req -> execute(array($jury));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getEnrol1(){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT SUM(Solde) AS total
	FROM (SELECT section.designation AS lblSection, SUM(dPromotion.montant) AS Solde
		FROM(
			SELECT etudiant.enrol_1 AS montant, promotion.id_section
			FROM etudiant
			INNER JOIN promotion
			ON etudiant.id_promotion = promotion.id) AS dPromotion
		INNER JOIN section
		ON section.id = dPromotion.id_section
		GROUP BY section.designation) AS finance
    ");
    
	//Data utilisateur
	$req -> execute();

	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Data BD
	return $data['total'];
}

function getEnrol2(){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT SUM(Solde) AS total
	FROM (SELECT section.designation AS lblSection, SUM(dPromotion.montant) AS Solde
		FROM(
			SELECT etudiant.enrol_2 AS montant, promotion.id_section
			FROM etudiant
			INNER JOIN promotion
			ON etudiant.id_promotion = promotion.id) AS dPromotion
		INNER JOIN section
		ON section.id = dPromotion.id_section
		GROUP BY section.designation) AS finance
    ");
    
	//Data utilisateur
	$req -> execute();

	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Data BD
	return $data['total'];
}

function getFraisAcad(){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT SUM(Solde) AS total
	FROM (SELECT section.designation AS lblSection, SUM(dPromotion.montant) AS Solde
		FROM(
			SELECT etudiant.frais_academique AS montant, promotion.id_section
			FROM etudiant
			INNER JOIN promotion
			ON etudiant.id_promotion = promotion.id) AS dPromotion
		INNER JOIN section
		ON section.id = dPromotion.id_section
		GROUP BY section.designation) AS finance
    ");
    
	//Data utilisateur
	$req -> execute();

	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Data BD
	return $data['total'];
}

function getStatComger(){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT section.designation AS lblSection, SUM(dPromotion.montant) AS Solde
	FROM(
		SELECT etudiant.frais_academique AS montant, promotion.id_section
		FROM etudiant
		INNER JOIN promotion
		ON etudiant.id_promotion = promotion.id) AS dPromotion
	INNER JOIN section
	ON section.id = dPromotion.id_section
	GROUP BY section.designation");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}


function getSectionList(){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT section.id, section.designation
							FROM section
	");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getTotAnuel($promotion){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT dPromo.totAnnuel AS total
	FROM (SELECT promotion.id_niveau, SUM(moyAn) AS totAnnuel
		FROM (SELECT matiere.intitue, matiere.credit, matiere.credit*10 AS moyAn, unite.id_promotion
			FROM matiere
			INNER JOIN unite
			ON matiere.id_unite = unite.id
			WHERE unite.id_promotion = ?) AS coursPromo
		INNER JOIN promotion
		ON coursPromo.id_promotion = promotion.id) AS dPromo
	INNER JOIN niveau
	ON niveau.id = dPromo.id_niveau
    ");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Data BD
	return $data['total'];
}

function getMoyAnuel($etudiant){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT fiche_cotation.id_etudiant, SUM((fiche_cotation.tp+fiche_cotation.td)*matiere.credit) AS moyAnnuel
	FROM fiche_cotation
	INNER JOIN matiere
	ON fiche_cotation.id_matiere = matiere.id
	WHERE fiche_cotation.id_etudiant = ?
	GROUP BY fiche_cotation.id_etudiant
    ");
    
	//Data utilisateur
	$req -> execute(array($etudiant));

	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Data BD
	return $data;
}

function getTotCredits($promotion){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT SUM(matiere.credit) AS totCredit
							FROM matiere
							INNER JOIN unite
							ON matiere.id_unite = unite.id
							WHERE unite.id_promotion = ?
    ");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Data BD
	return $data['totCredit'];
}

function getCreditsValide($promotion){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS creditValide
						FROM etudiant
						INNER JOIN fiche_cotation
						ON etudiant.id = fiche_cotation.id_etudiant
						WHERE etudiant.id = ?
    ");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	$data = $req -> fetch(PDO::FETCH_ASSOC);

	//Data BD
	return $data['creditValide'];
}

function getUnitesStudent($promotion){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT unite.id, unite.code, unite.designation
							FROM unite
							WHERE unite.id_promotion = ?
	");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getECsStudent($etudiant){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT fiche_cotation.tp, fiche_cotation.td, dCotes.intitule, dCotes.credit, dCotes.nom, dCotes.post_nom, dCotes.grade
						FROM (SELECT dCours.intitule, dCours.credit, dCours.nom, dCours.post_nom, dCours.grade, dCours.cours
							FROM (SELECT matiere.intitue AS intitule, enseignant.nom, enseignant.post_nom, enseignant.grade, matiere.credit, matiere.id_unite, matiere.id AS cours
								FROM matiere
								INNER JOIN enseignant
								ON matiere.id_titulaire = enseignant.id) AS dCours
							INNER JOIN unite
							ON dCours.id_unite = unite.id) AS dCotes
						INNER JOIN fiche_cotation
						ON fiche_cotation.id_matiere = dCotes.cours
						WHERE fiche_cotation.id_etudiant = ?
	");
    
	//Data utilisateur
	$req -> execute(array($etudiant));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getECsStudentById($unite, $etudiant){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT fiche_cotation.tp, fiche_cotation.td, dCotes.intitule, dCotes.credit, dCotes.nom, dCotes.post_nom, dCotes.grade
						FROM (SELECT dCours.intitule, dCours.credit, dCours.nom, dCours.post_nom, dCours.grade, dCours.cours
							FROM (SELECT matiere.intitue AS intitule, enseignant.nom, enseignant.post_nom, enseignant.grade, matiere.credit, matiere.id_unite, matiere.id AS cours
								FROM matiere
								INNER JOIN enseignant
								ON matiere.id_titulaire = enseignant.id) AS dCours
							INNER JOIN unite
							ON dCours.id_unite = unite.id
							WHERE unite.id = ?) AS dCotes
						INNER JOIN fiche_cotation
						ON fiche_cotation.id_matiere = dCotes.cours
						WHERE fiche_cotation.id_etudiant = ?
	");
    
	//Data utilisateur
	$req -> execute(array($unite, $etudiant));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function updateStudent($data, $student){	
    
	//Connexion BD
	$bdd = getBdd();

    //Données à mettre à jour
	foreach ($data as $key => $value) {
		# code...
		switch ($key) {
			case 'nom':
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE etudiant SET etudiant.nom=? WHERE etudiant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['nom'], $student));
				}
				break;
				
			case 'post_nom':
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE etudiant SET etudiant.post_nom=? WHERE etudiant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['post_nom'], $student));
				}
				break;
				
			case 'prenom':
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE etudiant SET etudiant.prenom=? WHERE etudiant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['prenom'], $student));
				}
				break;
			
			default:
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE etudiant SET etudiant.sexe=? WHERE etudiant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['sexe'], $student));
				}
				break;
		}
	}

	//Data BD
	return true;
}


function updateTeacher($data, $student){	
    
	//Connexion BD
	$bdd = getBdd();

    //Données à mettre à jour
	foreach ($data as $key => $value) {
		# code...
		switch ($key) {
			case 'nom':
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE enseignant SET enseignant.nom=? WHERE enseignant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['nom'], $student));
				}
				break;
				
			case 'post_nom':
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE enseignant SET enseignant.post_nom=? WHERE enseignant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['post_nom'], $student));
				}
				break;
				
			case 'prenom':
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE enseignant SET enseignant.prenom=? WHERE enseignant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['prenom'], $student));
				}
				break;
			
			default:
				if (!empty($value)) {
					$req = $bdd -> prepare("UPDATE enseignant SET enseignant.sexe=? WHERE enseignant.id=?
					");
					
					//Data utilisateur
					$req -> execute(array($data['sexe'], $student));
				}
				break;
		}
	}

	//Data BD
	return true;
}

function getPromotionEcs($grille){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT matiere.id, matiere.intitue AS intitule
							FROM matiere
							INNER JOIN unite
							ON unite.id = matiere.id_unite
							WHERE unite.id_promotion=?
						
	");
    
	//Data utilisateur
	$req -> execute(array($grille));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getTitEcs($titulaire, $promotion, $matiere){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT detEC.id, detEC.intitule, detEC.credit, unite.designation, (20*detEC.credit) AS maximum, detEC.semestre
						FROM (SELECT matiere.id, matiere.intitue AS intitule, matiere.id_unite, matiere.credit, matiere.semestre
							FROM matiere
							INNER JOIN enseignant
							ON matiere.id_titulaire = enseignant.id
							WHERE enseignant.id = ?) AS detEC
						INNER JOIN unite
						ON unite.id = detEC.id_unite
						WHERE unite.id_promotion=? AND detEC.id = ?
	");
    
	//Data utilisateur
	$req -> execute(array($titulaire, $promotion, $matiere));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getFicheCotationListJury($promotion){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT * FROM etudiant WHERE id_promotion=? WHERE frais_a
	");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function infoPromotion($promotion){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT dPromo.intitule AS 'niveau', section.designation AS 'section', dPromo.systeme
	FROM (
		SELECT niveau.intitule, promotion.id_section, systeme.designation AS 'systeme'
		FROM niveau
		INNER JOIN promotion ON niveau.id = promotion.id_niveau
        INNER JOIN systeme ON systeme.id = niveau.id_systeme
		WHERE promotion.id = ?) AS dPromo
	INNER JOIN section
	ON section.id = dPromo.id_section");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}

function getFicheCotationList($promotion){	
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT * FROM etudiant WHERE id_promotion=?
	");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getFicheCotationListKeyword($promotion, $keyword){	
    
	//Connexion BD
	$bdd = getBdd();

	$pattern = "%". $keyword . "%";

	$sql = "SELECT * FROM etudiant WHERE id_promotion= :promotion AND etudiant.nom LIKE :pattern OR etudiant.post_nom LIKE :pattern OR etudiant.prenom LIKE :pattern OR etudiant.matricule LIKE :pattern";

    //Effectif Section
	$req = $bdd -> prepare($sql);

	$req -> execute([':promotion' => $promotion, ':pattern'=>$pattern]);

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getCoteEtudiant($etudiant, $matiere){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT * 
						FROM fiche_cotation
						WHERE fiche_cotation.id_etudiant = ? AND id_matiere=?
	");
    
	//Data utilisateur
	$req -> execute(array($etudiant,$matiere));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}

function getCoteEtudiantTD($etudiant, $matiere){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT * 
						FROM fiche_cotation
						INNER JOIN etudiant
						ON fiche_cotation.id_etudiant= etudiant.id
						WHERE fiche_cotation.id_etudiant = ? AND id_matiere=?
	");
    
	//Data utilisateur
	$req -> execute(array($etudiant,$matiere));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}

function updateCoteEtudiantExamen($etudiant, $matiere, $cote){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("UPDATE fiche_cotation SET examen=? WHERE fiche_cotation.id_etudiant = ? AND id_matiere=?
	");
    
	//Data utilisateur
	$req -> execute(array($cote, $etudiant, $matiere));

	//Data BD
	return TRUE;

}

function updateCoteEtudiantTD($etudiant, $matiere, $cote){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("UPDATE fiche_cotation SET td=? WHERE fiche_cotation.id_etudiant = ? AND id_matiere=?
	");
    
	//Data utilisateur
	$req -> execute(array($cote, $etudiant, $matiere));

	//Data BD
	return TRUE;

}

function updateCoteEtudiantTP($etudiant, $matiere, $cote){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("UPDATE fiche_cotation SET tp=? WHERE fiche_cotation.id_etudiant = ? AND id_matiere=?
	");
    
	//Data utilisateur
	$req -> execute(array($cote, $etudiant, $matiere));

	//Data BD
	return TRUE;

}

function setCoteEtudiant($etudiant, $matiere, $coteTD, $coteTP){
    
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("INSERT INTO fiche_cotation(id_etudiant, id_matiere, tp, td) VALUES (?, ?, ?, ?)");
    
	//Data utilisateur
	$req -> execute(array($etudiant, $matiere, $coteTP, $coteTD));

	//Data BD
	return TRUE;

}

function getCurrentSection($id){	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT section.designation
							FROM section
							WHERE section.id = ?
	");
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}

function getAllStudenItCurrentSection($id, $rubrique){	//Connexion BD
	$bdd = getBdd();

    //Liste Etudiant Section
	switch ($rubrique) {
		case 1:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.frais_academique AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.frais_academique
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.frais_academique < 500000
			");
			break;
		
		case 2:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.enrol_1 AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.enrol_1
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.enrol_1 < 25000
			");
			break;
		default:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.enrol_2 AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.enrol_2
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.enrol_2 < 25000
			");
			break;
	}
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);

}

function getAllStudenRtCurrentSection($id, $rubrique){	//Connexion BD
	$bdd = getBdd();

    //Liste Etudiant Section
	switch ($rubrique) {
		case 1:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.frais_academique AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.frais_academique
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.frais_academique = 500000
			");
			break;
		
		case 2:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.enrol_1 AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.enrol_1
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.enrol_1 = 25000
			");
			break;
		default:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.enrol_2 AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.enrol_2
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.enrol_2 = 25000
			");
			break;
	}
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);

}


function getAllStudenRtCurrentSectionByWord($id, $rubrique, $keyword){	
	

	$pattern = "%". $keyword . "%";

	//Connexion BD
	$bdd = getBdd();

    //Liste Etudiant Section
	switch ($rubrique) {
		case 1:

			$sql = "SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.frais_academique AS solde
			FROM (
				SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.frais_academique
				FROM etudiant
				INNER JOIN promotion
				ON etudiant.id_promotion = promotion.id
				WHERE promotion.id_section=:section) AS DEtudiant
			WHERE DEtudiant.frais_academique = 500000 AND DEtudiant.nom LIKE :pattern OR DEtudiant.post_nom LIKE :pattern OR DEtudiant.prenom LIKE :pattern OR DEtudiant.matricule LIKE :pattern";
			$req = $bdd -> prepare($sql);
			break;
		
		case 2:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.enrol_1 AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.enrol_1
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.enrol_1 = 25000
			");
			break;
		default:
			$req = $bdd -> prepare("SELECT DEtudiant.nom, DEtudiant.post_nom, DEtudiant.prenom, DEtudiant.matricule, DEtudiant.enrol_2 AS solde
									FROM (
										SELECT etudiant.id, etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.matricule, etudiant.enrol_2
										FROM etudiant
										INNER JOIN promotion
										ON etudiant.id_promotion = promotion.id
										WHERE promotion.id_section=?) AS DEtudiant
									WHERE DEtudiant.enrol_2 = 25000
			");
			break;
	}
    
	//Data utilisateur
	$req -> execute([':section' => $id, ':pattern'=>$pattern]);

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);

}
function updateFinEtudiant($id, $rubrique){	//Connexion BD
	$bdd = getBdd();

    //Liste Etudiant Section
	switch ($rubrique) {
		case 1:
			$req = $bdd -> prepare("UPDATE etudiant SET etudiant.frais_academique = 500000 WHERE etudiant.matricule = ?");
			break;
		
		case 2:
			$req = $bdd -> prepare("UPDATE etudiant SET etudiant.enrol_1 = 25000 WHERE etudiant.matricule = ?");
			break;
		default:			
			$req = $bdd -> prepare("UPDATE etudiant SET etudiant.enrol_2 = 25000 WHERE etudiant.matricule = ?");
			break;
	}
    
	//Data utilisateur
	$req -> execute(array($id));

	
	$req = $bdd -> prepare("UPDATE etudiant SET etudiant.statut = 1 WHERE etudiant.matricule = ? AND etudiant.frais_academique=500000 AND etudiant.enrol_1 = 25000 AND etudiant.enrol_2 = 25000");	
	
	$req -> execute(array($id));
	//Data BD
	return TRUE;

}

function getAuthorisation(){	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT authentification.statut, authentification.access 
							FROM authentification
							WHERE authentification.departement = 'jury'");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}

function getAuthorisationTit(){	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT authentification.statut
							FROM authentification
							WHERE authentification.departement = 'titulaire'");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}

function getAuthorisationForTit(){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT authentification.statut, authentification.access
							FROM authentification
							WHERE authentification.departement = 'titulaire'");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}

function getAuthorisationForJury(){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT authentification.statut, authentification.access
							FROM authentification
							WHERE authentification.departement = 'jury'");
    
	//Data utilisateur
	$req -> execute();

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);

}


function getDetailsPromotion($id){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT dPromo.intitule, dPromo.lblSection, systeme.designation AS lblSysteme
							FROM (
								SELECT infoSection.id, infoSection.id_systeme, infoSection.lblSection, niveau.intitule
								FROM (
									SELECT promotion.id, promotion.id_niveau, promotion.id_systeme, section.designation AS lblSection
									FROM promotion
									INNER JOIN section ON promotion.id_section = section.id
									WHERE promotion.id=?) AS infoSection
								INNER JOIN niveau ON niveau.id = infoSection.id_niveau) AS dPromo
							INNER JOIN systeme ON systeme.id = dPromo.id_systeme
	");
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getDetailsReleve($id){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT anne_acad.debut, anne_acad.fin, releve.num_ref, releve.id
							FROM releve
							INNER JOIN anne_acad ON anne_acad.id = releve.id_annee
							WHERE id_etudiant=?
	");
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getAllCotes($promotion, $etudiant, $semestre){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT dCours.cours, fiche_cotation.tp, fiche_cotation.td, fiche_cotation.examen, dCours.credit, fiche_cotation.id_releve
						   FROM (SELECT matiere.intitue AS cours, matiere.credit, matiere.id
							   FROM matiere
							   INNER JOIN unite ON unite.id = matiere.id_unite
							   WHERE unite.id_promotion = ? AND semestre=?) AS dCours
						   LEFT JOIN fiche_cotation
						   ON dCours.id = fiche_cotation.id_matiere
						   WHERE fiche_cotation.id_etudiant=?
	");
    
	//Data utilisateur
	$req -> execute(array($promotion, $semestre, $etudiant));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getAllCotesJury($promotion, $etudiant){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT dCours.cours, fiche_cotation.tp, fiche_cotation.td, fiche_cotation.examen, dCours.credit, fiche_cotation.id_releve
						   FROM (SELECT matiere.intitue AS cours, matiere.credit, matiere.id
							   FROM matiere
							   INNER JOIN unite ON unite.id = matiere.id_unite
							   WHERE unite.id_promotion = ?) AS dCours
						   LEFT JOIN fiche_cotation
						   ON dCours.id = fiche_cotation.id_matiere
						   WHERE fiche_cotation.id_etudiant=?
	");
    
	//Data utilisateur
	$req -> execute(array($promotion, $etudiant));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getMatieresGrilleByPromo($promotion){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT matiere.intitue AS cours, matiere.credit, unite.id_promotion, matiere.id
							FROM matiere
							INNER JOIN unite ON unite.id = matiere.id_unite
							WHERE unite.id_promotion = ?
	");
    
	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);

}

function getCotesAllPromotionByMatiere($id){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT etudiant.nom, etudiant.post_nom, etudiant.prenom, etudiant.id, fiche_cotation.tp, fiche_cotation.td, fiche_cotation.examen
							FROM fiche_cotation
							LEFT JOIN etudiant ON fiche_cotation.id_etudiant = etudiant.id
							WHERE etudiant.id_promotion = ?
	");
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function updateStatutTitulaire(){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("UPDATE authentification SET statut='false' WHERE authentification.departement='titulaire'");
    $req -> execute();
	//Data BD
	return true;
}

function updateStatutJury(){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("UPDATE authentification SET statut='false' WHERE authentification.departement='jury'");
    $req -> execute();
	//Data BD
	return true;
}

function updateMdpJury($mdp){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("UPDATE authentification SET access=?, statut='true' WHERE authentification.departement='jury'");
    $req -> execute(array($mdp));
	//Data BD
	return true;
}

function updateMdpTitulaire($mdp){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("UPDATE authentification SET access=?, statut='true' WHERE authentification.departement='titulaire'");
    $req -> execute(array($mdp));
	//Data BD
	return true;
}

function getMatieresByPromo($id){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT matiere.id, matiere.intitue AS intitule, matiere.credit, matiere.code, unite.designation, matiere.semestre
							FROM matiere
							INNER JOIN unite ON unite.id = matiere.id_unite
							WHERE unite.id_promotion=?");
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);

}

function getMatieresByMatiere($id){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("SELECT matiere.id, matiere.intitue AS intitule, matiere.credit, matiere.code, unite.designation, matiere.semestre
							FROM matiere
							INNER JOIN unite ON unite.id = matiere.id_unite
							WHERE matiere.id=?");
    
	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);

}

function deleteMatiere($id){
	//Connexion BD
	$bdd = getBdd();

    //Effectif Section
	$req = $bdd -> prepare("DELETE FROM matiere WHERE id=?");
    
	$req -> execute(array($id));

	//Data BD
	return true;

}

function updateIntituleByMatiere($id, $data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE matiere SET intitue=? WHERE id=?");

	//Data utilisateur
	$req -> execute(array($id, $data));

	//Data BD
	return TRUE;
}

function updateCreditByMatiere($id, $data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE matiere SET credit=? WHERE id=?");

	//Data utilisateur
	$req -> execute(array($id, $data));

	//Data BD
	return TRUE;
}

function updateCodeByMatiere($id, $data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE matiere SET code=? WHERE id=?");

	//Data utilisateur
	$req -> execute(array($id, $data));

	//Data BD
	return TRUE;
}

function updateSemestreByMatiere($id, $data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE matiere SET semestre=? WHERE id=?");

	//Data utilisateur
	$req -> execute(array($id, $data));

	//Data BD
	return TRUE;
}

function updateUniteByMatiere($id, $data){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("UPDATE matiere SET id_unite=? WHERE id=?");

	//Data utilisateur
	$req -> execute(array($id, (int) $data));

	//Data BD
	return TRUE;
}

function getMaxByPromo($promotion){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT SUM(matiere.credit*20) AS Maximum
							FROM matiere
							INNER JOIN unite
							ON matiere.id_unite = unite.id
							WHERE unite.id_promotion=?
	");

	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getByObtPromo($promotion){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT dCote.id, dCote.nom, dCote.post_nom, SUM((dCote.tp+dCote.td+ dCote.examen)*matiere.credit) AS OBT
							FROM (SELECT etudiant.id, etudiant.nom, etudiant.post_nom, fiche_cotation.id_matiere, fiche_cotation.tp, fiche_cotation.td, fiche_cotation.examen 
								FROM etudiant 
								LEFT JOIN fiche_cotation 
								ON etudiant.id = fiche_cotation.id_etudiant 
								WHERE etudiant.id_promotion=?) AS dCote
							LEFT JOIN matiere
							ON dCote.id_matiere = matiere.id
							GROUP BY id
							ORDER BY OBT DESC
	");

	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetchAll(PDO::FETCH_ASSOC);
}

function getByObtEtudiant($id){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT dCote.id, dCote.nom, dCote.post_nom, SUM((dCote.tp+dCote.td+ dCote.examen)*matiere.credit) AS OBT
							FROM (SELECT etudiant.id, etudiant.nom, etudiant.post_nom, fiche_cotation.id_matiere, fiche_cotation.tp, fiche_cotation.td, fiche_cotation.examen 
								FROM etudiant 
								LEFT JOIN fiche_cotation 
								ON etudiant.id = fiche_cotation.id_etudiant 
								WHERE etudiant.id=?) AS dCote
							LEFT JOIN matiere
							ON dCote.id_matiere = matiere.id
							GROUP BY id
							ORDER BY OBT DESC
	");

	//Data utilisateur
	$req -> execute(array($id));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}

function getEffByPromo($promotion){

	//Connexion BD
	$bdd = getBdd();
    
    //Effectif Section
	$req = $bdd -> prepare("SELECT COUNT(*) AS participant 
							FROM etudiant 
							WHERE id_promotion = ?
	");

	//Data utilisateur
	$req -> execute(array($promotion));

	//Data BD
	return $req -> fetch(PDO::FETCH_ASSOC);
}