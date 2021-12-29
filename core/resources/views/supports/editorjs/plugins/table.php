<table class="show-table table table-bordered">
    <?php foreach ($block->content as $row) : ?>
        <tr>
            <?php foreach ($row as $cell) : ?>
                <td>
                    <?= $cell ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>