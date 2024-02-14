<?php

// Inclusion du fichier header.ut.php qui se trouve dans le répertoire utilities
require_once __DIR__ . "/utilities/header.ut.php";

// Vérification si le formulaire a été soumis
if (!empty($_POST)) {
    // Le formulaire a été soumis
    // Vérification que tous les champs requis sont remplis
    if (isset($_POST["email_address"], $_POST["user_password"]) && !empty($_POST["email_address"]) && !empty($_POST["user_password"])) {
        // Vérification de la validité de l'email
        if (!filter_var($_POST["email_address"], FILTER_VALIDATE_EMAIL)) {
            die("L'addresse mail est incorrect");
        }

        // Connexion à la base de données et préparation de la requête SQL
        $sql = "SELECT * FROM `users` WHERE `email_address` = :email_address";

        // Préparation de la requête SQL
        $query = $db->prepare($sql);
        
        // Liaison de la valeur de l'email à l'identifiant :email_address dans la requête SQL
        $query->bindValue(":email_address", $_POST["email_address"]);
        
        // Exécution de la requête SQL
        $query->execute();

        // Récupération du premier enregistrement renvoyé par la requête SQL
        $user = $query->fetch();

        // Vérification si un utilisateur a été trouvé
        if (!$user) {
            die("L'utilisateur et/ou le mot de passe est incorrect");
        }

        // Si un utilisateur existant a été trouvé, vérification du mot de passe
        if (!password_verify($_POST["user_password"], $user["user_password"])) {
            die("L'utilisateur et/ou le mot de passe est incorrect");
        }

        // Si l'utilisateur et le mot de passe sont corrects
        // Démarrage d'une nouvelle session ou reprise d'une session existante
        session_start();

        // Stockage des informations de l'utilisateur dans la variable de session $_SESSION
        $_SESSION["user"] = [
            "id" => $user["id"],
            "username" => $user["user_name"],
            "email" => $user["email_address"],
            "roles" => $user["user_roles"]
        ];

        // Redirection vers la page de profil
        header("Location: profil.php");
    }
}

?>

<body>
    <div class="container py-4">

        <form action="#" method="POST" class="col-4 mx-auto">
            <fieldset>
                <legend>Connexion utilisateur</legend>
                <div class="row">
                    <div class="col mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email_address">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="user_password">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <input type="submit" class="btn btn-primary" value="Connexion">
                    </div>
                </div>
            </fieldset>
        </form>

    </div>

    <?php require_once __DIR__ . ("/utilities/footer.ut.php"); ?>