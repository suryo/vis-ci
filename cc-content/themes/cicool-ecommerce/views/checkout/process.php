<?= get_header(); ?>

<body id="page-top">
  <?= get_navigation(); ?>
  <?= get_view_component('search-nav'); ?>
  <div class="container margin-top-140">
  </div>
  <?= cicool()->eventListen('coshop_product_detail_top'); ?>
  <div class="container">

    <div class="col-md-12">
      <div class="breadcrumb-product">
        <span class="breadcrumb-item"><a href="/">Home</a></span>
        <span class="breadcrumb-chevron"><span class="fal fa-chevron-right"></span></span>
        <span class="breadcrumb-item-current">Checkout</span>
      </div>
    </div>
  </div>

  <?= form_open('checkout/process', [
    'name'    => 'form_checkout',
    'class'   => 'form-horizontal',
    'id'      => 'form_checkout',
    'method'  => 'POST'
  ]); ?>

  <div class="container ">
    <div class="col-md-12 ">

      <div class="box-checkout">
        <?php if (count($carts)) : ?>
          <table class="table ">
            <thead>
              <tr>
                <td colspan="2">Product</td>
                <td>Price</td>
                <td width="200">Quantity</td>
                <td>Total</td>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($carts as $item) :
                $product = new Product\Product_single_item($item['detail']);
                $images = explode(',', $item['detail']->image);
              ?>
                <tr>
                  <td width="20">
                    <input type="hidden" name="cartid[]" class="product-selected " value="<?= $item['rowid'] ?>" checked>
                    <img class="cart-list-img-detail" src="<?= $product->getImageCover() ?>" alt="">

                  </td>
                  <td>
                    <a href="<?= site_url('product/detail/' . $product->getUrl()) ?>"><?= ucwords(($product->getName())) ?> </a>
                    <div class="cart-product-notes"><small><?= $item['options']['notes'] ? 'note :' : '' ?> <?= $item['options']['notes']  ?></small></div>
                  </td>
                  <td><?= curency($item['price']) ?></td>
                  <td>
                    <div class="qty-product-detail-wrapper">
                      <div class="col-md-12 padd-left-0">
                        <div class="qty-product-detail-counter">
                          <input type="" name="" class="counter-qty" readonly="" min="1" max="<?= $product->getStock() ?>" value="<?= $item['qty'] ?>">
                        </div>
                      </div>
                    </div>
                  </td>
                  <td><?= curency($item['subtotal']) ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          <?php else : ?>
            <center class="center-empty-chart">
              <img src="<?= theme_asset() ?>img/bag.svg" alt="">
              <div>Cart is Empty</div>
            </center>
          <?php endif ?>
          </table>

      </div>

    </div>

    <div class="row">

      <div class="col-md-6">
        <div class="col-md-12 padd-right-0 ">
          <div class="box-checkout">
            <span class="fal fa-map-marker"></span> Shipping Address
            <div class="box-checkout-content">
              <div class="row">
                <div class="col-md-12">
                  <?php if (!$address) : ?>
                    <a href="<?= base_url('member/shipping') ?>" class="btn btn-default"><span class="fal fa-plus-square"></span> Add shipping address</a>
                  <?php else : ?>
                    <div class="col-md-3"><span class="checkout-addr"><?= _ent($address->label) ?> <?= _ent($address->phone) ?></span></div>
                    <div class="col-md-6"><?= _ent($address->address_detail) ?></div>
                    <div class="col-md-1"><?= _ent($address->label) ?></div>
                    <div class="col-md-2"><a href="<?= base_url('member/shipping/edit/' . $address->id) ?>" class="pull-right">Change</a></div>
                  <?php endif; ?>
                </div>


              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 padd-right-0 ">
          <div class="box-checkout">
            <span class="fal fa-truck"></span> Delivery
            <div class="box-checkout-content">
              <div class="delivery-method-wrapper">

                <?php foreach ($shipping_methods as $item) :
                  if ($item->flat_price) {
                    $shipping_total = $item->flat_price;
                  } else {
                    $shipping_total = $item->price_per_kg;
                  }
                ?>
                  <div class="delivery-method-item">
                    <input type="radio" name="shipping_method" value="<?= $item->id ?>" checked> <?= $item->method_name ?> - <?= curency($shipping_total) ?>
                    <?= $item->description ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>



      </div>

      <div class="col-md-6">
        <div class="col-md-12 padd-left-0">
          <div class="box-checkout">
            <span class="fal fa-money"></span> Payment Method
            <div class="box-checkout-content">
              <div class="payment-method-wrapper">

                <?php foreach ($payment_methods as $item) : ?>
                  <div class="payment-method-item">
                    <input type="radio" checked name="payment_method" value="<?= $item->id ?>"> <?= $item->method_name ?> <?= $item->admin_fee ? curency($item->admin_fee) : '<span class="text-success">FREE</span>' ?>
                  </div>
                <?php endforeach ?>

              </div>
            </div>


          </div>
        </div>
      </div>

    </div>

    <div >
      <div >
        <?php if (count($carts)) : ?>
          <div class="checkout-wrapper">
            <button type="submit" href="<?= site_url('checkout') ?>" class="pull-right btn btn-primary btn-flat btn-add-chart-detail btn-lg btn-checkout " title=""><img src="<?= theme_asset() ?>img/icon-cart.png" alt=""> Process</button>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
  <?= form_close() ?>

  <script>
    $(function() {
      $('.delivery-method-item').on('click', function(event) {
        $(this).find('input[type="radio"]').prop('checked', 1);
      });
      $('.payment-method-item').on('click', function(event) {
        $(this).find('input[type="radio"]').prop('checked', 1);
      });
    })
  </script>
  <style type="">
    body {
    background: #fff;
  }
  .product-item {
    border: 1px solid #C9C9C9;
  }
</style>



  <?= get_footer(); ?>