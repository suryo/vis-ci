<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= get_option('site_description'); ?>">
  <meta name="keywords" content="<?= get_option('keywords'); ?>">
  <meta name="author" content="<?= get_option('author'); ?>">

  <title> <?= isset($title) ? $title : site_name() ?></title>

  <link href="<?= theme_asset(); ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?= theme_asset(); ?>/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

  <link href="<?= theme_asset(); ?>/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>toastr/build/toastr.css">

  <link href="<?= theme_asset(); ?>/css/creative.css" rel="stylesheet">
  <link href="<?= theme_asset(); ?>/css/ecommerce.css?e=202007131449" rel="stylesheet">
  <link href="<?= theme_asset(); ?>/css/fa-light.css" rel="stylesheet">
  <link href="<?= theme_asset(); ?>/js/plugin/snackbar/snackbar.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/morris/morris.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>flag-icon/css/flag-icon.css" rel="stylesheet" media="all" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  <script src="<?= theme_asset(); ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?= theme_asset(); ?>/js/plugin/snackbar/snackbar.min.js"></script>
  <script src="<?= theme_asset(); ?>/js/ecommerce.js?e=202007131449"></script>

  <script src="<?= theme_asset(); ?>/js/ejs.min.js"></script>
  <script src="<?= BASE_ASSET ?>toastr/toastr.js"></script>

  <script>
    window.is_mobile = <?= (int)app()->agent->is_mobile(); ?>;
    window.base_url = '<?= base_url() ?>';
    window.theme_asset = '<?= theme_asset() ?>';
    window.config = {
      'ecommerce_decimals': '<?= get_option("ecommerce_decimals") ?>',
      'ecommerce_thousand_separator': '<?= get_option("ecommerce_thousand_separator") ?>',
      'ecommerce_decimal_separator': '<?= get_option("ecommerce_decimal_separator") ?>',
      'ecommerce_currency': '<?= get_option("ecommerce_currency") ?>',
    }

    console.log(window.config);
    var csrf = '<?= $this->security->get_csrf_token_name(); ?>';
    var token = '<?= $this->security->get_csrf_hash(); ?>';

    $(document).ready(function() {

      toastr.options = {
        "positionClass": "toast-top-center",
      }

      var f_message = '<?= $this->session->flashdata('f_message'); ?>';
      var f_type = '<?= $this->session->flashdata('f_type'); ?>';

      if (f_message.length > 0) {
        /*toastr[f_type](f_message);*/
        showSnack(f_message)
      }
    });
  </script>


</head>