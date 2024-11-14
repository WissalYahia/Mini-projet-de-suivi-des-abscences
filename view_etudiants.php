<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #F5F5DC;
        }

        .navbar {
            background-color: #000 !important;
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #000;
        }

        .table-container {
            width: 100%;    
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            position: relative;
        }
        .table{
            margin-top:30px;
        }

        .add-student-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        th, td {
            text-align: center;
        }

        .btn {
            margin-right: 5px;
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
                        <a class="nav-link active" aria-current="page" href="Liste_absence.php">Liste Absence</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="view_etudiants.php">
                            Etudiants
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="view_enseignant.php" >
                            Enseignants
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_matiere.php"  >
                            Matières
                        </a>
                        
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <h2>Liste des étudiants</h2>
    <div class="table-container">
        
        <a href="create_etudiant.php" class="btn btn-light add-student-btn">Ajouter étudiant</a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>Date naissance</th>
                <th>code classe</th>
                <th>Numéro d'inscri</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Modifier</th>
                <th>Supprimer</th>
                <th>abscence</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    require_once('C_Etudiant.php');

                    $etudiant = new Etudiant(
                        
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        ''
                    );                    

                    $students = $etudiant->readEtudiantList();

                    foreach ($students as $student) {
                        echo "<tr>";
                        echo "<td>{$student['CodeEtudiant']}</td>";
                        echo "<td>{$student['Nom']}</td>";
                        echo "<td>{$student['Prenom']}</td>";
                        echo "<td>{$student['DateNaissance']}</td>";
                        echo "<td>{$student['CodeClasse']}</td>";
                        echo "<td>{$student['NumInscription']}</td>";
                        echo "<td>{$student['Adresse']}</td>";
                        echo "<td>{$student['Mail']}</td>";
                        echo "<td>{$student['Telephone']}</td>";
                        echo "<td><a href='create_etudiant.php?id=" . $student["CodeEtudiant"] . "'>Modifier</a></td>";
                        echo "<td><a href='delete_etudiant.php?id=" . $student["CodeEtudiant"] . "'>Supprimer</a></td>";
                        echo "<td><a href='mark_absence.php?id=" . $student["CodeEtudiant"] . "'>Marquer une abscence</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
