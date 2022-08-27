<?= get_header(); ?>

<body id="page-top">
  <?= get_navigation(); ?>
  <?= get_view_component('search-nav'); ?>
  <div class="container margin-top-140">
  </div>
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>font-awesome-4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/morris/morris.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>sweet-alert/sweetalert.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>toastr/build/toastr.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>fancy-box/source/jquery.fancybox.css?v=2.1.5" media="screen" />
  <link rel="stylesheet" href="<?= BASE_ASSET ?>chosen/chosen.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>datetimepicker/jquery.datetimepicker.css" />
  <link rel="stylesheet" href="<?= BASE_ASSET ?>js-scroll/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <?= $this->cc_html->getCssFileTop(); ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script src="<?= BASE_ASSET ?>admin-lte/plugins/jQuery/jquery-3.6.0.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/iCheck/icheck.min.js"></script>
  <script src="<?= BASE_ASSET ?>sweet-alert/sweetalert-dev.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script src="<?= BASE_ASSET ?>toastr/toastr.js"></script>
  <script src="<?= BASE_ASSET ?>fancy-box/source/jquery.fancybox.js?v=2.1.5"></script>
  <script src="<?= BASE_ASSET ?>datetimepicker/build/jquery.datetimepicker.full.js"></script>
  <script src="<?= BASE_ASSET ?>editor/dist/js/medium-editor.js"></script>
  <script src="<?= BASE_ASSET ?>js/cc-extension.js"></script>
  <script src="<?= BASE_ASSET ?>js/cc-page-element.js"></script>

  <script src="<?= BASE_ASSET ?>stepper/jquery.steps.min.js"></script>

  <script>
    var BASE_URL = "<?= base_url(); ?>";
    var HTTP_REFERER = "<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/'; ?>";
    var csrf = '<?= $this->security->get_csrf_token_name(); ?>';
    var token = '<?= $this->security->get_csrf_hash(); ?>';

    $(document).ready(function() {

      toastr.options = {
        "positionClass": "toast-top-center",
      }

      var f_message = '<?= $this->session->flashdata('f_message'); ?>';
      var f_type = '<?= $this->session->flashdata('f_type'); ?>';

      if (f_message.length > 0) {
        toastr[f_type](f_message);
      }
    });
  </script>

  <div class="container ">
    <div class="col-md-2">
      <div>
        <ul class="member-menu">
          <?php $active = $this->uri->segment('2') ?>
          <li><a href="<?= base_url('member/account') ?>" class="<?= $active == 'account' ? 'active' : ''  ?>">
              <div class="icon-member-menu-wrap"><span class="fal fa-user icon-member-menu"></span></div> My Account
            </a></li>
          <li><a href="<?= base_url('member/shipping') ?>" class="<?= $active == 'shipping' ? 'active' : ''  ?>">
              <div class="icon-member-menu-wrap"><span class="fal fa-map-marker icon-member-menu"></span></div> Address
            </a></li>
          <li><a href="<?= base_url('member/order') ?>" class="<?= $active == 'order' ? 'active' : ''  ?>">
              <div class="icon-member-menu-wrap"><span class="fal fa-shopping-cart icon-member-menu"></span></div> My Order
            </a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-10">
      <div class="member-content">
        <?= $template['partials']['content']; ?>
      </div>
    </div>
  </div>
  <script src="<?= BASE_ASSET ?>js/chosen.jquery.min.js" type="text/javascript"></script>
  <script src="<?= BASE_ASSET ?>jquery-ui/jquery-ui.js"></script>
  <script src="<?= BASE_ASSET ?>jquery-switch-button/jquery.switchButton.js"></script>
  <script src="<?= BASE_ASSET ?>js/jquery.ui.touch-punch.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/fastclick/fastclick.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/dist/js/app.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/dist/js/adminlte.js"></script>
  <script src="<?= BASE_ASSET ?>js-scroll/script/jquery.jscrollpane.min.js"></script>
  <script src="<?= BASE_ASSET ?>jquery-switch-button/jquery.switchButton.js"></script>




  <script src="<?= BASE_ASSET ?>js/custom.js"></script>
  <?= get_footer(); ?>