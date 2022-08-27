<?= get_header(); ?>

<body id="page-top">
  <?= get_navigation(); ?>
  <?= get_view_component('search-nav'); ?>
  <div class="container container-chart">
  </div>
  <?= cicool()->eventListen('coshop_product_detail_top'); ?>
  <div class="container">
    <div class="col-md-12">
      <div class="breadcrumb-product">
        <span class="breadcrumb-item"><a href="/">Home</a></span>
        <span class="breadcrumb-chevron"><span class="fa fa-chevron-right"></span></span>
        <span class="breadcrumb-item-current">Cart</span>
      </div>
    </div>
  </div>

  <?= form_open('checkout', [
    'name'    => 'form_checkout',
    'class'   => 'form-horizontal',
    'id'      => 'form_checkout',
    'method'  => 'POST'
  ]); ?>

  <div class="container ">
    <div class="col-md-12 table-responsive">
      <?php if (count($carts)) : ?>
        <table class="table ">
          <thead>
            <tr>
              <td colspan="2">Product</td>
              <td>Price</td>
              <td width="200">Quantity</td>
              <td>Total</td>
              <td>Action</td>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($carts as $item) :
              $product = new Product\Product_single_item($item['detail']);
              $images = explode(',', $item['detail']->image);
            ?>
              <tr>
                <td width="20">
                  <img class="cart-list-img-detail" src="<?= $product->getImageCover() ?>" alt="">
                </td>
                <td width="300">
                  <a href="<?= site_url('product/detail/' . $product->getUrl()) ?>"><?= ucwords(($product->getName())) ?> </a>
                  <div class="cart-product-notes">
                    <div class="cart-label-section">
                      Notes : <?= $item['options']['notes']  ?> <a href="#" class="edit-notes-btn"><span class="fal fa-edit"></span></a>
                    </div>
                    <textarea type="text" name="cart[<?= $item['rowid'] ?>][notes]" placeholder="notes : ex blue, size XL" class="notes-for-merchant"><?= $item['options']['notes']  ?></textarea>
                    <small>
                    </small>
                  </div>
                </td>
                <td><?= $product->getPriceFormat() ?></td>
                <td>
                  <div class="qty-product-detail-wrapper qty-product-detail-wrapper-cart-page">
                    <div class="col-md-12 padd-left-0">
                      <div class="qty-product-detail-counter">
                        <a href="" class="button-qty-min" title=""><span class="fal fa-minus-circle"></span></a>
                        <input type="" name="cart[<?= $item['rowid'] ?>][qty]" class="counter-qty" readonly="" min="<?= $product->getMinimumOrder() ?>" max="<?= $product->getStock() ?>" value="<?= $item['qty'] ?>">
                        <a href="" class="button-qty-plus" title=""><span class="fal fa-plus-circle"></span></a>
                      </div>
                    </div>
                  </div>
                </td>
                <td><?= curency($item['subtotal']) ?></td>
                <td><a href="<?= base_url('cart/remove/' . $item['rowid']) ?>" class="remove-cart btn btn-default"><span class="fal fa-trash"></span></a></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        <?php else : ?>
          <center class="center-chart">
            <img class="imgc" src="<?= theme_asset() ?>img/bag.svg" alt="">
            <div class="cart-empty-label">Cart is Empty, <a href="<?= base_url('product/all') ?>">Explore Product</a></div>
          </center>
        <?php endif ?>
        </table>
        <?php if (count($carts)) : ?>
          <div class="checkout-wrapper">
            <button type="submit" href="<?= site_url('checkout') ?>" class="pull-right btn btn-primary btn-flat btn-add-chart-detail btn-lg btn-checkout " title=""><img src="<?= theme_asset() ?>img/icon-cart.png" alt=""> Checkout</button>
          </div>
        <?php endif ?>
    </div>
  </div>
  <?= form_close() ?>

  <script>
    $(function() {

      "use strict";

      $('.edit-notes-btn').on('click', function(event) {
        var parent = $(this).parents('.cart-product-notes');
        parent.find('.cart-label-section').hide();
        parent.find('.notes-for-merchant').show();
        parent.find('.notes-for-merchant')[0].focus();
      });
      $('.button-qty-plus').on('click', function(event) {
        event.preventDefault();
        var $parent = $(this).parent('.qty-product-detail-counter');
        var current = parseInt($parent.find('.counter-qty').val());
        var min = $parent.find('.counter-qty').attr('min');
        var max = $parent.find('.counter-qty').attr('max');
        if (Number.isNaN(current)) {
          $parent.find('.counter-qty').val(0);
        } else {
          if (current < max) {
            $parent.find('.counter-qty').val(current += 1);
          }
        }

      });
      $('.button-qty-min').on('click', function(event) {
        event.preventDefault();
        var $parent = $(this).parent('.qty-product-detail-counter');
        var min = $parent.find('.counter-qty').attr('min');
        var max = $parent.find('.counter-qty').attr('max');
        var current = parseInt($parent.find('.counter-qty').val());
        if (Number.isNaN(current)) {
          $parent.find('.counter-qty').val(0);
        } else {
          if (current > min) {
            $parent.find('.counter-qty').val(current -= 1);
          }
        }

      });
      $('.check-all').on('change', function(event) {
        $('.product-selected').prop('checked', $(this).prop('checked'));
      });
    })
  </script>


  <?= get_footer(); ?>