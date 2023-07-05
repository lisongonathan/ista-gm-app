<?PHP
require "modele/modele.php";

function read($csv){
    $file = fopen($csv, 'r');
    while (!feof($file) ) {
        $line[] = fgetcsv($file, 1024);
    }
    fclose($file);
    return $line;
}

// Définir le chemin d'accès au fichier CSV
$csv = 'modele/PREPO.csv';

$csv = read($csv);

foreach ($csv as $key => $value) {
    echo "Nom : " . $value[0] . " Post Nom : " . $value[1] . " Sexe : " . $value[2] . " Nationalité : " . $value[3] . " Origine : " . $value[4] . " Matricule : " . $value[5] . " Promotion : " . $value[6] . "<br/>";
    $data = array(
        'nom' => $value[0], 
        'post_nom' => $value[1], 
        'matricule' => $value[5], 
        'sexe' => $value[2], 
        'promotion' => $value[6],
        'nationalite' => $value[3],
        'origine' => $value[4]
    );

    addStud($data);
    echo 'Ajouté ...<br/>';
}
$csv = 'modele/INFO.csv';

$csv = read($csv);

foreach ($csv as $key => $value) {
    echo "Nom : " . $value[0] . " Post Nom : " . $value[1] . " Sexe : " . $value[2] . " Nationalité : " . $value[3] . " Origine : " . $value[4] . " Matricule : " . $value[5] . " Promotion : " . $value[6] . "<br/>";
    $data = array(
        'nom' => $value[0], 
        'post_nom' => $value[1], 
        'matricule' => $value[5], 
        'sexe' => $value[2], 
        'promotion' => $value[6],
        'nationalite' => $value[3],
        'origine' => $value[4]
    );

    addStud($data);
    echo 'Ajouté ...<br/>';
}
$csv = 'modele/ETRI.csv';

$csv = read($csv);

foreach ($csv as $key => $value) {
    echo "Nom : " . $value[0] . " Post Nom : " . $value[1] . " Sexe : " . $value[2] . " Nationalité : " . $value[3] . " Origine : " . $value[4] . " Matricule : " . $value[5] . " Promotion : " . $value[6] . "<br/>";
    $data = array(
        'nom' => $value[0], 
        'post_nom' => $value[1], 
        'matricule' => $value[5], 
        'sexe' => $value[2], 
        'promotion' => $value[6],
        'nationalite' => $value[3],
        'origine' => $value[4]
    );

    addStud($data);
    echo 'Ajouté ...<br/>';
}
$csv = 'modele/MEC.csv';

$csv = read($csv);

foreach ($csv as $key => $value) {
    echo "Nom : " . $value[0] . " Post Nom : " . $value[1] . " Sexe : " . $value[2] . " Nationalité : " . $value[3] . " Origine : " . $value[4] . " Matricule : " . $value[5] . " Promotion : " . $value[6] . "<br/>";
    $data = array(
        'nom' => $value[0], 
        'post_nom' => $value[1], 
        'matricule' => $value[5], 
        'sexe' => $value[2], 
        'promotion' => $value[6],
        'nationalite' => $value[3],
        'origine' => $value[4]
    );

    addStud($data);
    echo 'Ajouté ...<br/>';
}
$csv = 'modele/ETRO.csv';

$csv = read($csv);

foreach ($csv as $key => $value) {
    echo "Nom : " . $value[0] . " Post Nom : " . $value[1] . " Sexe : " . $value[2] . " Nationalité : " . $value[3] . " Origine : " . $value[4] . " Matricule : " . $value[5] . " Promotion : " . $value[6] . "<br/>";
    $data = array(
        'nom' => $value[0], 
        'post_nom' => $value[1], 
        'matricule' => $value[5], 
        'sexe' => $value[2], 
        'promotion' => $value[6],
        'nationalite' => $value[3],
        'origine' => $value[4]
    );

    addStud($data);
    echo 'Ajouté ...<br/>';
}
$csv = 'modele/TELECOM.csv';

$csv = read($csv);

foreach ($csv as $key => $value) {
    echo "Nom : " . $value[0] . " Post Nom : " . $value[1] . " Sexe : " . $value[2] . " Nationalité : " . $value[3] . " Origine : " . $value[4] . " Matricule : " . $value[5] . " Promotion : " . $value[6] . "<br/>";
    $data = array(
        'nom' => $value[0], 
        'post_nom' => $value[1], 
        'matricule' => $value[5], 
        'sexe' => $value[2], 
        'promotion' => $value[6],
        'nationalite' => $value[3],
        'origine' => $value[4]
    );

    addStud($data);
    echo 'Ajouté ...<br/>';
}
?>