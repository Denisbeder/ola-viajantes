<?php if (!empty($block->meta)): ?>
<div class="show-embed">
    <?php if ((bool) strlen($block->meta['script'])) : ?>
        <div class="show-embed-link-script <?php echo Str::contains($block->link, ['youtu', 'vimeo']) ? 'embed-responsive embed-responsive-16by9' : null; ?>">
            <?= $block->meta['script'] ?>
        </div>
    <?php else : ?>
        <a class="show-embed-link" href="<?= $block->link ?>" target="_blank" rel="nofollow">
            <div class="show-embed-link-body">
                <div class="show-embed-link-title">
                    <?= $block->meta['title'] ?>
                </div>

                <div class="show-embed-link-description">
                    <?= $block->meta['description'] ?>
                </div>

                <span class="show-embed-link-domain">
                    <?= parse_url($block->link, PHP_URL_HOST) ?>
                </span>
            </div>

            <?php if ($block->meta['image']['url']) : ?>
                <img class="show-embed-link-image" src="<?= $block->meta['image']['url'] ?>">
            <?php endif; ?>
        </a>
    <?php endif; ?>
</div>
<?php endif; ?>