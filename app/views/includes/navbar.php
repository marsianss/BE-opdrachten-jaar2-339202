<?php require_once '../app/config/config.php'; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= URLROOT; ?>">Jamin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= URLROOT; ?>/magazijn/index">Overzicht Magazijn</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URLROOT; ?>/leverancier/index">Overzicht Leveranciers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URLROOT; ?>/magazijn/allergenenOverzicht">Overzicht Allergenen</a>
            </li>
           <li>
            <a class="nav-link" href="<?= URLROOT; ?>/product/index">Overzicht producten uit het assortiment</a>
            </li>
            <!-- Add more links as needed -->
        </ul>
    </div>
</nav>
