<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>View Teachers</title>
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
            padding-top:50px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            position: relative;
        }

        .add-teacher-btn {
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
<h2>Liste d'enseignants</h2>
<div class="table-container">
    
    <a href="create_enseignant.php" class="btn btn-light add-teacher-btn">ajouter Enseignant</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>DateRecrutement</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Code Department</th>
                <th>Code Grade</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('C_Enseignant.php');

            $teachers = new Enseignant(
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
            $teachers = $teachers->readEnseignantList();

            foreach ($teachers as $teacher) {
                echo "<tr>";
                echo "<td>{$teacher['CodeEnseignant']}</td>";
                echo "<td>{$teacher['Nom']}</td>";
                echo "<td>{$teacher['Prenom']}</td>";
                echo "<td>{$teacher['DateRecrutement']}</td>";
                echo "<td>{$teacher['Adresse']}</td>";
                echo "<td>{$teacher['Mail']}</td>";
                echo "<td>{$teacher['Tel']}</td>";
                echo "<td>{$teacher['CodeDepartement']}</td>";
                echo "<td>{$teacher['CodeGrade']}</td>";
                echo "<td><a href='create_enseignant.php?id=" . $teacher["CodeEnseignant"] . "'>Modifier</a></td>";
                echo "<td><a href='delete_enseignant.php?id=" . $teacher["CodeEnseignant"] . "'>Supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
