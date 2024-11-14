<?php
require_once('C_Classe.php');
require_once('C_Seance.php');
require_once('C_Fetchens.php');
require_once('C_Fetchmat.php');
require_once('C_Etudiant.php');

$classe = new Classe();
$classes = $classe->listclasse();

$Seance = new Seance();
$Seances = $Seance->listseance();

$Matiere = new Fetchmat(); 
$Matieres = $Matiere->listmat();

$Enseignant = new Fetchens();
$Enseignants = $Enseignant->listens();

if (isset($_GET['id'])) {
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
    $existingStudent = $etudiant->getEtudiantById($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matiereId = $_POST["CodeMatiere"];
    $enseignantId = $_POST["CodeEnseignant"];
    $seanceId = $_POST["CodeSeance"];
    $classId = $_POST["CodeClasse"];
    $dateJour = $_POST["dateJour"];
    $Code = $_POST["Code"];
    
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
    
    $etudiant->markEtudiantAbsent($Code, $matiereId, $enseignantId, $seanceId, $classId, $dateJour);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Absence</title>
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

        form {
            width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
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
                            Enseignant
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_matiere.php"  >
                            Matiéres
                        </a>
                        
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <h2>Marquer un étudiant comme abscent</h2>

    <form action="mark_absence.php" method="post">
        
        <input type="hidden" class="form-control" name="Code" value="<?php echo isset($existingStudent['CodeEtudiant']) ? $existingStudent['CodeEtudiant'] : ''; ?>"><br>

        <label for="CodeMatiere" class="form-label">Matière:</label>
        <select name="CodeMatiere" class="form-select">
            <?php
                while ($row = $Matieres->fetch_assoc()) {
                    echo "<option value='" . $row['CodeMatiere'] . "'>" . $row['NomMatiere'] . "</option>";
                }
            ?>
        </select><br>

        <label for="CodeEnseignant" class="form-label">Enseignant:</label>
        <select name="CodeEnseignant" class="form-select">
            <?php
                while ($row = $Enseignants->fetch_assoc()) {
                    echo "<option value='" . $row['CodeEnseignant'] . "'>" . $row['Nom'] . "</option>";
                }
            ?>
        </select><br>

        <label for="CodeSeance" class="form-label">Seance:</label>
        <select name="CodeSeance" class="form-select">
            <?php
                while ($row = $Seances->fetch_assoc()) {
                    echo "<option value='" . $row['CodeSeance'] . "'>" . $row['NomSeance'] . "</option>";
                }
            ?>
        </select><br>

        <label for="CodeClasse" class="form-label">Classe:</label>
        <select name="CodeClasse" class="form-select">
            <?php
                while ($row = $classes->fetch_assoc()) {
                    echo "<option value='" . $row['CodeClasse'] . "'>" . $row['NomClasse'] . "</option>";
                }
            ?>
        </select><br>

        <label for="dateJour" class="form-label">Date:</label>
        <input type="date" class="form-control" id="dateJour" name="dateJour" required><br>

        <input type="submit" class="btn btn-light" value="Marquer">
    </form>
</body>
</html>
