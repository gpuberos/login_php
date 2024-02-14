<?php

require_once __DIR__ . "/utilities/header.ut.php";

// On vérifie si le formulaire a été envoyé
if(!empty($_POST)) {
    // Le formulaire a été envoyé
    // On vérifie que TOUS les champs requis sont remplis
    if(isset($_POST["user_name"], $_POST["email_address"], $_POST["user_pass"]) && !empty($_POST["user_name"]) && !empty($_POST["email_address"]) && !empty($_POST["user_pass"])) {
        // Le formulaire est complet
        // On récupère les données en les protégeants

        $pseudo = strip_tags($_POST["user_name"]);

        // On vérifie si l'email est valide
        if(!filter_var($_POST["email_address"], FILTER_VALIDATE_EMAIL)) {
            die("L'addresse mail est incorrect");
        }

        // On va hasher le mot de passe (on choisit la constante algo de cryptage)
        $pass = password_hash($_POST["user_password"], PASSWORD_ARGON2ID);

        // Ajoutez tous les contrôles souhaités

        // On enregistre en base de données
        // On passe le password en direct car il est hashé, ROLE c'est du JSON
        $sql = "INSERT INTO `users`(`user_name`, `email_address`, `user_password`, `user_roles`) 
        VALUES (:user_name, :email_address, '$pass', '[\"ROLE_USER\"]' )";

        $query = $db->prepare($sql);

        $query->bindValue(":user_name", $userName);
        $query->bindValue(":email_address", $emailAddress);

        $query->execute();

        // On récupère l'id du nouvel utilisateur
        $id = $db->lastInsertId();

        // On connectera l'utilisateur

        // Si l'utilisateur et le mot de passe sont corrects
        // On va pouvoir connecter l'utilisateur (on ouvre la session)
        // On démarre la session PHP (Créatio de PHPSESSID)
        session_start();

        // On va stocker dans $_SESSION les informations de l'utilisateur
        $_SESSION["user"] = [
            "id" => $id,
            "username" => $pseudo,
            "email" => $_POST["email_address"],
            "roles" => ["ROLE_USER"]
        ];

        // On redirige vers la page de profil
        header("Location: profil.php");
    
    } else {
        die("Le formulaire est incomplet !");
    }
}


?>

<body>

    <form action="#" method="POST">
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
            <div class="col mb-3">
                <input type="submit" class="btn btn-primary">Inscription</button>
            </div>
        </fieldset>
    </form>


    <?php require_once __DIR__ . ("/utilities/footer.ut.php"); ?>