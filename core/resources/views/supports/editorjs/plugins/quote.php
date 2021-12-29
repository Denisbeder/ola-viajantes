<?php
    if ($block->alignment == 'center') {
        $centerClass = 'show-quote--center';
    } else {
        $centerClass = '';
    }
?>

<blockquote cite="<?= $block->caption ?>" class="show-quote <?= $centerClass ?>">
    <?= $block->text ?>
</blockquote>
