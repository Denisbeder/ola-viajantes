<div class="show-embed">
    <div <?php echo Str::contains($block->embed, ['youtu', 'vimeo']) ? 'class="embed-responsive embed-responsive-16by9"' : null; ?>>
    <iframe src="<?= $block->embed ?>" style="min-width:<?= $block->width ?>px; min-height:<?= $block->height ?>px" scrolling="no" frameborder="no"></iframe>
    </div>
    <?php if (!empty($block->caption)): ?>
        <footer class="show-embed-caption">
            <?= $block->caption ?>
        </footer>
    <?php endif; ?>
</div>