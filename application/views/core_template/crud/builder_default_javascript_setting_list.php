function onReady() {

}

function eachRows(row) {
<?php foreach ($this->crud_builder->getFieldShowInColumn(true) as $input => $option) : ?>
    var <?= $option['name'] ?> = row.find('.list_<?= $option['wrapper_class'] ?>');
<?php endforeach ?>

}