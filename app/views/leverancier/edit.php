<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            <h3>Wijzig Leverancier</h3>
        </div>
    </div>

    <form action="<?= URLROOT; ?>/leverancier/update/<?= $data['id'] ?>" method="post">
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="naam">Naam:</label>
                    <input type="text" name="naam" class="form-control" value="<?= $data['naam'] ?>">
                    <span class="text-danger"><?= $data['naam_err'] ?></span>
                </div>
                <div class="form-group">
                    <label for="contactpersoon">Contactpersoon:</label>
                    <input type="text" name="contactpersoon" class="form-control" value="<?= $data['contactpersoon'] ?>">
                    <span class="text-danger"><?= $data['contactpersoon_err'] ?></span>
                </div>
                <div class="form-group">
                    <label for="leveranciernummer">Leveranciernummer:</label>
                    <input type="text" name="leveranciernummer" class="form-control" value="<?= $data['leveranciernummer'] ?>">
                    <span class="text-danger"><?= $data['leveranciernummer_err'] ?></span>
                </div>
                <div class="form-group">
                    <label for="mobiel">Mobiel:</label>
                    <input type="text" name="mobiel" class="form-control" value="<?= $data['mobiel'] ?>">
                    <span class="text-danger"><?= $data['mobiel_err'] ?></span>
                </div>
                <div class="form-group">
                    <label for="aantalProducten">Aantal Producten:</label>
                    <input type="text" name="aantalProducten" class="form-control" value="<?= $data['aantalProducten'] ?>">
                    <span class="text-danger"><?= $data['aantalProducten_err'] ?></span>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Wijzig</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
