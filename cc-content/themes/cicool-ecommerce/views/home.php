<?= get_header(); ?>

<body id="page-top">
    <?= get_navigation(); ?>
    <?= get_view_component('search-nav'); ?>
    <div class="container margin-top-140">
    </div>
    <?= cicool()->eventListen('coshop_home_top'); ?>
    <div class="container">
        <div class="col-md-12">
            <?= get_view_component('carousel/carousel'); ?>
        </div>
    </div>

    <div class="container">
        <div class="col-md-12">
            <?= get_view_component('category/slide-category'); ?>
        </div>
    </div>

    <div class="container m-t-30">

        <?php foreach ($this->model_product->get(null, null, 10) as $product) : ?>
            <div class="col-md-2 col-sm-3 col-xs-6">
                <?= get_view_component('product-single-item', ['product' => $product]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?= get_footer(); ?>