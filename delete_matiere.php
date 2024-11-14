<?php
require_once('C_Matiere.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $Matiere = new Matiere(
            '',
            '',
            '',
            '',
            ''
        );  
        $Matiere->deleteMatiere($id);

        header("Location: view_matiere.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Please provide a student ID for deletion.";
}
?>
