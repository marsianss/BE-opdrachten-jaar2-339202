<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            <h3><?php echo $data['title']; ?></h3>
        </div>
    </div>

    <?php if ($data['message']): ?>
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <?= $data['message']; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Contactpersoon</th>
                            <th>Mobiel</th>
                            <th>Straat</th>
                            <th>Huisnummer</th>
                            <th>Postcode</th>
                            <th>Stad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $data['leverancier']->Naam ?></td>
                            <td><?= $data['leverancier']->Contactpersoon ?></td>
                            <td><?= $data['leverancier']->Mobiel ?></td>
                            <td><?= $data['leverancier']->Straat ?></td>
                            <td><?= $data['leverancier']->Huisnummer ?></td>
                            <td><?= $data['leverancier']->Postcode ?></td>
                            <td><?= $data['leverancier']->Stad ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
