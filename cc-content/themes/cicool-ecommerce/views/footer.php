<?= get_option('ecommerce_footer_html') ?>

<script>
    $(function() {
        $(window).scroll(function(event) {
            if ($(window).scrollTop() > 160) {
                $('.navbar-search').css('marginTop', 0);
                $('.navbar-search').css('z-index', 99999999);
                //$('.header-first-top').slideUp('fast');
            } else {
                $('.navbar-search').css('z-index', 99999);
                $('.navbar-search').animate({
                    marginTop: 27
                }, 10);
                //$('.header-first-top').slideDown('fast');
            }
        });

        $('.search-product').focusin(function(event) {
            $('.search-result-container,.menu-category-wrapper').show();
            $('.menu-category-container').hide();
        });
        $('.search-product').focusout(function(event) {
            setTimeout(function() {
                $('.search-result-container,.menu-category-wrapper').hide();
            }, 250);
        });

        $('.btn-cart, .cart-item-wrapper').on('mouseover', function() {
            $('.cart-item-wrapper').show();
        }, function(event) {
            $('.cart-item-wrapper').hide();
        });

        $('.menu-bar').on('click', function(event) {
            event.preventDefault();
            var toggle = $(this).data('toggle');

            if (toggle == '0' || toggle == undefined) {
                $(this).data('toggle', 1);
                $('.menu-category-container, .menu-category-wrapper').show();
                setTimeout(function() {
                    $('.menu-category-wrapper').show();
                }, 252);
            } else {
                $(this).data('toggle', 0);
                $('.menu-category-container, .menu-category-wrapper').hide();
            }
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.menu-bar').length) {
                $('.menu-category-container').hide();
                if (!$(event.target).closest('.search-product').length) {
                    $('.menu-category-wrapper').hide();
                }
            }
        });
    })
</script>

<script type="text/javascript">
    var base_url = '<?= base_url() ?>';

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle) return true;
        }
        return false;
    }
    $(function() {
        var id_int = null;

        function search() {
            $.ajax({
                    url: base_url + 'product/search',
                    dataType: 'JSON',
                    data: {
                        q: $('.search-product').val()
                    },
                })
                .done(function(res) {
                    var product_search = ``;
                    $.each(res.product, function(index, val) {
                        var product_name_ex = val.product_name.split(' ');
                        var terms = $('.search-product').val().toLowerCase().split(' ');
                        var product_name_ex_string = ``;
                        $.each(product_name_ex, function(index, val) {
                            product_name_ex_string += `<span class="search-item-` + val + ` ` + (inArray(val.toLowerCase(), terms) ? ' search-highlight' : '') + `">` + val + `</span> `;
                        });
                        product_search += `
                    <li>
                        <a class="find-in-all-cat-btn" href="` + base_url + `product/all?q=` + $('.search-product').val() + `" title="">
                        Search ` + $('.search-product').val() + ` <div class="search-desc">in all category</div>
                        </a>
                    </li>`;
                        product_search += `
                    <li>
                        <a href="` + base_url + `product/all?q=` + val.product_name + `" title="">
                        ` + product_name_ex_string + (val.category_name ? ` <div class="search-desc">in ` + val.category_name + `</div>` : '') + `
                        </a>
                    </li>`;
                    });
                    if (res.product.length == 0) {
                        product_search += `
                    <li>
                        <a href="#" title="">
                        Search for : ` + $('.search-product').val() + ` <div class="search-desc">0 results</div>
                        </a>
                    </li>`;
                    }
                    var tpl_product = ` <ul class="result-product">
                  ` + product_search + `
                </ul>
               `;

                    var merchant = ` <div class="search-result-title">
                    MERCHANT
                </div>
                <ul class="result-merchant">
                    <li>
                        <a href="" title="">
                            <center>
                                
                        <img src="https://cf.shopee.co.id/file/f8afcd66cc257066b034c1b9551248c3_tn">  <div class="search-desc">in man fashion</div>
                            </center>
                        </a>
                    </li>
                </ul>`;
                    $('.search-result-container').html(tpl_product);
                })

                .fail(function() {})
                .always(function() {
                    console.log("complete");
                });
        }
        $('.search-product').keyup(function(event) {
            clearTimeout(id_int);
            id_int = setTimeout(function() {
                if ($('.search-product').val().length > 1) {
                    search();
                }
            }, 1000);
        });
        $('.search-product').focus(function(event) {
            clearTimeout(id_int);
            id_int = setTimeout(function() {
                if ($('.search-product').val().length > 1) {
                    search();
                }
            }, 1000);
        });
        $('.search-product').keypress(function(event, key) {
            if (event.keyCode == 13) {

            }
        });
    })
</script>


<script src="<?= theme_asset(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>


</body>

</html>