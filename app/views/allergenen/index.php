<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <h3><?php echo $data['title']; ?></h3>
            <ul>
                <?php foreach($data['allergenen'] as $allergeen): ?>
                    <li><?php echo $allergeen->name; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
