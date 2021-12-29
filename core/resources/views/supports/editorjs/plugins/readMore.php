<aside class="show-read-more">
    <strong class="mb-3 d-block">Leia Também</strong>
    <ul>
        <?php foreach ($block->items as $item): ?>
        <li>
            <a href="<?= $item['url'] ?? null ?>"><?= $item['title'] ?? null ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</aside>