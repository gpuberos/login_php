<?php

// Inclusion du fichier header.ut.php qui se trouve dans le répertoire utilities
require_once __DIR__ . "/utilities/header.ut.php";

// Vérifie s'il n'y a pas de session utilisateur active
if (!isset($_SESSION["user"])) {
    // S'il n'y a pas de session utilisateur active, redirige l'utilisateur vers la page 'login.php'
    header("Location: login.php");

    // Arrête l'exécution du script après la redirection
    exit;
}

// Suppression de la variable de session "user"
// Cela déconnecte l'utilisateur en supprimant ses informations de la session
unset($_SESSION["user"]);

// Redirection vers la page index.php
// Après la déconnexion, l'utilisateur est renvoyé à la page d'accueil
header("Location: index.php");
