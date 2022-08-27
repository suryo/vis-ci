function onReady() {
    <?php $lit =0;foreach ($this->crud_builder->getFieldShowInColumn(true) as $input => $option) : ?>
var <?= $option['name'] ?> = $('#<?= $option['name'] ?>');
   <?php if ($lit == 0): 
?>/* 
    <?= $option['name'] ?>.on('change', function() {});
    */
    <?php endif; $lit++; endforeach ?>

}

function beforeSave() {
    data_post.push({
        name : '_example',
        value : 'value_of_example',
    })
}