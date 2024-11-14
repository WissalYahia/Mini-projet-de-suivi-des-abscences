<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: authentification.php');
    exit();
}

require_once('Config.php');
$mysqli = new mysqli(db_host, db_user, db_password, db_database);

$givenDate = isset($_POST['absenceDate']) ? $_POST['absenceDate'] : null;
$resultMessage = '';
$students = array();

if ($givenDate) {
    $query = "SELECT
                  t_ficheabscence.DateJour,
                  t_etudiant.Nom AS StudentName,
                  t_etudiant.Prenom AS StudentPrename,
                  t_enseignant.Nom AS TeacherName,
                  t_matiere.NomMatiere AS SubjectName
              FROM
                  t_ficheabscence
                  JOIN t_enseignant ON t_ficheabscence.CodeEnseignant = t_enseignant.CodeEnseignant
                  JOIN t_matiere ON t_ficheabscence.CodeMatiere = t_matiere.CodeMatiere
                  JOIN t_ligneficheabscence ON t_ficheabscence.Codeficheabscence = t_ligneficheabscence.Codeficheabscence
                  JOIN t_etudiant ON t_ligneficheabscence.CodeEtudiant = t_etudiant.CodeEtudiant
              WHERE
                  t_ficheabscence.DateJour = ?";

    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $givenDate);

    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Absence Report</title>
    <style>
        body {
            background-color: #F5F5DC;
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

        .form-container{
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 70px;
            color: #000;

        }
        .table-container {
            width: 90%;
            
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 70px;
            color: #000;
        }

        .form-control, .btn {
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

        .table {
            margin-top: 20px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            color: #000;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Suivie des abscences</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="form-container">
    <h2>Admin</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="absenceDate" class="form-label">Choisir une date:</label>
        <input type="date" id="absenceDate" class="form-control" name="absenceDate" required><br>
        <button type="submit" class="btn btn-light">Afficher</button>
    </form>
</div>

<div class="table-container">
    <?php
    if (!empty($students)) {
        echo "<table class=\"table table-hover\">";
        echo "<tr><th>Date</th><th>Etudiant</th><th>Enseignant</th><th>Matière</th></tr>";
        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>{$student['DateJour']}</td>";
            echo "<td>{$student['StudentName']} {$student['StudentPrename']}</td>";
            echo "<td>{$student['TeacherName']}</td>";
            echo "<td>{$student['SubjectName']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Il n y'a pas d'abscences dans la date donnée .";
    }
    ?>
</div>
</body>
</html>
