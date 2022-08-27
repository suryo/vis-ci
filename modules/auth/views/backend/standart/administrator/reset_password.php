<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= get_option('site_name'); ?> | Reset Password</title>
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
            <a href="#"><b><?= cclang('reset_password'); ?></b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg"><?= cclang('reset_your_password'); ?></p>
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
                'name'    => 'form_reset_password',
                'id'      => 'form_reset_password',
                'method'  => 'POST'
            ]); ?>
            <div class="form-group has-feedback <?= form_error('password') ? 'has-error' : ''; ?>">
                <label><?= cclang('password') ?> <span class="required">*</span> </label>
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback <?= form_error('password_confirmation') ? 'has-error' : ''; ?>">
                <label><?= cclang('password_confirmation') ?> <span class="required">*</span> </label>
                <input type="password" class="form-control" placeholder="Password Confirmation" name="password_confirmation">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-8">

                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat"><?= cclang('reset'); ?></button>
                </div>
            </div>
            <?= form_close(); ?>

        </div>
    </div>

    <script>
        "use strict";

        var BASE_URL = "<?= base_url(); ?>";
    </script>
    <script src="<?= BASE_ASSET ?>admin-lte/plugins/jQuery/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_ASSET ?>admin-lte/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= BASE_ASSET ?>admin-lte/plugins/iCheck/icheck.min.js"></script>
    <script src="<?= BASE_ASSET ?>js/page/auth/forgot-password.js"></script>
</body>

</html>