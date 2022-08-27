<section class="content-header">
  <h1>
    Extension<small><?= cclang('list_all'); ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Extension</li>
  </ol>
</section>

<section class="content">

  <div class="row">

    <div class="col-md-12">
      <div>

        <?php foreach ($extensions as $extension) :
          list($cicool, $regid) = explode('/', $extension->path);
          $logo = BASE_ASSET . 'img/icon-80x80.png';
        ?>
          <div class="col-md-6 nopadding">
            <div class="box-extension  clearfix">
              <div class="extension-body">
                <div class="col-md-3">
                  <img src="<?= empty($extension->icon) ? $logo :  $extension->icon  ?>" width="90" height="90">
                </div>
                <div class="col-md-6">
                  <div class="extension-title"><a target="blank" href="<?= ('https://github.com/' . $extension->path) ?>"><?= $extension->name ?></a></div>
                  <p><?= $extension->description ?></p>
                  <i>by : <a href="#">Muhamad Ridwan</a></i>
                  <br>
                  <?php
                  $equals = preg_match('/(>=|<=)/', $extension->compatible, $matches);
                  $version = preg_replace('/(>=|<=|=)/', '', $extension->compatible);
                  $operator = isset($matches[0]) ? $matches[0] : '==';
                  $compatible = eval(' return "' . VERSION . '" ' . $operator . ' "' . $version . '";');
                  ?>

                  <?php if ($compatible) : ?>
                    <small><i class="fa fa-check text-success"></i> compatible for your cicool version</small>
                  <?php else : ?>
                    <small><i class="fa fa-times"></i> not compatible requirement <?= $extension->compatible ?></small>
                  <?php endif ?>
                  <br>

                </div>
                <div class="col-md-3">
                  <?php
                  if (in_array($regid, $extension_installed)) {
                    $classUpdate = '';
                    $classInstall = 'display-none';
                  } else {
                    $classInstall = '';
                    $classUpdate = 'display-none';
                  }

                  if (!$compatible) {
                    $classInstall = 'display-none';
                    $classUpdate = 'display-none';
                  }
                  $up_to_date = true;
                  if (in_array($regid, $extension_installed)) {
                    $path = EXTENSION_PATH . $regid . '/ext.json';
                    if (is_file($path)) {
                      $file = file_get_contents($path);
                      $file = json_decode($file);
                      $current_version = $file->version;
                      if ($extension->version !== $current_version) {
                        $up_to_date = false;
                      } else {
                        $classInstall = 'display-none';
                        $classUpdate = 'display-none';
                      }
                    }
                  }
                  if (!in_array($regid, $extension_installed)) {
                    $classUpdate = 'display-none';
                  }
                  ?>

                  <?php if ($up_to_date == false) : ?>
                    <a href="" data-href="<?= site_url('administrator/extension/update?ex=' . $extension->path) ?>" class="btn btn-sm btn-default btn-flat pull-right btn-update-extension <?= $classUpdate ?>">Update Now</a>
                  <?php endif ?>
                  <a href="" data-href="<?= site_url('administrator/extension/install?ex=' . $extension->path) ?>" class="  btn btn-sm btn-default btn-flat pull-right btn-install-extension <?= $classInstall ?>">Install Now</a>
                  <a href="<?= site_url('administrator/extension/activation?ex=' . $regid) ?>" class="  btn btn-sm btn-primary btn-flat pull-right btn-active-extension <?= $classInstall ?>">Activate</a>

                  <?php if ($up_to_date) : ?>
                    <a href="#" class="  btn btn-sm btn-default disabled  btn-flat pull-right display-none">Is up to date</a>

                  <?php endif ?>

                </div>
                <div class="row-fluid">
                  <div class="col-md-12 padding-0">
                    <center>
                      <div class="hide progress-download-extension"></div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach ?>


      </div>
    </div>
  </div>
</section>

<script src="<?= BASE_ASSET ?>js/page/extension/extension-add.js"></script>