<?php

/* -- LIEN MODELE - CONTRÔLEUR -- */
require "../../modele/modele.php";

function items_etudiant(){
    $data = getAllAdmin();

    foreach ($data as $key => $value) {
        setAllAdmin($value['id'], "2023" . $key);
        echo "Matricule : 2023" . $key. "<br />";
    }

}

items_etudiant();