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
        <span class="breadcrumb-item-current">Invoice</span>
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

    <div class="row">

    </div>

    <div class="col-md-12">
      <?php if ($transaction->status == Model_transaction_status::PENDING) : ?>
        <div class="alert alert-warning">
          Please complete your payment
          <?= $payment_method->description ?> <br>
          Total : <?= curency($transaction->total) ?>
        </div>
      <?php endif ?>
    </div>

    <div class="col-md-6">
      <div class="col-md-12 padd-left-0">
        <div>

          <div class="box-checkout-content">
            <div class="payment-method-wrapper table-responsive">
              <table class="table table-striped">
                <tr>
                  <td>Invoice</td>
                  <td>:</td>
                  <td><?= anchor('invoice/show/' . $transaction->invoice_id, $transaction->invoice_id) ?></td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>:</td>
                  <td><?= strtoupper($status->status ? $status->status : '-') ?></td>
                </tr>

                <tr>
                  <td>Purchase Date</td>
                  <td>:</td>
                  <td><?= (new DateTime($transaction->datetime))->format('D, d M Y, H:i:s') ?></td>
                </tr>

                <tr>
                  <td>Shipping Method</td>
                  <td>:</td>
                  <td><?= $shipping_method->method_name ?></td>
                </tr>
                <tr>
                  <td>Payment Method</td>
                  <td>:</td>
                  <td><?= $payment_method->method_name ?></td>
                </tr>
                <tr>
                  <td colspan="3">
                    <a class="btn btn-primary btn-flat btn-add-chart-detail btn-lg" href="<?= base_url('member/order/confirm/' . $transaction->id) ?>">Confirm order</a>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-6">
      <div class="col-md-12 padd-left-0">
        <div>
          <?php if ($transaction->status == Model_transaction_status::PENDING) : ?>

          <?php endif ?>
          <div class="box-checkout-content">
            <div class="payment-method-wrapper table-responsive">
              <table class="table table-striped">
                <tr>
                  <td>User</td>
                  <td>:</td>
                  <td><?= $user->full_name ?></td>
                </tr>
                <tr>
                  <td>Phone</td>
                  <td>:</td>
                  <td><?= $shipping_address->phone ?></td>
                </tr>

                <tr>
                  <td>Country</td>
                  <td>:</td>
                  <td><?php
                      $country = app()->db->get_where('countries', ['id' => $shipping_address->country_id])->row();
                      echo @$country->name
                      ?></td>
                </tr>

                <tr>
                  <td>State</td>
                  <td>:</td>
                  <td><?php
                      $state = app()->db->get_where('states', ['id' => $shipping_address->state_id])->row();
                      echo @$state->name
                      ?></td>
                </tr>

                <tr>
                  <td>City</td>
                  <td>:</td>
                  <td><?php
                      $city = app()->db->get_where('cities', ['id' => $shipping_address->city_id])->row();
                      echo @$city->name
                      ?></td>
                </tr>
                <tr>
                  <td>Address Detail</td>
                  <td>:</td>
                  <td><?= $shipping_address->address_detail ?></td>
                </tr>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-12 ">

      <div class="box-checkout table-responsive">
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
            <?php foreach ($items as $item) :
              $product = $this->model_product->find($item->product_id);
              $product = new Product\Product_single_item($product);
            ?>
              <tr>
                <td width="20">
                  <input type="hidden" name="cartid[]" class="product-selected " value="" checked>
                  <img class="cart-list-img-detail" src="<?= $product->getImageCover() ?>" alt="">

                </td>
                <td>
                  <a href="<?= site_url('product/detail/' . $product->getUrl()) ?>"><?= ucwords(($product->getName())) ?> </a>
                  <div class="cart-product-notes"><small><?= $item->notes ? 'note :' : '' ?> <?= $item->notes  ?></small></div>
                </td>
                <td><?= curency($item->price) ?></td>
                <td>
                  <div class="qty-product-detail-wrapper qty-product-detail-wrapper-cart-page">
                    <div class="col-md-12 padd-left-0">
                      <div class="qty-product-detail-counter">
                        <input type="" name="" class="counter-qty" readonly="" min="1" max="<?= $product->getStock() ?>" value="<?= $item->qty ?>">
                      </div>
                    </div>
                  </div>
                </td>
                <td><?= curency($item->total) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
    </div>

    <div class="col-md-5 col-md-offset-7">
      <div class="col-md-12 padd-right-0">
        <div class="box-checkout">
          <span class="fal fa-money"></span> Detail
          <div class="box-checkout-content">
            <div class="payment-method-wrapper">
              <table class="table table-striped">
                <tr>
                  <td>Subtotal</td>
                  <td>:</td>
                  <td><?= curency($transaction->subtotal) ?></td>
                </tr>
                <tr>
                  <td>Fee</td>
                  <td>:</td>
                  <td><?= curency($transaction->fee) ?></td>
                </tr>
                <tr>
                  <td>Totals</td>
                  <td>:</td>
                  <td><?= curency($transaction->total) ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>
  <?= form_close() ?>

  <script>
    $(function() {

      "use strict";

      $('.delivery-method-item').on('click', function(event) {
        $(this).find('input[type="radio"]').prop('checked', 1);
      });
      $('.payment-method-item').on('click', function(event) {
        $(this).find('input[type="radio"]').prop('checked', 1);
      });
    })
  </script>


  <?= get_footer(); ?>