<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= get_option('site_name'); ?> | Forgot Password</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>font-awesome-4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?= BASE_ASSET ?>css/auth.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b><?= cclang('login'); ?></b></a>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg"><?= cclang('send_me_link_to_reset_password'); ?></p>
      <?php if (isset($error) and !empty($error)) : ?>
        <div class="callout callout-error">
          <h4><?= cclang('error'); ?>!</h4>
          <p><?= $error; ?></p>
        </div>
      <?php endif; ?>
      <?php
      $message = $this->session->flashdata('f_message');
      $type = $this->session->flashdata('f_type');
      if ($message) :
      ?>
        <div class="callout callout-<?= $type; ?>">
          <p><?= $message; ?></p>
        </div>
      <?php endif; ?>
      <?= form_open('', [
        'name'    => 'form_forgot_password',
        'id'      => 'form_forgot_password',
        'method'  => 'POST'
      ]); ?>
      <div class="form-group has-feedback <?= form_error('email') ? 'has-error' : ''; ?>">
        <label><?= cclang('email') ?> <span class="required">*</span> </label>
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <?php $cap = get_captcha(); ?>
      <div class="form-group <?= form_error('email') ? 'has-error' : ''; ?>">
        <label><?= cclang('human_challenge'); ?> <span class="required">*</span> </label>
        <div class="captcha-box" data-captcha-time="<?= $cap['time']; ?>">
          <input type="text" name="captcha" placeholder="">
          <a class="btn btn-flat  refresh-captcha  "><i class="fa fa-refresh text-danger"></i></a>
          <span class="box-image"><?= $cap['image']; ?></span>
        </div>
        <small class="info help-block">
        </small>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><?= cclang('reset'); ?></button>
        </div>
      </div>
      <?= form_close(); ?>

      <a href="<?= site_url('administrator/register'); ?>" class="text-center"><?= cclang('register_a_new_membership'); ?></a>

    </div>
  </div>
  <script>
    var BASE_URL = "<?= base_url(); ?>";
  </script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/jQuery/jquery-3.6.0.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/iCheck/icheck.min.js"></script>
  <script src="<?= BASE_ASSET ?>js/page/auth/forgot-password.js"></script>

</body>

</html>