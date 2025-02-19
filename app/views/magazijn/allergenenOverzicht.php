<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            <h3><?php echo $data['title']; ?></h3>
        </div>
    </div>

    <form method="post" action="<?= URLROOT; ?>/magazijn/allergenenOverzicht">
        <div class="row mt-3">
            <div class="col-12">
                <label for="allergeen">Selecteer een allergeen:</label>
                <select name="allergeen" id="allergeen" class="form-control">
                    <?php foreach ($data['allergenen'] as $allergeen): ?>
                        <option value="<?= $allergeen->Naam ?>" <?= $data['selectedAllergeen'] == $allergeen->Naam ? 'selected' : '' ?>>
                            <?= $allergeen->Naam ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Maak selectie</button>
            </div>
        </div>
    </form>

    <?php if ($data['message']): ?>
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <?= $data['message']; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($data['products']): ?>
        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Barcode</th>
                            <th>Leverancier</th>
                            <th>Contactpersoon</th>
                            <th>Mobiel</th>
                            <th>Aantal Aanwezig</th>
                            <th>Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['products'] as $product): ?>
                            <tr>
                                <td><?= $product->Naam ?></td>
                                <td><?= $product->Barcode ?></td>
                                <td><?= $product->LeverancierNaam ?></td>
                                <td><?= $product->Contactpersoon ?></td>
                                <td><?= $product->Mobiel ?></td>
                                <td><?= $product->AantalAanwezig ?></td>
                                <td><a href="<?= URLROOT; ?>/magazijn/leverancierInfo/<?= $product->ProductId ?>">?</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
