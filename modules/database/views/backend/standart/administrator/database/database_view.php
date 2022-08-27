<section class="content-header">
   <h1>
      Database <small><?= cclang('detail', ['Database']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/database'); ?>">Database</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
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
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/view.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username">Database</h3>
                     <h5 class="widget-user-desc">Detail Database</h5>
                     <hr>
                  </div>

                  <div class="form-horizontal form-step" name="form_database" id="form_database">

                     <div class="col-md-12">
                        <form action="<?= base_url('administrator/database/update_table_name/' . ccencrypt($table_name)) ?>">

                           <div class="row">
                              <label>Table</label>

                              <div class="form-group">
                                 <div class="col-md-4">
                                    <div class="input-group ">

                                       <input type="text" class="form-control" value="<?= ($table_name) ?>" name="table_name_change">
                                       <span class="input-group-btn">
                                          <button type="" class="btn btn-info btn-flat">Update table Name</button>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <hr>
                        </form>

                        <form action="<?= base_url('administrator/database/add/' . ccencrypt($table_name)) ?>">

                           <div class="row">
                              <label>Add Field</label>

                              <div class="form-group">
                                 <div class="col-md-2">
                                    <select class="form-control" name="position" id="">
                                       <option value="after">After</option>
                                    </select>
                                 </div>
                                 <div class="col-md-2">
                                    <select class="form-control" name="field" id="">
                                       <?php foreach ($fields as $field) : ?>
                                          <option value="<?= $field->name ?>"><?= $field->name ?></option>
                                       <?php endforeach ?>
                                    </select>
                                 </div>

                                 <div class="col-md-1">
                                    <button class="btn btn-default">ok</button>
                                 </div>
                              </div>
                           </div>

                           <hr>
                        </form>
                     </div>

                     <table class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1"></th>
                              <th>Name</th>
                              <th>Type</th>
                              <th>Default</th>
                              <th>Null</th>
                              <th>Extra</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody class="table-field-wrapper">
                           <?php foreach ($fields as $field) : ?>
                              <tr data-field-name="<?= $field->name ?>">
                                 <td><i class="cursor-move fa fa-bars dragable fa-lg text-muted"></i><br></td>
                                 <td><?= $field->name ?>
                                    <?php if ($field->primary_key) : ?>
                                       <i class="fa fa-key text-yellow"></i>
                                    <?php endif ?>
                                 </td>
                                 <td><?= $field->detail->Type ?></td>
                                 <td><?= $field->detail->Default ?></td>
                                 <td><?= $field->detail->Null ?></td>
                                 <td><?= $field->detail->Extra ?></td>
                                 <td>
                                    <div class="btn-group">
                                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                          <?= cclang('action') ?>
                                          <span class="caret"></span>
                                       </button>
                                       <ul class="dropdown-menu" role="menu">
                                          <?php if ($field->primary_key) : ?>
                                             <li><a href="<?= base_url('administrator/database/remove_key/' . ccencrypt($table_name) . '?field=' . $field->name) ?>"> <i class="fa  fa-key"></i> Remove Primary Key</a></li>
                                          <?php endif ?>
                                          <li><a href="<?= site_url('administrator/database/change_field/' . ccencrypt($table_name) . '?' . http_build_query(['field' => $field->name])); ?>"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a></li>
                                          <li><a href="javascript:void(0);" data-href="<?= site_url('administrator/database/remove_field/' . ccencrypt($table_name) . '?field=' . $field->name); ?>" class=" remove-data"><i class="fa fa-close"></i> <?= cclang('drop'); ?></a></li>
                                       </ul>
                                    </div>
                                 </td>
                              </tr>
                           <?php endforeach ?>
                        </tbody>
                     </table>
                     <div class="view-nav">
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/database/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Database']); ?></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
   "use strict";

   var table_name = "<?= ccencrypt($table_name) ?>";
</script>
<script src="<?= BASE_ASSET ?>js/page/database/database-view.js"></script>