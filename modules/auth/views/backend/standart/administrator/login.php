<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= get_option('site_name') ?> | Log in</title>
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
      <a href=""><b><?= cclang('login'); ?></b> <?= get_option('site_name'); ?></a>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg"><?= cclang('sign_to_start_your_session'); ?></p>
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
        'name'    => 'form_login',
        'id'      => 'form_login',
        'method'  => 'POST'
      ]); ?>
      <div class="form-group has-feedback <?= form_error('username') ? 'has-error' : ''; ?>">
        <input type="email" class="form-control" placeholder="Email" name="username" value="<?= set_value('username', 'admin@admin.com'); ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback <?= form_error('password') ? 'has-error' : ''; ?>">
        <input type="password" class="form-control" placeholder="Password" name="password" value="admin123">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" value="1"> <?= cclang('remember_me'); ?>
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><?= cclang('sign_in'); ?></button>
        </div>
      </div>
      <?= form_close(); ?>

      <a href="<?= site_url('administrator/forgot-password'); ?>"><?= cclang('i_forgot_my_password'); ?></a><br>
      <a href="<?= site_url('administrator/register'); ?>" class="text-center"><?= cclang('register_a_new_membership'); ?></a>

      <br>
      <br>
      <p align="center"><b>-<?= cclang('or') ?>-</b></p>
      <a href="<?= site_url('oauth/v/google'); ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google"></i> <?= cclang('sign_in_using') ?> Google+</a>

    </div>
  </div>

  <script src="<?= BASE_ASSET ?>admin-lte/plugins/jQuery/jquery-3.6.0.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= BASE_ASSET ?>admin-lte/plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {

      "use strict";

      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      });
    });
  </script>

</body>

</html>