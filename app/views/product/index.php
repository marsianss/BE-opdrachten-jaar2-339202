<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            <h3><?php echo $data['title']; ?></h3>
        </div>
    </div>

    <p>Product index view loaded</p> <!-- Debugging -->

    <form method="post" action="<?= URLROOT; ?>/product/index">
        <div class="row mt-3">
            <div class="col-6">
                <label for="startDate">Startdatum:</label>
                <input type="date" name="startDate" id="startDate" class="form-control" value="<?= $data['startDate'] ?>">
            </div>
            <div class="col-6">
                <label for="endDate">Einddatum:</label>
                <input type="date" name="endDate" id="endDate" class="form-control" value="<?= $data['endDate'] ?>">
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
                            <th>Einddatum Levering</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['products'] as $product): ?>
                            <tr>
                                <td><?= $product->Naam ?></td>
                                <td><?= $product->Barcode ?></td>
                                <td><?= $product->EinddatumLevering ?></td>
                                <td>
                                    <a href="<?= URLROOT; ?>/product/delete/<?= $product->Id ?>" class="btn btn-danger">Verwijder</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
