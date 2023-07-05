<?php
//Déclaration session 
session_start();

//Inmport back - controleur
require "controleur/php/controleur.php";

//Prépare erreur
try{
	if (isset($_GET['deconnexion'])) {
				
		//Déconnexion 
		$_SESSION = array();
		session_destroy();

		//Formulaire de connexion
		header("Location:index.php");

	}elseif(isset($_SESSION['id'])){
		
		if (isset($_GET['erreur'])) {
			//Profile utilisateur
			erreur($_GET['erreur']);

		} elseif (isset($_GET['promotion'])) {
			//Gestion promotion
			$_SESSION['promotion'] = (int) $_GET['promotion'];
			promotion();
		} elseif (isset($_GET['fiche'])) {
			//Gestion cotes
			$_SESSION['promotion'] = (int) $_GET['fiche'];
			fichesCotation();
		} elseif (isset($_GET['grille'])) {
			if (isset($_GET['deliberation'])) {
				//Gestion deliberation
				deliberation((int) $_GET['deliberation'], (int) $_GET['grille']);
			} elseif (isset($_GET['detail'])) {
				# code...
				detailleGrille();
			} else {
				//Gestion cotes
				grilleDeliberation();
			}
		} elseif (isset($_GET['section'])) {
			$_SESSION['infoSection'] = (int) $_GET['section'];
			$_SESSION['nom_section'] = (int) $_GET['section'];
			//Gestion cotes
			finance();
		} elseif (isset($_GET['releve'])) {
			//Gestion cotes
			if ($_GET['releve'] == 1) {
				bulletin(1);
			} elseif ($_GET['releve'] == 2) {
				bulletin(2);
			} else {
				erreur("Page Inexistant");
			}
		} elseif (isset($_GET['sgac'])) {
			//Gestion authorisation
			sgacd();
		} elseif (isset($_GET['printGrille'])) {
			# code...
			etatGrille();
		}elseif (isset($_GET['etudiants'])) {
			//Access etudiant
			accessEtudiant((int) $_GET['etudiants']);
		} elseif (isset($_GET['enseignants'])) {
			//Access etudiant
			accessEnseignant(); 
		} elseif (isset($_GET['resetEnseignants'])) {
			resetEnseignants();
		} elseif (isset($_GET['resetEtudiants'])) {
			resetEtudiants();
		} else {
			//Page d'acceuil
			dashboard();
		}	

	}else{
		if (isset($_GET['subscrib'])) {
			//Récupération du compte
			signin();

		} else {
			//Connexion au compte
			login();
		}		
	}
}catch(Exception $e){
	//Appel page erreur
	erreur($e->getMessage());
}