<?php

// Inclusion du fichier header.ut.php qui se trouve dans le répertoire utilities
require_once __DIR__ . "/utilities/header.ut.php";

// Vérification si le formulaire a été soumis
if (!empty($_POST)) {
    // Le formulaire a été soumis
    // Vérification que tous les champs requis sont remplis
    if (isset($_POST["user_name"], $_POST["email_address"]) && !empty($_POST["user_name"]) && !empty($_POST["email_address"])) {
        // Le formulaire est complet
        // Récupération des données en les protégeant

        // Suppression des balises HTML et PHP d'une chaîne
        $pseudo = strip_tags($_POST["user_name"]);

        // Vérification de la validité de l'email
        if (!filter_var($_POST["email_address"], FILTER_VALIDATE_EMAIL)) {
            die("L'addresse mail est incorrect");
        }

        // Hashage du mot de passe en utilisant l'algorithme ARGON2ID
        // Un "sel" unique est automatiquement généré et inclus dans le hachage du mot de passe
        $pass = password_hash($_POST["user_password"], PASSWORD_ARGON2ID);

        // Ajout de tous les contrôles souhaités ici

        // Enregistrement en base de données
        // Le mot de passe est passé directement car il est hashé, ROLE est du JSON
        $sql = "INSERT INTO `users`(`user_name`, `email_address`, `user_password`, `user_roles`) 
        VALUES (:user_name, :email_address, '$pass', '[\"ROLE_USER\"]')";

        // Préparation de la requête SQL
        $query = $db->prepare($sql);

        // Liaison de la valeur du pseudo à l'identifiant :user_name dans la requête SQL
        $query->bindValue(":user_name", $pseudo);
        
        // Liaison de la valeur de l'email à l'identifiant :email_address dans la requête SQL
        $query->bindValue(":email_address", $_POST["email_address"]);

        // Exécution de la requête SQL
        $query->execute();

        // Récupération de l'id du nouvel utilisateur
        $id = $db->lastInsertId();

        // Connexion de l'utilisateur

        // Si l'utilisateur et le mot de passe sont corrects
        // Connexion de l'utilisateur (ouverture de la session)
        // Démarrage de la session PHP (Création de PHPSESSID)
        session_start();

        // Stockage des informations de l'utilisateur dans $_SESSION
        $_SESSION["user"] = [
            "id" => $id,
            "username" => $pseudo,
            "email" => $_POST["email_address"],
            "roles" => ["ROLE_USER"]
        ];

        // Redirection vers la page de profil
        header("Location: profil.php");
    } else {
        // Le formulaire est incomplet
        die("Le formulaire est incomplet !");
    }
}


var_dump($_POST);

?>

<body>

    <div class="container py-4">

        <form action="#" method="POST" class="col-4 mx-auto">
            <fieldset>
                <legend>Inscription utilisateur</legend>
                <div class="row">
                    <div class="col mb-3">
                        <label for="inputUsername" class="form-label">Nom utilisateur</label>
                        <input type="text" class="form-control" id="inputUsername" name="user_name">
                    </div>
                </div>
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
                        <input type="submit" class="btn btn-primary" value="Inscription">
                    </div>
                </div>
            </fieldset>
        </form>

    </div>

    <?php require_once __DIR__ . ("/utilities/footer.ut.php"); ?>