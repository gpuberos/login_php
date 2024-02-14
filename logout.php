<?php

// Inclusion du fichier header.ut.php qui se trouve dans le répertoire utilities
require_once __DIR__ . "/utilities/header.ut.php";

// Suppression de la variable de session "user"
// Cela déconnecte l'utilisateur en supprimant ses informations de la session
unset($_SESSION["user"]);

// Redirection vers la page index.php
// Après la déconnexion, l'utilisateur est renvoyé à la page d'accueil
header("Location: index.php");

// Inclusion du fichier footer.ut.php qui se trouve dans le répertoire utilities
require_once __DIR__ . ("/utilities/footer.ut.php");
