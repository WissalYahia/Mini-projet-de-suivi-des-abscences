<?php
    require_once('C_Matiere.php');

    if (isset($_POST['create'])) {
        try {
            $etud = new Matiere(
                $_POST['Code'],
                $_POST['Nom'],
                $_POST['nbhc'],
                $_POST['nbhtd'],
                $_POST['nbhtp']
            );
    
            if (isset($_GET['id'])) {
                $etud->updateMatiere(
                    $_POST['Code'],
                    $_POST['Nom'],
                    $_POST['nbhc'],
                    $_POST['nbhtd'],
                    $_POST['nbhtp']
                );
            } else {
                $etud->createMatiere();
            }
    
            header("Location: view_matiere.php");
            exit();
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }
    
    if (isset($_GET['id'])) {
        $Matiere = new Matiere(
            '123',
            'aa',
            '1',
            '1',
            '1'
        );
        $existingStudent = $Matiere->getMatiereById($_GET['id']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Subject</title>
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
            width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
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
    <form action="create_matiere.php<?php echo isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" method="post">
        <h2><?php echo isset($_GET['id']) ?  'Modifier une matière': 'Créer une matière'; ?></h2>

       
        <input type="hidden" class="form-control" name="Code" value="<?php echo isset($existingStudent['CodeMatiere']) ? $existingStudent['CodeMatiere'] : ''; ?>" required><br>

        <label for="Nom" class="form-label">Nom:</label>
        <input type="text" class="form-control" name="Nom" value="<?php echo isset($existingStudent['NomMatiere']) ? $existingStudent['NomMatiere'] : ''; ?>" required><br>

        <label for="nbhc" class="form-label">Nombre d'heures par semaine:</label>
        <input type="number" class="form-control" name="nbhc" value="<?php echo isset($existingStudent['NbreHeureCoursParSemaine']) ? $existingStudent['NbreHeureCoursParSemaine'] : ''; ?>" required><br>

        <label for="nbhtd" class="form-label">Nombre d'heures de TD par semaine:</label>
        <input type="number" class="form-control" name="nbhtd" value="<?php echo isset($existingStudent['NbreHeureTDParSemaine']) ? $existingStudent['NbreHeureTDParSemaine'] : ''; ?>" required><br>

        <label for="nbhtp" class="form-label">Nombre d'heures de TP par semaine:</label>
        <input type="number" class="form-control" name="nbhtp" value="<?php echo isset($existingStudent['NbreHeureTPParSemaine']) ? $existingStudent['NbreHeureTPParSemaine'] : ''; ?>" required><br>

        <button type="submit" class="btn btn-light" name="create"><?php echo isset($_GET['id']) ? 'Modifier une matière' : 'Créer une matière'; ?></button>
    </form>
    <?php if (isset($errorMessage)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
</body>
</html>
