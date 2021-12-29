<?php
    $classes = array();

    if ( !empty($block->stretched) && $block->stretched == 'true'){
        $classes[] = 'show-image--stretched';
    }

    if ( !empty($block->withBorder) && $block->withBorder == 'true'){
        $classes[] = 'show-image--bordered';
    }

    if ( !empty($block->withBackground) && $block->withBackground == 'true'){
        $classes[] = 'show-image--backgrounded';
    }

    $url = @$block->file['url'];
?>

<figure class="show-image <?= implode(' ', $classes) ?>">
    <img src="<?= $url ?>" alt="<?php !empty($block->caption) ? $block->caption : ''; ?>">
    <?php if (!empty($block->caption)): ?>
        <figcaption class="show-image-caption">
            <?= $block->caption ?>
        </figurecaption>
    <?php endif; ?>
</figure>
