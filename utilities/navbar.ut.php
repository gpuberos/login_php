<nav class="navbar navbar-expand-lg bg-dark text-white" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Login PHP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav flex-grow-1">
                <?php if (!isset($_SESSION["user"])) : ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Identifiez-vous</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Créer un compte</a></li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Votre profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
                    <li class="d-flex ms-auto"><span class="navbar-text">Bienvenue <?= $_SESSION["user"]["username"] ?></span></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>