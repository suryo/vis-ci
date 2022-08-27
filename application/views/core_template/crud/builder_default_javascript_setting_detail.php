function onReady() {
    <?php foreach ($this->crud_builder->getFieldShowInColumn(true) as $input => $option) : ?>
    var <?= $option['name'] ?> = $('.detail_<?= $option['wrapper_class'] ?>');
    <?php endforeach ?>
}