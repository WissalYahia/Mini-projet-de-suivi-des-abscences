<?php
require_once('C_Enseignant.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $enseignant = new Enseignant(
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
        $enseignant->deleteEnseignant($id);

        header("Location: view_enseignant.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Please provide an instructor ID for deletion.";
}

?>
