<script src="<?= BASE_ASSET ?>bsselect/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="<?= BASE_ASSET ?>bsselect/bootstrap-select.min.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>flag-icon/css/flag-icon.css" rel="stylesheet" media="all" />
<link rel="stylesheet" href="<?= BASE_ASSET ?>css/wizzard.css" rel="stylesheet" />

<section class="content-header margin-left-17">
  <h1>
    <small></small>
  </h1>
</section>

<section class="content col-md-7  margin-left-17">

  <center>
    <h3><?= cclang('select_language'); ?></h3>
  </center>

  <div class="box ">
    <div class="box-body">
      <div class="col-md-10 col-md-offset-1">
        <div class="row">
          <center>
            <?= form_open('wizzard/select_language', [
              'name'    => 'form_group',
              'method'  => 'POST'
            ]); ?>

            <select class="selectpicker" data-width="100%" name="language">
              <?php foreach (get_langs() as $lang) : ?>
                <option value="<?= $lang['folder_name']; ?>" data-content='<span class="flag-icon <?= $lang['icon_name']; ?>"></span> <?= $lang['name']; ?>'><?= $lang['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </center>
        </div>
        <div class="row">
          <button type="submit" class="btn bg-green margin btn-lg btn-flat btn-block pull-right margin-right--0"><?= cclang('next'); ?></button>
        </div>
      </div>
      <div class="col-md-2 padd-left-0">
      </div>
    </div>
  </div>
</section>

<script>
  $(function() {

    "use strict";

    $('.selectpicker').selectpicker({
      style: 'btn-block btn-flat',
      size: 4
    });
  });
</script>