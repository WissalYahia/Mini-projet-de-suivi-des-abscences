<?php
require_once('C_Grade.php');

$grade = new Grade();
$grades = $grade->listgrade();

require_once('C_Departement.php');

$departement = new Departement();
$departements = $departement->listdepartement();

require_once('C_Enseignant.php');

if (isset($_POST['create'])) {
    try {
        $enseignant = new Enseignant(
            $_POST['CodeEnseignant'],
            $_POST['Nom'],
            $_POST['Prenom'],
            $_POST['DateRecrutement'],
            $_POST['Adresse'],
            $_POST['Mail'],
            $_POST['Tel'],
            $_POST['CodeDepartement'],
            $_POST['CodeGrade']
        );

        if (isset($_GET['id'])) {
            $enseignant->updateEnseignant(
                $_POST['CodeEnseignant'],
                $_POST['Nom'],
                $_POST['Prenom'],
                $_POST['DateRecrutement'],
                $_POST['Adresse'],
                $_POST['Mail'],
                $_POST['Tel'],
                $_POST['CodeDepartement'],
                $_POST['CodeGrade']
            );
        } else {
            $enseignant->createEnseignant();
        }

        header("Location: view_enseignant.php");
        exit();
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

if (isset($_GET['id'])) {
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
    $existingTeacher = $enseignant->getEnseignantById($_GET['id']);
}
?>

<html>
    <head>
        <title>Enseignants</title>
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

        form {
            width: 90%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        .form-label {
            font-weight: bold;
            margin-top: 10px;
        }

        .btn {
            display: block;
            width: 100%;
            margin-top: 20px;
        }

        .alert {
            width: 90%;
            max-width: 600px;
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
                        <a class="nav-link active" aria-current="page" href="Liste_absence.php">Liste des abscence</a>
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
        <form action="create_enseignant.php<?php echo isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" method="post">
            <h2><?php echo isset($_GET['id']) ? 'Modifier un enseignant' : 'Créer un enseignant'; ?></h2>

            
            <input type="hidden" class="form-control" name="CodeEnseignant" value="<?php echo isset($existingTeacher['CodeEnseignant']) ? $existingTeacher['CodeEnseignant'] : ''; ?>" required><br>

            <label for="Nom" class="form-label">Nom:</label>
            <input type="text" class="form-control" name="Nom" value="<?php echo isset($existingTeacher['Nom']) ? $existingTeacher['Nom'] : ''; ?>" required><br>

            <label for="Prenom" class="form-label">Prénom:</label>
            <input type="text" class="form-control" name="Prenom" value="<?php echo isset($existingTeacher['Prenom']) ? $existingTeacher['Prenom'] : ''; ?>" required><br>

            <label for="DateRecrutement" class="form-label">DateRecrutement:</label>
            <input type="date" class="form-control" name="DateRecrutement" value="<?php echo isset($existingTeacher['DateRecrutement']) ? $existingTeacher['DateRecrutement'] : ''; ?>" required><br>

            <label for="Adresse" class="form-label">Adresse:</label>
            <input type="text" class="form-control" name="Adresse" value="<?php echo isset($existingTeacher['Adresse']) ? $existingTeacher['Adresse'] : ''; ?>" required><br>

            <label for="Mail" class="form-label">E-mail:</label>
            <input type="email" class="form-control" name="Mail" value="<?php echo isset($existingTeacher['Mail']) ? $existingTeacher['Mail'] : ''; ?>" required><br>

            <label for="Tel" class="form-label">Telephone:</label>
            <input type="tel" class="form-control" name="Tel" value="<?php echo isset($existingTeacher['Tel']) ? $existingTeacher['Tel'] : ''; ?>" required><br>

            <label for="CodeDepartement" class="form-label">Code departement:</label><br>
            <select name="CodeDepartement" class="form-select">
                <?php
                while ($row = $departements->fetch_assoc()) {
                    $selected = (isset($existingTeacher['CodeDepartement']) && $existingTeacher['CodeDepartement'] == $row['CodeDepartement']) ? 'selected' : '';
                    echo "<option value='" . $row['CodeDepartement'] . "' $selected>" . $row['NomDepartement'] . "</option>";
                }
                ?>
            </select> <br>

            <label for="CodeGrade" class="form-label">Grade Code:</label><br>
            <select name="CodeGrade" class="form-select">
                <?php
                while ($row = $grades->fetch_assoc()) {
                    $selected = (isset($existingTeacher['CodeGrade']) && $existingTeacher['CodeGrade'] == $row['CodeGrade']) ? 'selected' : '';
                    echo "<option value='" . $row['CodeGrade'] . "' $selected>" . $row['NomGrade'] . "</option>";
                }
                ?>
            </select> <br>

            <button type="submit" class="btn btn-light" name="create"><?php echo isset($_GET['id']) ? 'modifier un enseignant' : 'créer un enseignant'; ?></button>
        </form>
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
    </body>
</html>
