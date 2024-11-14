<?php
session_start();
require_once('C_admin.php');
$per = new Admin();
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($per->loginUser($login, $password)) {
        $_SESSION['loggedin'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $errorMessage = 'Login or password is incorrect';
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: beige;
        }
        form {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
            margin: 1cm auto;
            margin-top:3cm;
        }
        .navbar {
            background-color: #000 !important;
            width: 100%;
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .form-label {
            margin-bottom: 0.5rem;
        }
        .btn-light {
            margin-top: 1rem;
            margin-left:14rem;
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
                
            </div>
        </div>
    </nav>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <fieldset>
        <legend>Admin Login</legend>
        <?php
        if (!empty($errorMessage)) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($errorMessage) . '</div>';
        }
        ?>
        <div class="mb-3">
            <label for="login" class="form-label">Login :</label>
            <input type="text" name="login" id="login" value="" class="form-control" required />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" name="password" id="password" value="" class="form-control" required /><br>
            <input class="btn btn-light" type="submit" name="submit" value="Log in" />
        </div>
    </fieldset>
</form>
</body>
</html>
