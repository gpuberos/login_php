<?php

require_once __DIR__ . "/utilities/header.ut.php";

// Supprime une variable
unset($_SESSION["user"]);

header("Location: index.php");

require_once __DIR__ . ("/utilities/footer.ut.php");