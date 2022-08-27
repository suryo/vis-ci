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
            <a href="#"><b><?= cclang('register'); ?></b> </a>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <p class="login-box-msg"><?= cclang('register_a_new_membership'); ?></p>
            <?php if (isset($error) and !empty($error)) : ?>
              <div class="callout callout-error">
                <h4><?= cclang('error'); ?>!</h4>
                <p><?= $error; ?></p>
              </div>
            <?php endif; ?>
            <?= form_open('', [
              'name'    => 'form_login',
              'id'      => 'form_login',
              'method'  => 'POST'
            ]); ?>
            <div class="form-group has-feedback <?= form_error('full_name') ? 'has-error' : ''; ?>">
              <label>Full Name </label>
              <input class="form-control" placeholder="Full Name" name="full_name" value="<?= set_value('full_name'); ?>">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback <?= form_error('username') ? 'has-error' : ''; ?>">
              <label>Username <span class="required">*</span> </label>
              <input class="form-control" placeholder="Username" name="username" value="<?= set_value('username'); ?>">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback <?= form_error('email') ? 'has-error' : ''; ?>">
              <label>Email <span class="required">*</span> </label>
              <input type="email" class="form-control" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback <?= form_error('password') ? 'has-error' : ''; ?>">
              <label>Password <span class="required">*</span> </label>
              <input type="password" class="form-control" placeholder="Password" name="password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <?php $cap = get_captcha(); ?>
            <div class="form-group <?= form_error('email') ? 'has-error' : ''; ?>">
              <label><?= cclang('human_challenge'); ?> <span class="required">*</span> </label>
              <div class="captcha-box" data-captcha-time="<?= $cap['time']; ?>">
                <input type="text" name="captcha" placeholder="">
                <a class="btn btn-flat  refresh-captcha  "><i class="fa fa-refresh text-danger"></i></a>
                <span class="box-image"><?= $cap['image']; ?></span>
              </div>
            </div>
            <small class="info help-block">
            </small>
            <div class="row">
              <div class="col-xs-8">
                <div class="checkbox icheck">
                  <label>
                    <input type="checkbox" name="agree" value="1"> <?= cclang('i_agree_to_the_terms'); ?>
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat"><?= cclang('register'); ?></button>
              </div>
              <!-- /.col -->
            </div>
            <?= form_close(); ?>

            <!-- /.social-auth-links -->

            <a href="<?= site_url('member/account/login'); ?>" class="text-center"><?= cclang('i_already_a_new_membership'); ?></a>

          </div>
          <!-- /.login-box-body -->
        </div>
      </div>
    </div>
  </div>


  <script>
    $(function() {
      var BASE_URL = "<?= base_url(); ?>";

      $.fn.printMessage = function(opsi) {
        var opsi = $.extend({
          type: 'success',
          message: 'Success',
          timeout: 500000
        }, opsi);

        $(this).hide();
        $(this).html(' <div class="col-md-12 message-alert" ><div class="callout callout-' + opsi.type + '"><h4>' + opsi.type + '!</h4>' + opsi.message + '</div></div>');
        $(this).slideDown('slow');
        // Run the effect
        setTimeout(function() {
          $('.message-alert').slideUp('slow');
        }, opsi.timeout);
      };

      $('.refresh-captcha').on('click', function() {
        var capparent = $(this);

        $.ajax({
            url: BASE_URL + '/captcha/reload/' + capparent.parent('.captcha-box').attr('data-captcha-time'),
            dataType: 'JSON',
          })
          .done(function(res) {
            capparent.parent('.captcha-box').find('.box-image').html(res.image);
            capparent.parent('.captcha-box').attr('data-captcha-time', res.captcha.time);
          })
          .fail(function() {
            $('.message').printMessage({
              message: 'Error getting captcha',
              type: 'warning'
            });
          })
          .always(function() {});
      });
    });
  </script>
  <?= get_footer(); ?>