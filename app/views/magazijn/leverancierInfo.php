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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $data['leverancier']->Naam ?></td>
                            <td><?= $data['leverancier']->Contactpersoon ?></td>
                            <td><?= $data['leverancier']->Mobiel ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
