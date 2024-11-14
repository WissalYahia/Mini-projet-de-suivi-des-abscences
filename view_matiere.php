<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>View Subjects</title>
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
            margin-top:40px;
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
                    <a class="nav-link active" aria-current="page" href="Liste_absence.php">Liste des abscence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="view_etudiants.php">Etudiants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="view_enseignant.php">Enseignants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_matiere.php">Matières</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>
<h2>Liste des matières</h2>

<div class="table-container">
        
        <a href="create_matiere.php" class="btn btn-light add-student-btn">Ajouter matière</a>
    <table class="table table-hover">
    
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>nb heures par week</th>
                <th>heures td par week</th>
                <th>heures tp par week</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('C_Matiere.php');

            $matiere = new Matiere('1', 'Mathematics', '4', '2', '1');
            $subjects = $matiere->readMatiereList();

            foreach ($subjects as $subject) {
                echo "<tr>";
                echo "<td>{$subject['CodeMatiere']}</td>";
                echo "<td>{$subject['NomMatiere']}</td>";
                echo "<td>{$subject['NbreHeureCoursParSemaine']}</td>";
                echo "<td>{$subject['NbreHeureTDParSemaine']}</td>";
                echo "<td>{$subject['NbreHeureTPParSemaine']}</td>";
                echo "<td><a href='create_matiere.php?id=" . $subject["CodeMatiere"] . "'>Modifier</a></td>";
                echo "<td><a href='delete_matiere.php?id=" . $subject["CodeMatiere"] . "'>Supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
        </div>

</body>
</html>
