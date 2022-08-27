<?php cicool()->eventListen('product_item_single') ?>

<?php
$product = new Product\Product_single_item($product);
?>
<a class="product-item" href="<?= site_url('product/detail/' . $product->getUrl()) ?>">
    <div class="product-image" style="background-image: url('<?= $product->getImageCover() ?>'); background-size: contain; background-repeat: no-repeat; ">
    </div>
    <div class="product-content">
        <div class="product-content-name">
            <?= ucwords(($product->getName())) ?>
        </div>
        <div class="product-content-price">
            <?= $product->getPriceFormat() ?>
        </div>
    </div>
    <div class="product-footer">
        <div class="product-footer-store-name">
            <?= ucwords(($product->merchant->getName())) ?>
        </div>

    </div>
</a>