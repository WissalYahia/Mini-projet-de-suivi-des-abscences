<?php
    require_once('C_Classe.php');
    $classe = new Classe();
    $classes = $classe->listclasse();
?>

<html>
    <head>
        <title>List of absences</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
        body {
            background-color:#F5F5DC;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .navbar {
            background-color: #000 !important;
            width: 100%;
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }

        .form-container {
            width: 85%;
           
            background-color: #fff;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-left: 50px;
            margin-right:50px;
            margin-top:  20px;
            color: #000;
        }

        .form-control, .form-select, .btn-light {
            width: 100%;
            margin-bottom: 15px;
        }

        h2 {
            text-align: center;
            color: #000;
        }

        .form-label {
            color: #000;
        }

        .table-container {
            width: 85%;
            
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            color: #000;
        }

        .table {
            margin-top: 20px;
        }
    </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Suivi des abscences</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Liste_absence.php">Absences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="view_etudiants.php">
                           Etudiants
                        </a>
                        
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active" href="view_enseignant.php">
                            Enseignants
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="view_matiere.php">
                            Matières
                        </a>
                    
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <div class="form-container">
    <h2>Les informations nécessaires</h2>
        <form action="Liste_absence.php" method="post">
            
            <p class="form-label">Date de début <input type="date" class="form-control" name="dd"> Date fin <input type="date" class="form-control" name="df"></p>
            <p class="form-label">Classe
                <select name="classe" class="form-select">
                    <?php
                        while ($row = $classes->fetch_assoc()) {
                            echo "<option value='" . $row['NomClasse'] . "'>" . $row['NomClasse'] . "</option>";
                        }
                    ?> 
                </select>  
            </p>
            <p class="form-label">Nom de l'étudiant<input type="text" class="form-control" class="form-select" name="nom">Prénom de l'étudiant<input class="form-control" type="text" name="prenom"></p>
            <p><button type="submit" class="btn btn-light" name="submit">Chercher</button></p>
        </form>
                    </div>
                    <div class="table-container">
        <h2>Liste d'abscences</h2>
            <?php
                    require_once('C_Stat.php');
                    $liste = new Stat();
                
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                        $nomEtudiant = $_POST['nom'];
                        $prenomEtudiant= $_POST['prenom'];
                        $dateDebut = $_POST['dd'];
                        $dateFin = $_POST['df'];
                        $nomClass = $_POST['classe'];
                
                        $liste->Liste_abscence_etudiant($nomEtudiant, $prenomEtudiant, $dateDebut, $dateFin, $nomClass);
                    }     
            ?>
            </div>
            
    </body>
</html>
