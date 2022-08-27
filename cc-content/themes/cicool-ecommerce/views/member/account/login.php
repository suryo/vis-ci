<?= get_header(); ?>

<body id="page-top">
  <?= get_navigation(); ?>
  <?= get_view_component('search-nav'); ?>
  <div class="container margin-top-140">
  </div>

  <div class="container ">

    <div class="col-md-6 col-md-offset-3">
      <div class="member-content">
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
            <a href="<?= site_url('member/account/register'); ?>" class="text-center"><?= cclang('register_a_new_membership'); ?></a>

            <br>
            <br>

          </div>
        </div>
      </div>
    </div>
  </div>

  <?= get_footer(); ?>