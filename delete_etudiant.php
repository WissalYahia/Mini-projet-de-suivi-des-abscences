<?php
require_once('C_Etudiant.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $etudiant = new Etudiant(
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        );  
        $etudiant->deleteEtudiant($id);

        header("Location: view_etudiants.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Please provide a student ID for deletion.";
}
?>
