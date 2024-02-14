<?php

require_once __DIR__ . "/utilities/header.ut.php";

// On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
    // Le formulaire a été envoyé
    // On vérifie que TOUS les champs requis sont remplis
    if (isset($_POST["email_address"], $_POST["user_password"]) && !empty($_POST["email_address"]) && !empty($_POST["user_password"])) {
        // On vérifie que l'email en est un
        if (!filter_var($_POST["email_address"], FILTER_VALIDATE_EMAIL)) {
            die("L'addresse mail est incorrect");
        }

        // On se connecte à la BDD
        $sql = "SELECT * FROM `users` WHERE `email_address` = :email_address";

        $query = $db->prepare($sql);
        $query->bindValue(":email_address", $_POST["email_address"]);
        $query->execute();

        $user = $query->fetch();

        if (!$user) {
            die("L'utilisateur et/ou le mot de passe est incorrect");
        }

        // Si on a un user existant, on peut vérifier le mot de passe
        if (!password_verify($_POST["user_password"], $user["user_password"])) {
            die("L'utilisateur et/ou le mot de passe est incorrect");
        }

        // Si l'utilisateur et le mot de passe sont corrects
        // On va pouvoir connecter l'utilisateur (on ouvre la session)
        // On démarre la session PHP (Créatio de PHPSESSID)
        session_start();

        // On va stocker dans $_SESSION les informations de l'utilisateur
        $_SESSION["user"] = [
            "id" => $user["id"],
            "username" => $user["user_name"],
            "email" => $user["email_address"],
            "roles" => $user["user_roles"]
        ];

        // On redirige vers la page de profil
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