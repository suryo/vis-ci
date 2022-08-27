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
        <span class="breadcrumb-item"><a href="<?= base_url('') ?>">Home</a></span>
        <span class="breadcrumb-chevron"><span class="fa fa-chevron-right"></span></span>
        <span class="breadcrumb-item-current"><?= $product->category->getName() ?></span>
        <span class="breadcrumb-chevron"><span class="fa fa-chevron-right"></span></span>
        <span class="breadcrumb-item-current"><?= $product->getName() ?></span>
      </div>
    </div>
  </div>

  <div class="button-product-detail-wrapper button-mobile visible-xs">
    <a href="" class="btn btn-primary btn-flat btn-buy-now-detail btn-lg " title="">Buy Now</a>
    <a href="" class="btn btn-primary btn-flat btn-add-chart-detail btn-lg " title=""><img src="<?= theme_asset() ?>img/icon-cart.png" alt=""> </a>
  </div>

  <div class="container ">

    <div class="col-md-4 ">
      <div class="img-product-detail-wrapper" id="image-zoom">
        <img src="<?= $product->getImageCover() ?>" alt="" class="img-product-detail">
      </div>
      <div class="img-product-galery-detail-wrapper">
        <?php $i = 0;
        foreach ($product->getImages() as $image) : ?>

          <div id="image-zoom" class="img-product-galery-wrapper <?= $i == 0 ? 'active' : '' ?>" style="background: url('<?= $image ?>');" data-src="<?= $image ?>">
          </div>
        <?php $i++;
        endforeach ?>
      </div>
    </div>
    <div class="col-md-6">
      <div href="" class="product-detail-title">
        <?= $product->getName() ?>
      </div>
      <div class="rating-product-detail-wrapper">
      </div>
      <div class="price-product-detail-wrapper">
        <span class="price-product-detail"><?= $product->getPriceFormat() ?></span>
      </div>
      <?php if ($product->isPublish()) : ?>
        <?php if ($product->getStock() > 0) : ?>

          <div class="qty-product-detaispan-wrapper">
            <div class="col-md-4 padd-left-0">
              <div class="qty-divider"><b>Quantity</b></div>
              <div class="qty-product-detail-counter">
                <a href="" class="button-qty-min" title=""><span class="fal fa-minus-circle"></span></a>
                <input type="" name="" class="counter-qty" readonly="" min="<?= $product->getMinimumOrder() ?>" max="<?= $product->getStock() ?>" value="<?= $product->getStock() ? $product->getMinimumOrder() : $product->getStock() ?>">
                <a href="" class="button-qty-plus" title=""><span class="fal fa-plus-circle"></span></a>
              </div>
            </div>
            <div class="col-md-8 padd-left-0">
              <div class="qty-divider"><b>Notes For Merchant</b></div>
              <textarea class="notes-for-merchant" name="" placeholder="Example : white color, large size"></textarea>
              <div class="notes-info"><span class="current-char">0</span>/140 character</div>
            </div>
          </div>
          <div class="row"></div>
          <div class="button-product-detail-wrapper hidden-xs">
            <a href="" class="btn btn-primary btn-flat btn-add-chart-detail btn-lg " title=""><img src="<?= theme_asset() ?>img/icon-cart.png" alt=""> Add To Chart</a>
            <a href="" class="btn btn-primary btn-flat btn-buy-now-detail btn-lg " title="">Buy Now</a>
          </div>
        <?php else : ?>
          <div class="col-md-5 padd-left-0 margin-top-30">
            <div class="alert alert-warning">
              Product out of stock
            </div>
          </div>
        <?php endif ?>
      <?php else : ?>
        <div class="col-md-5 padd-left-0 margin-top-30">
          <div class="alert alert-warning">
            Product not avaiable
          </div>
        </div>
      <?php endif ?>
    </div>
    <div class="col-md-2">
      <div class="box-share-product-detail">
      </div>

      <div class="box-merchant-product-detail">
        <center>

          <img src="<?= $product->merchant->getAvatar() ?>" height="30px" class="img-merchant-product-detail" alt="">
        </center>
        <div>
          <center>

            <a href="" class="merchant-name" title=""><?= $product->merchant->getName() ?></a>
            <!-- <div href="" class="merchant-location" title=""><span class="fal fa-map-marker"></span> Melborn</div> -->
            <div href="" class="merchant-last-online" title=""><span class="fal fa-clock-o"></span> <?= $product->merchant->getHumanLastLogin() ?></div>
          </center>
        </div>
      </div>

      <!--  <div class="box-promotion">
      <b>Promo</b>
    </div> -->
    </div>

    <div class="col-md-12">
      <div class="product-detail-tab-wrapper">
        <div role="tabpanel ">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#home" aria-controls="home" role="tab" data-toggle="tab"><span class="fal fa-list-alt icon-tab"></span> Product Information</a>
            </li>
            <!--  <li role="presentation">
             <a href="#review" aria-controls="review" role="tab" data-toggle="tab"><span class="fal fa-star icon-tab"></span> Reviews</a>
           </li> -->
            <!-- <li role="presentation">
              <a href="#discussion" aria-controls="discussion" role="tab" data-toggle="tab"><span class="fal fa-comments-o icon-tab"></span> Product Discussion</a>
            </li> -->
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
              <?= $product->getDescription() ?>
            </div>
            <!-- <div role="tabpanel" class="tab-pane" id="review">
             <div class="review-wrapper">
            
                 <div class="review-item-wrapper">
                  <div class="review-item-head">
                    <div class="review-star">
                      <span class="fal fa-star"></span>
                      <span class="fal fa-star"></span>
                      <span class="fal fa-star"></span>
                      <span class="fal fa-star muted"></span>
                      <span class="fal fa-star muted"></span>
                    </div>
                    <div class="review-tile">by <b>Muhamad Ridwan</b> <i class="review-date">19 dec</i></div>
                    <div class="review-content">Great product</div>
                  </div>
                  <div class="review-item-foot">
                    help you ? <a href="" title="" class="btn-help-review"><span class="fal fa-thumbs-up"></span></a>
                  </div>
                </div>
            
            
              </div> 
            </div> -->
            <div role="tabpanel" class="tab-pane" id="discussion">...</div>
          </div>
        </div>
      </div>

    </div>

  </div>


  <div class="container margin-top-30">
    <div class="col-md-12">
      <div class="product-related-title">Related Product</div>
    </div>
    <?php foreach ($this->model_product->get(null, null, 6) as $prod) : ?>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <?= get_view_component('product-single-item', ['product' => $prod]) ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="container margin-top-30">
    <div class="col-md-12">
      <div class="product-related-title">Other Product In Store</div>
    </div>
    <?php foreach ($this->model_product->get(null, null, 6) as $prod) : ?>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <?= get_view_component('product-single-item', ['product' => $prod]) ?>
      </div>
    <?php endforeach; ?>
  </div>

  <style type="">
    body {
    background: #fff;
  }

  .product-item {
    border: 1px solid #C9C9C9;
  }
</style>

  <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
  <script src="<?= theme_asset() ?>js/plugin/zoom/jquery.zoom.min.js"></script>
  <script>
    var product = <?= json_encode($product->toArray()) ?>;

    $(function() {

      $('#image-zoom').zoom();

      $('.img-product-galery-wrapper').on('hover, click', function(event) {
        $('.img-product-galery-wrapper').removeClass('active')
        $(this).addClass('active')
        var src = $(this).data('src');
        $('.img-product-detail').animate({
            opacity: 0.1,
          },
          200,
          function() {
            $('.img-product-detail, .zoomImg').attr('src', src);
            $('.img-product-detail').animate({
                opacity: 1
              },
              200);
          });
      });

      $(document).on('click', 'a.btn-add-chart-detail, a.btn-buy-now-detail', function(event) {
        event.preventDefault();
        var notes = $('.notes-for-merchant').val();
        var qty = $('.counter-qty').val();
        var _this = $(this);
        $.ajax({
            url: window.base_url + 'product/add_cart',
            type: 'GET',
            dataType: 'JSON',
            data: {
              product: product.id,
              qty: qty,
              notes: notes,
            },
          })
          .done(function(res) {
            if (res.status) {
              if (_this.hasClass('btn-buy-now-detail')) {
                window.location.href = window.base_url + 'cart/';
              } else {
                showSnack('Product added to cart.');
              }
              getCart()
            }
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
      });


      autosize($('.notes-for-merchant'));
      $('.notes-for-merchant').keydown(function(event) {
        var char = $(this).val();
        var length = char.length;
        if (length > 139) {
          $(this).val(char.substring(0, 139));
        }
        var length = char.length;
        $('.current-char').html(length);

      });

      $('.button-qty-plus').on('click', function(event) {
        event.preventDefault();
        var current = parseInt($('.counter-qty').val());
        var min = $('.counter-qty').attr('min');
        var max = $('.counter-qty').attr('max');
        if (Number.isNaN(current)) {
          $('.counter-qty').val(0);
        } else {
          if (current < max) {
            $('.counter-qty').val(current += 1);
          }
        }

      });
      $('.button-qty-min').on('click', function(event) {
        event.preventDefault();
        var min = $('.counter-qty').attr('min');
        var max = $('.counter-qty').attr('max');
        var current = parseInt($('.counter-qty').val());
        if (Number.isNaN(current)) {
          $('.counter-qty').val(0);
        } else {
          if (current > min) {
            $('.counter-qty').val(current -= 1);
          }
        }

      });

    })
  </script>
  <?= get_footer(); ?>