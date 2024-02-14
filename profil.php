<?php require_once __DIR__ . "/utilities/header.ut.php"; ?>

<div class="container py-4">

    <section>
        <div class="card">
            <h1 class="card-header h3 mb-3 fw-normal bg-secondary text-white">Profil de <?= $_SESSION["user"]["username"] ?></h1>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Votre nom : <?= $_SESSION["user"]["username"] ?></li>
                <li class="list-group-item">Adresse e-mail : <?= $_SESSION["user"]["email"] ?></li>
            </ul>
        </div>
    </section>

</div>

<?php require_once __DIR__ . ("/utilities/footer.ut.php"); ?>