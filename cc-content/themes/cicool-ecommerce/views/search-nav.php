<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-search">
    <div class="header-second-top">

        <div class="container">
            <div class="col-md-2">
                <a href="/"><img src="<?= theme_asset() ?>img/logo-white.png" alt="" class="main-logo"></a>

                <a href="" title="" class="bar-menu">
                    <img src="<?= theme_asset() ?>img/menu.svg" class="menu-bar">
                </a>
                <div class="menu-category-container display-none>
                    <div class=" shop-category-tile">SHOOP CATEGORY</div>
                <div class="category-list-wrapper">
                    <ul>
                        <?php foreach (db_get_all_data('product_category') as $item) : ?>
                            <li><a href="<?= site_url('product/ct-' . url_title($item->category_name) . '-' . $item->id) ?>" title=""><?= _ent(ucwords($item->category_name)) ?> <img src="<?= theme_asset() ?>img/chevron.svg" class="menu-bar"></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
            <div class="menu-category-wrapper display-none>

                </div>

            </div>
            <div class=" col-md-9 ">
                <form action=" <?= site_url('product/all') ?>">
                <a class="btn-search" onclick="$(this).closest('form').submit()">
                    <center><i class="fa fa-search"></i></center>
                </a>

                <input type="" autocomplete="off" name="q" class="search-product" placeholder="Find product, store and brand">
                </form>
                <div class="search-suggest-bottom">
                    <a href="" class="suggest-item" title=""></a>

                </div>

                <div class="search-result-container display-none">

                </div>
            </div>
            <div class="col-md-1 cart-button-wrapper">
                <a href="<?= base_url('cart') ?>" class="btn-cart"><img style="height:30px;" src="<?= theme_asset() ?>img/icon-cart.png" alt=""></a>

                <div class="cart-counter">-</div>
                <div class="cart-item-wrapper display-none">

                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    $(function() {
        getCart()
    })
</script>