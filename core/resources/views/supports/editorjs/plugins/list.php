<?php
    $tag = 'ul';

    if ($block->style == 'ordered') {
        $tag = 'ol';
    }
?>

<<?= $tag ?> class="show-list">
    <?php for ($i = 0; $i < count($block->items); $i++): ?>
        <li><?= $block->items[$i] ?></li>
    <?php endfor; ?>
</<?= $tag ?>>