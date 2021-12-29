<div class="row row-cols-3 mt-5">
<?php foreach ($block as $img): ?>
<figure class="col mb-4">
    <img src="<?= $img['url'] ?>" alt="<?php echo !empty($img['caption']) ? $img['caption'] : '' ?>" class="img-fluid" style="object-fit: cover; width: 300px; height: 230px">
</figure>
<?php endforeach; ?>
</div>