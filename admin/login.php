<?php
// login.php - Page de connexion
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des identifiants (exemple simple)
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'password') {
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Admin</title>
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="max-w-sm mx-auto p-6 bg-white shadow-lg rounded-lg mt-20">
        <h1 class="text-3xl font-semibold text-center mb-6">Connexion à l'admin</h1>

        <?php if (isset($error)): ?>
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-lg font-medium">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-lg font-medium">Mot de passe</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Se connecter</button>
            </div>
        </form>
    </div>

</body>

</html>