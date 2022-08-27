<link rel="stylesheet" href="<?= BASE_ASSET ?>css/wizzard.css" rel="stylesheet" />

<section class="content-header">
  <h1>
    <?= cclang('wizzard_setup'); ?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('wizzard'); ?></a></li>
    <li ><?= cclang('setup'); ?></li>
    <li class="active"><?= cclang('setup_is_completed'); ?></li>
  </ol>
</section>

<section class="content">
  <div class="box box-warning">
    <div class="box-body">
      <div class="box box-widget widget-user-2">
        <div class="widget-user-header bg-yellow">
          <div class="widget-user-image">
            <img class="img-circle" src="<?= BASE_ASSET . 'img/cloud.png'; ?>" alt="User Avatar">
          </div>
          <h3 class="widget-user-username"><?= cclang('setup_is_completed'); ?></h3>
        </div>
      </div>

      <div class="callout callout-success">
        <h4><?= cclang('success'); ?>!</h4>
        <p><?= cclang('database_has_been_installed__the_page_administrator'); ?></p>
      </div>
      <hr>
      <div class="col-md-2 padd-left-0">
      </div>
      <div class="col-md-8">
        <center>
          <div class="step">
            <div class="line">
              <div class="round-step success"></div>
              <div class="round-step success two"></div>
              <div class="round-step success third"></div>
            </div>
          </div>
        </center>
      </div>
      <div class="col-md-2" style="padding-left: 0px !important; ">
        <a href="<?= site_url('administrator/login'); ?>" class="btn bg-green margin btn-lg btn-block"> <?= cclang('finish'); ?></a>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

  <?= form_close(); ?>
</section>