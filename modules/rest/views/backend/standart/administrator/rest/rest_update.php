<link rel="stylesheet" type="text/css" href="<?= BASE_ASSET ?>css/rest.css">

<script src="<?= BASE_ASSET ?>float-thead/jquery.floatThead.min.js"></script>
<section class="content-header">
   <h1>
      Rest
      <small><?= cclang('update', ['Rest']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li ><a href="<?= site_url('administrator/rest'); ?>">Rest</a></li>
      <li class="active"><?= cclang('update'); ?></li>
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
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="Rest Avatar">
                     </div>
                     <h3 class="widget-user-username">Rest</h3>
                     <h5 class="widget-user-desc"><?= cclang('update', ['Rest']); ?></h5>
                     <hr>
                  </div>
                  <?= form_open('', [
                     'name'    => 'form_rest',
                     'class'   => 'form-horizontal',
                     'id'      => 'form_rest',
                     'method'  => 'POST'
                  ]); ?>

                  <input type="hidden" name="table_name" id="table_name" value="<?= $rest->table_name; ?>">
                  <input type="hidden" class="primary_key" name="primary_key" id="primary_key" value="<?= $rest->primary_key; ?>">

                  <div class="form-group ">
                     <label for="label" class="col-sm-2 control-label">Table name </label>
                     <div class="col-sm-8">
                        <input type="text" readonly="" class="form-control" value="<?= $rest->table_name; ?>">
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="label" class="col-sm-2 control-label">Subject <i class="required">*</i></label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?= set_value('subject', $rest->subject); ?>">
                        <small class="info help-block">The subject of rest.</small>
                     </div>
                  </div>

                  <div class="form-group ">
                     <label for="label" class="col-sm-2 control-label">Header Required</label>
                     <div class="col-sm-8">
                        <div class="col-md-2 padding-left-0">
                           <label>
                              <input class="flat-red check page_read" type="checkbox" id="x_token" value="yes" name="x_token" <?= $rest->x_token == 'yes' ? 'checked' : ''; ?>> X-Token
                           </label>
                        </div>
                     </div>
                  </div>

                  <hr>
                  <div class="wrapper-rest">
                     <table class="table table-responsive table table-bordered table-striped" id="diagnosis_list">
                        <thead>
                           <tr>
                              <th width="20" rowspan="2" valign="midle" class="th-builder-va">No</th>
                              <th width="120" rowspan="2" valign="midle" class="th-builder-va"><?= cclang('field'); ?></th>
                              <th width="80" colspan="4" class="text-center"><?= cclang('show_in'); ?></th>
                              <th width="100" rowspan="2" valign="midle" class="th-builder-va"><?= cclang('input_type'); ?></th>
                              <th width="200" rowspan="2" valign="midle" class="th-builder-va"><?= cclang('validation'); ?></th>
                           </tr>
                           <tr>
                              <th width="60" class="module-page-list column th-builder-va"><?= cclang('all'); ?> <i><b>GET</b></i></th>
                              <th width="60" class="module-page-add add_form th-builder-va"><?= cclang('add'); ?> <i><b>POST</b></i></th>
                              <th width="60" class="module-page-update update_form th-builder-va"><?= cclang('update'); ?> <i><b>POST</b></i></th>
                              <th width="60" class="detail_page th-builder-va"><?= cclang('detail'); ?> <i><b>GET</b></i></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 0;
                           foreach ($rest_field as $row) :  $i++;
                           ?>
                              <tr>
                                 <td>
                                    <?= $i; ?>
                                    <input type="hidden" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][sort]" class="priority" value="<?= $i; ?>">
                                    <?php if ($rest->primary_key == 1) { ?>
                                       <input type="hidden" name="primary_key" value="<?= $rest->primary_key == 1 ? $row->field_name : ''; ?>">
                                    <?php } ?>
                                    <input type="hidden" class="rest-id" id="rest-id" value="<?= $i; ?>">
                                    <input type="hidden" class="rest-name" id="rest-name" value="<?= $row->field_name; ?>">
                                 </td>
                                 <td>
                                    <?= $row->field_name; ?>
                                 </td>
                                 <td class="column">
                                    <input class="flat-red check" type="checkbox" <?= $row->show_column == 'yes' ? 'checked' : ''; ?> name="rest[<?= $i; ?>][<?= $row->field_name; ?>][show_in_column]" value="yes">
                                 </td>
                                 <td class="add_form">
                                    <input class="flat-red check" type="checkbox" <?= $row->show_add_api == 'yes' ? 'checked' : ''; ?> name="rest[<?= $i; ?>][<?= $row->field_name; ?>][show_in_add_form]" value="yes">
                                 </td>
                                 <td class="update_form">
                                    <input class="flat-red check" type="checkbox" <?= $row->show_update_api == 'yes' ? 'checked' : ''; ?> name="rest[<?= $i; ?>][<?= $row->field_name; ?>][show_in_update_form]" value="yes">
                                 </td>
                                 <td class="detail_page">
                                    <input class="flat-red check" type="checkbox" <?= $row->show_detail_api == 'yes' ? 'checked' : ''; ?> name="rest[<?= $i; ?>][<?= $row->field_name; ?>][show_in_detail_page]" value="yes">
                                 </td>
                                 <td>
                                    <div class="col-md-12">
                                       <div class="form-group ">
                                          <select class="form-control chosen chosen-select input_type" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][input_type]" id="input_type" tabi-ndex="5" data-placeholder="Select Type">
                                             <option value="" class="<?= $this->model_rest->get_input_type(); ?>"></option>
                                             <?php foreach (db_get_all_data('rest_input_type') as $input) :
                                             ?>
                                                <option value="<?= $input->type; ?>" class="<?= $input->type; ?>" title="<?= $input->validation_group; ?>" relation="<?= $input->relation; ?>" <?= $input->type == $row->input_type ? 'selected="selected"' : ''; ?>><?= ucwords(clean_snake_case($input->type)); ?></option>
                                             <?php endforeach; ?>
                                          </select>
                                       </div>
                                    </div>
                                    <?php if (!empty($row->relation_table)) : ?>
                                       <div class="col-md-12 margin-0">
                                          <div class="form-group">
                                             <label><small class="text-muted"><?= cclang('table_reff'); ?></small></label>
                                             <select class="form-control chosen chosen-select relation_table relation_field" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][relation_table]" id="relation_table" tabi-ndex="5" data-placeholder="Select Table">
                                                <option value=""></option>
                                                <?php foreach ($this->db->list_tables() as $table) : ?>
                                                   <option <?= $row->relation_table == $table ? 'selected' : ''; ?> value="<?= $table; ?>"><?= $table; ?></option>
                                                <?php endforeach; ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-12 margin-0">
                                          <div class="form-group ">
                                             <label><small class="text-muted"><?= cclang('value_field_reff'); ?></small></label>
                                             <select class="form-control chosen chosen-select relation_value relation_field" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][relation_value]" id="relation_value" tabi-ndex="5" data-placeholder="Select ID">
                                                <option value=""></option>
                                                <?php foreach ($this->db->list_fields($row->relation_table) as $field) { ?>
                                                   <option <?= $row->relation_value == $field ? 'selected' : ''; ?> value="<?= $field; ?>"><?= ucwords($field); ?></option>
                                                <?php } ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-12 margin-0">
                                          <div class="form-group ">
                                             <label><small class="text-muted"><?= cclang('label_field_reff'); ?></small></label>
                                             <select class="form-control chosen chosen-select relation_label relation_field" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][relation_label]" id="relation_label" tabi-ndex="5" data-placeholder="Select Label">
                                                <option value=""></option>
                                                <?php foreach ($this->db->list_fields($row->relation_table) as $field) { ?>
                                                   <option <?= $row->relation_label == $field ? 'selected' : ''; ?> value="<?= $field; ?>"><?= ucwords($field); ?></option>
                                                <?php } ?>
                                             </select>
                                          </div>
                                       </div>
                                    <?php else : ?>
                                       <div class="col-md-12 margin-0">
                                          <div class="form-group display-none ">
                                             <label><small class="text-muted"><?= cclang('table_reff') ?></small></label>
                                             <select class="form-control chosen chosen-select relation_table relation_field" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][relation_table]" id="relation_table" tabi-ndex="5" data-placeholder="Select Table">
                                                <option value=""></option>
                                                <?php foreach ($this->db->list_tables() as $table) : ?>
                                                   <option value="<?= $table; ?>"><?= $table; ?></option>
                                                <?php endforeach; ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-md-12 margin-0">
                                          <div class="form-group display-none ">
                                             <label><small class="text-muted"><?= cclang('value_field_reff') ?></small></label>
                                             <select class="form-control chosen chosen-select relation_value relation_field" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][relation_value]" id="relation_value" tabi-ndex="5" data-placeholder="Select ID">
                                                <option value=""></option>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-md-12 margin-0">
                                          <div class="form-group display-none ">
                                             <label><small class="text-muted"><?= cclang('label_field_reff') ?></small></label>
                                             <select class="form-control chosen chosen-select relation_label relation_field" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][relation_label]" id="relation_label" tabi-ndex="5" data-placeholder="Select Label">
                                                <option value=""></option>
                                             </select>
                                          </div>
                                       </div>

                                    <?php endif ?>
                                 </td>
                                 <td>
                                    <div class="col-md-12">
                                       <div class="form-group ">
                                          <select class="form-control chosen chosen-select validation" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][validation]" id="validation" tabi-ndex="5" data-placeholder="+ Add Rules">
                                             <option value="" class="input file number text datetime select"></option>
                                             <?php
                                             foreach (db_get_all_data('crud_input_validation') as $input) :
                                             ?>
                                                <option value="<?= $input->validation; ?>" class="<?= str_replace(',', ' ', $input->group_input); ?>" data-group-validation="<?= str_replace(',', ' ', $input->group_input); ?>" data-placeholder="<?= $input->input_placeholder; ?>" title="<?= $input->input_able; ?>"><?= ucwords(clean_snake_case($input->validation)); ?></option>
                                             <?php endforeach; ?>
                                          </select>
                                       </div>
                                    </div>
                                    <?php if (isset($rest_field_validation[$row->id])) :
                                       foreach ($rest_field_validation[$row->id] as $rule) {
                                    ?>
                                          <div class="box-validation <?= str_replace(',', ' ', $rule->group_input) . ' ' . $rule->validation_name; ?>">
                                             <label>
                                                <div class="validation-name<?= $rule->input_able == 'yes' ? '' : '-max'; ?>"><?= clean_snake_case($rule->validation); ?></div>
                                                <input class="input_validation" name="rest[<?= $i; ?>][<?= $row->field_name; ?>][validation][rules][<?= $rule->validation; ?>]" type="<?= $rule->input_able == 'yes' ? 'text' : 'hidden'; ?>" value="<?= $rule->validation_value; ?>">
                                             </label> <a class="delete fa fa-trash"></a>
                                          </div>
                                    <?php
                                       }
                                    endif; ?>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
                  <div class="validation_rules display-none">
                     <option value="" class="<?= $this->model_rest->get_input_type(); ?>"></option>
                     <?php foreach (db_get_all_data('crud_input_validation') as $input) : ?>
                        <option value="<?= $input->validation; ?>" class="<?= str_replace(',', ' ', $input->group_input); ?>" title="<?= $input->input_able; ?>" data-placeholder="<?= $input->input_placeholder; ?>"><?= ucwords(clean_snake_case($input->validation)); ?></option>
                     <?php endforeach; ?>
                  </div>
                  <div class="message no-message-padding">
                  </div>
                  <div class="view-nav">
                     <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="save (Ctrl+s)"><i class="fa fa-save"></i> <?= cclang('save_button'); ?></button>
                     <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)"><i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?></a>
                     <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)"><i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?></a>
                     <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_saving_data'); ?></i></span>
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

   window.rest = <?= json_encode($rest) ?>
</script>
<script src="<?= BASE_ASSET ?>ckeditor/ckeditor.js"></script>
<script src="<?= BASE_ASSET ?>js/rest.js"></script>
<script src="<?= BASE_ASSET ?>js/page/rest/rest-update.js"></script>