<a class="show-attaches d-flex" href="<?= @$block->file['url'] ?>" target="_blank">
    <div class="show-attaches-icon-file">
        <span><?= @$block->file['extension'] ?></span>
        <i class="lni lni-empty-file"></i>
    </div>
    <div class="show-attaches-body">
        <div class="show-attaches-title"><?= $block->title ?></div>
        <div class="show-attaches-size"><?= format_bytes(@$block->file['size']) ?></div>
    </div>
    <div class="show-attaches-icon-download">
        <i class="lni lni-download"></i>
    </div>
</a>