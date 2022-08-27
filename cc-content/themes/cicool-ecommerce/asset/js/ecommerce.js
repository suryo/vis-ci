
function number_format(number, decimals, dec_point, thousands_sep) {
  // Strip all characters but numerical ones.
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 2 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function currency(number) {
  return number ? window.config.ecommerce_currency + '' + number_format(
    number,
    window.config.ecommerce_decimals,
    window.config.ecommerce_decimal_separator,
    window.config.ecommerce_thousand_separator
  ) : 'FREE';
}

function getCart() {

  $.ajax({
    url: window.base_url + 'product/cart',
    type: 'GET',
    dataType: 'JSON',
    data: {

    },
  })
    .done(function (res) {
      console.log(res)
      if (res.status) {
        let html = ejs.render(`
              <% if (cart.length == 0) { %>

               <center>
               <img class="img-chart" src="`+ window.theme_asset + `img/bag.svg" alt="">
               <div class="cart-empty-label">Cart is Empty</div>
               </center>
              <% } %>

             <div class="cart-item-content">
                <% cart.forEach(function(item){ %>
                  <div class="cart-item">
                    <div class="col-xs-3"><img src="`+ window.base_url + `/uploads/product/<%= item.detail.image.split(',')[0] %>" alt=""></div>
                    <div class="col-xs-6">
                        <div class="cart-product-name"><a href="`+ window.base_url + `product/detail/<%= item.detail.url %>"><%= item.name %></a></div>
                        <div class="cart-product-price"><%= currency(item.price) %></div>
                        <div class="cart-product-notes"><small><%= item.options.notes ? 'note :' : '' %> <%= item.options.notes %></small></div>
                    </div>
                    <div class="col-xs-3">
                        <div><small>Qty : <%= item.qty %></small></div>
                        <div><a href="#" class="btn btn-remove-cart-item" data-product-id="<%= item.rowid %>"><span class="fal fa-trash"></span></a></div>
                    </div>
               </div>
                <% }); %>
                
           </div>
           <% if (cart.length != 0) { %>
            
           <div class="cart-footer">
                <div class="row-fluid">
                    <div class="pull-left">
                       Cart Total: <span class="cart-price-total"><%= currency(total) %></span>
                   </div>
                   <div class="pull-right">
                       <a href="`+ window.base_url + `cart" class=" btn-show-all-cart">Show All Cart</a>
                   </div>
                </div>
           </div>
           <% } %>
            `,
          {
            cart: res.cart.list,
            total: res.cart.total,
            currency: function (value) {
              return currency(value);
            }
          });


        $('.cart-item-wrapper').html(html);

        $('.cart-counter').html(res.cart.total_items)
      }
    })
    .fail(function () {
      console.log("error");
    })
    .always(function () {
      console.log("complete");
    });
}

function showSnack(text) {
  Snackbar.show({ text: text, pos: 'bottom-center' });
}

$(function () {
  getCart()

  $(document).on('click', 'a.btn-remove-cart-item', function (event) {
    event.preventDefault();
    let id = $(this).attr('data-product-id');
    $.get(window.base_url + '/cart/remove/' + id, function (data, textStatus, xhr) {
      showSnack('Product remove from cart.');
      getCart()
    });
  });

  /*show loading*/
  $.fn.loader = function (opsi) {
    $(this).html('<span class="loading loading-hide pull-right padding-10"><img src="' + BASE_URL + 'asset/img/loading-spin-primary.svg"> <i>Loading, Submitting Data</i></span>');
  };

  /*print message*/
  $.fn.printMessage = function (opsi) {
    var opsi = $.extend({
      type: 'success',
      message: 'Success',
      timeout: 500000
    }, opsi);

    $(this).hide();
    $(this).html(' <div class="col-md-12 message-alert" ><div class="alert alert-' + opsi.type + '"><h4>' + opsi.type + '!  <a href="#" class="close pull-right" >&times;</a></h4>' + opsi.message + '</div></div>');
    $(this).show();
    // Run the effect
    setTimeout(function () {
      $('.message-alert').fadeOut();
    }, opsi.timeout);

    var parentElem = $(this);

    $(this).find('.message-alert .close').on('click', function (event) {
      event.preventDefault();
      parentElem.html('');
    });
  };

  var imageURLs = $('.product-item .product-image');
  imageURLs.each(function (index, element) {
    var imageURL = $(element).css('background-image').replace('url("', '').replace('")', '');
    if (imageURL != "none") {
      $.ajax({
        url: imageURL,
        type: 'HEAD',
        error: function () {
          $(element).attr('style', "background-image:url('" + window.theme_asset + "/img/no-image.png'); background-size: contain; background-repeat: no-repeat; ")
        }
      });
    }
  });

  $('.cart-list-img-detail').error(function () {
    $(this).attr('src', window.theme_asset + "/img/no-image.png")
  });

})
