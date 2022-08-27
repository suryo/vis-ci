<section class="content-header">
   <h1>
      Transaction <small><?= cclang('detail', ['Transaction']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('member/order'); ?>">Transaction</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <div class="box box-widget widget-user-2">
                  <div class="widget-user-header ">
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/view.png" alt="User Avatar">
                     </div>

                     <h3 class="widget-user-username">Transaction</h3>
                     <h5 class="widget-user-desc">Detail Transaction</h5>
                     <hr>
                  </div>

                  <div class="form-horizontal form-step" name="form_transaction" id="form_transaction">

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($transaction->id); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Invoice Id </label>

                        <div class="col-sm-8">
                           <?= _ent($transaction->invoice_id); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Status </label>

                        <div class="col-sm-8">
                           <?= _ent($transaction->transaction_status_status); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Subtotal </label>

                        <div class="col-sm-8">
                           <?= curency($transaction->subtotal); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Fee </label>

                        <div class="col-sm-8">
                           <?= curency($transaction->fee); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Total </label>

                        <div class="col-sm-8">
                           <?= curency($transaction->total); ?>
                        </div>
                     </div>

                     <br>
                     <br>


                     <div class="col-md-12 ">

                        <div class="box-checkout">
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
            </div>
         </div>
      </div>
   </div>
</section>