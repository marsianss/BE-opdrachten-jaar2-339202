<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            <h3>Verwijder Product</h3>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <p>Weet u zeker dat u het product <strong><?= $data['product']->Naam ?></strong> wilt verwijderen?</p>
        </div>
    </div>

    <form action="<?= URLROOT; ?>/product/delete/<?= $data['product']->Id ?>" method="post">
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-danger">Verwijder</button>
                <a href="<?= URLROOT; ?>/product" class="btn btn-secondary">Annuleer</a>
            </div>
        </div>
    </form>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
