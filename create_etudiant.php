<?php
require_once('C_Classe.php');

$classe = new Classe();
$classes = $classe->listclasse();

require_once('C_Etudiant.php');

if (isset($_POST['submit'])) {
    try {
        $etud = new Etudiant(
            $_POST['Nom'],
            $_POST['Prenom'],
            $_POST['DateNaissance'],
            $_POST['CodeClasse'],
            $_POST['NumInscription'],
            $_POST['Adresse'],
            $_POST['Mail'],
            $_POST['Telephone']
        );

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $etud->updateEtudiant(
                $id,
                $_POST['Nom'],
                $_POST['Prenom'],
                $_POST['DateNaissance'],
                $_POST['CodeClasse'],
                $_POST['NumInscription'],
                $_POST['Adresse'],
                $_POST['Mail'],
                $_POST['Telephone']
            );
        } else {
            $etud->createEtudiant();
        }

        header("Location: view_etudiants.php");
        exit();
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create/Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F5F5DC; 
        }

        .navbar {
            background-color: #000 !important;
            width: 100%; 
        }

        .navbar-brand, .nav-link {
            color: #fff !important; 
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background-color: #fff; 
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-left: 320px;
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
                        <a class="nav-link active" aria-current="page" href="Liste_absence.php">Liste Abscence</a>
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

<div class="form-container">
    <form action="create_etudiant.php<?php echo isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" method="post">
        <h2><?php echo isset($_GET['id']) ? 'Modifier un étudiant' : 'Créer un étudiant'; ?></h2>

        <label for="Nom" class="form-label">Nom:</label>
        <input type="text" class="form-control" name="Nom" value="<?php echo isset($existingStudent['Nom']) ? $existingStudent['Nom'] : ''; ?>" required>

        <label for="Prenom" class="form-label">Prénom:</label>
        <input type="text" class="form-control" name="Prenom" value="<?php echo isset($existingStudent['Prenom']) ? $existingStudent['Prenom'] : ''; ?>" required><br>

        <label for="DateNaissance" class="form-label">Date de naissance:</label>
        <input type="date" class="form-control" name="DateNaissance" value="<?php echo isset($existingStudent['DateNaissance']) ? $existingStudent['DateNaissance'] : ''; ?>" required><br>

        <label for="CodeClasse" class="form-label">Classe:</label><br>
        <select name="CodeClasse" class="form-select">
            <?php
            while ($row = $classes->fetch_assoc()) {
                $selected = (isset($existingStudent['CodeClasse']) && $existingStudent['CodeClasse'] == $row['CodeClasse']) ? 'selected' : '';
                echo "<option value='" . $row['CodeClasse'] . "' $selected>" . $row['NomClasse'] . "</option>";
            }
            ?>
        </select><br>

        <label for="NumInscription" class="form-label">Numèro d'inscription:</label>
        <input type="text" class="form-control" name="NumInscription" value="<?php echo isset($existingStudent['NumInscription']) ? $existingStudent['NumInscription'] : ''; ?>" required><br>

        <label for="Adresse" class="form-label">Adresse:</label>
        <input type="text" class="form-control" name="Adresse" value="<?php echo isset($existingStudent['Adresse']) ? $existingStudent['Adresse'] : ''; ?>" required><br>

        <label for="Mail" class="form-label">E-mail:</label>
        <input type="email" class="form-control" name="Mail" value="<?php echo isset($existingStudent['Mail']) ? $existingStudent['Mail'] : ''; ?>" required><br>

        <label for="Telephone" class="form-label">Telephone:</label>
        <input type="Telephone" class="form-control" name="Telephone" value="<?php echo isset($existingStudent['Telephone']) ? $existingStudent['Telephone'] : ''; ?>" required><br>

        <button type="submit" class="btn btn-light" name="submit"><?php echo isset($_GET['id']) ? 'Modifier un étudiant' : 'Créer un étudiant'; ?></button>
    </form>
</div>

<?php if (isset($errorMessage)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>
</body>
</html>
