<section class="content-header">
  <h1>
    Database <small><?= cclang('edit', ['field']); ?> </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li ><a href="<?= site_url('administrator/database'); ?>">Database</a></li>
    <li class="active"><?= cclang('edit'); ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-body ">

          <div class="box box-widget widget-user-2">

            <div class="widget-user-header ">
              <div class="widget-user-image">
                <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="User Avatar">
              </div>

              <h3 class="widget-user-username">Database</h3>
              <h5 class="widget-user-desc"><?= cclang('edit', ['field']); ?></h5>
              <hr>
            </div>
            <div class="field-wrapper-template display-none">
              <table>
                <tr class="table-field-item">
                  <td><input type="text" name="table[{id}][name]" class="name form-control field-auto-name"></td>
                  <td>
                    <select class="form-control field-auto-type" name="table[{id}][type]" id="">
                      <?php foreach ($field_type as $group => $types) : ?>
                        <optgroup label="<?= ucwords($group) ?>">
                          <?php foreach ($types as $type) : ?>
                            <option value="<?= $type ?>"><?= $type ?></option>
                          <?php endforeach ?>
                        </optgroup>
                      <?php endforeach ?>
                    </select>
                  </td>
                  <td><input type="text" name="table[{id}][length]" class="form-control field-auto-length"></td>
                  <td>
                    <select class="form-control table-default" name="table[{id}][default]" id="default" name="table[{id}][default]" class="field-auto-default">
                      <option value="">none</option>
                      <option value="null">null</option>
                      <option value="as_defined">as defined</option>
                    </select>
                    <div class="defined-value-wrapper display-none">
                      <input type="text" name="table[{id}][defined_value]" class="defined-value form-control">
                    </div>
                  </td>
                  <td>
                    <input name="table[{id}][null]" type="checkbox" class="field-auto-null" value="true">
                  </td>
                  <td>
                    <input name="table[{id}][auto_increment]" class="field-auto-increment" type="checkbox" value="true">
                  </td>
                  <td>
                  </td>
                </tr>
              </table>
            </div>

            <?= form_open('', [
              'name'    => 'form_database',
              'class'   => 'form-horizontal form-step',
              'id'      => 'form_database',
              'enctype' => 'multipart/form-data',
              'method'  => 'POST'
            ]); ?>


            <div class="form-group ">

              <div class="col-md-12">
                <table class="table table-striped table-bordered ">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Length / Value</th>
                      <th>Default</th>
                      <th>Null</th>
                      <th>Auto Increment / Primary Key</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="table-field-wrapper table-edit">

                  </tbody>
                </table>
              </div>
            </div>


            <div class="message"></div>
            <div class="row-fluid col-md-7 container-button-bottom">

              <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                <i class="ion ion-ios-list-outline"></i> <?= cclang('save_button'); ?>
              </a>
              <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
              </a>
              <span class="loading loading-hide">
                <img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg">
                <i><?= cclang('loading_saving_data'); ?></i>
              </span>
            </div>
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  "use strict";

  var field = <?= json_encode($fields[$field]) ?>;
  var table_name = "<?= ccencrypt($table_name) ?>";
</script>

<script src="<?= BASE_ASSET ?>js/database-manager.js"></script>
<script src="<?= BASE_ASSET ?>js/page/database/database-update.js"></script>