<div class="table-wrapper">
   <table class="table table-responsive table table-bordered table-striped" id="diagnosis_list">
      <thead>
         <tr>
            <th width="20" rowspan="2" class="th-builder-va" valign="midle"><?= cclang('no') ?></th>
            <th width="200" rowspan="2" class="th-builder-va" valign="midle"><?= cclang('field'); ?></th>
            <th width="80" colspan="4" class="text-center"><?= cclang('show_in'); ?></th>
            <th width="100" rowspan="2" class="th-builder-va" valign="midle"><?= cclang('input_type'); ?></th>
            <th width="200" rowspan="2" class="th-builder-va" valign="midle"><?= cclang('validation'); ?></th>
         </tr>
         <tr>
            <th width="60" class="module-page-list column"><?= cclang('column'); ?></th>
            <th width="60" class="module-page-add add_form"><?= cclang('add_form'); ?></th>
            <th width="60" class="module-page-update update_form"><?= cclang('update_form'); ?></th>
            <th width="60" class="detail_page"><?= cclang('detail_page'); ?></th>
         </tr>
      </thead>
      <tbody>
         <?php $i = 0;
         foreach ($this->db->field_data($table) as $row) : $r_row = $row;
            $i++; ?>
            <tr>
               <td >
                  <i class="dragable fa fa-bars fa-lg text-muted"></i>
                  <input type="hidden" name="crud[<?= $i; ?>][<?= $row->name; ?>][sort]" class="priority" value="<?= $i; ?>">
                  <?php if ($row->primary_key == 1) { ?>
                     <input type="hidden" name="primary_key" value="<?= $row->primary_key == 1 ? $row->name : ''; ?>">
                  <?php } ?>
                  <input type="hidden" class="crud-id" id="crud-id" value="<?= $i; ?>">
                  <input type="hidden" class="crud-name" id="crud-name" value="<?= $row->name; ?>">
                  <input type="hidden" class="crud-data-type" id="crud-data-type" value="<?= $row->type; ?>">
                  <input type="hidden" class="crud-primarykey" id="crud-primarykey" value="<?= $row->primary_key; ?>">
                  <input type="hidden" class="crud-max-length" id="crud-max-length" value="<?= $row->max_length; ?>">
                  <?php if (!$row->primary_key) : ?>
                     <?= $this->load->view('backend/standart/administrator/crud/crud_button_config'); ?>
                  <?php endif ?>

               </td>
               <td>
                  <input type="text" class="crud-input-initial" name="crud[<?= $i; ?>][<?= $row->name; ?>][label]" placeholder="<?= $row->name; ?>" value="<?= $row->name; ?>">

                  <div class="setting-container <?= $row->primary_key  ? 'hide' : '' ?>">
                     <i class="fa fa-minus btn-collapse-setting"></i>

                     <div class="box-setting">
                        <label>
                           <div class="setting-name">placeholder</div>
                           <input class="input_setting" name="crud[<?= $i; ?>][<?= $row->name; ?>][placeholder]" value="">
                        </label>
                     </div>



                     <div class="box-setting">
                        <label>
                           <div class="setting-name"><span><?= cclang('auto_generate_help_block') ?> ?</span>
                              <div class="pull-right">
                                 <input checked class="switch-button pull-right" type="checkbox" name="crud[<?= $i; ?>][<?= $row->name; ?>][auto_generated_helpblock]" value="yes" title="automatic generated help block">
                              </div>
                           </div>
                           <input class="input_setting " name="crud[<?= $i ?>][<?= $row->name ?>][help_block]" value="" placeholder="type help block here">
                        </label>
                     </div>


                     <div class="box-setting">
                        <label>
                           <div class="setting-name">wrapper class</div>
                           <input class="input_setting" name="crud[<?= $i; ?>][<?= $row->name; ?>][wrapper_class]" value="<?= 'group-' . url_title($row->name) ?>">
                        </label>
                     </div>


                     <div class="config-item-wrapper box-setting">

                     </div>


                  </div>

               </td>
               <td class="column">
                  <input class="flat-red check" type="checkbox" <?= $row->primary_key ? '' : 'checked'; ?> name="crud[<?= $i; ?>][<?= $row->name; ?>][show_in_column]" value="yes">
               </td>
               <td class="add_form">
                  <input class="flat-red check" type="checkbox" <?= $row->primary_key ? '' : 'checked'; ?> name="crud[<?= $i; ?>][<?= $row->name; ?>][show_in_add_form]" value="yes">
               </td>
               <td class="update_form">
                  <input class="flat-red check" type="checkbox" <?= $row->primary_key ? '' : 'checked'; ?> name="crud[<?= $i; ?>][<?= $row->name; ?>][show_in_update_form]" value="yes">
               </td>
               <td class="detail_page">
                  <input class="flat-red check" type="checkbox" checked name="crud[<?= $i; ?>][<?= $row->name; ?>][show_in_detail_page]" value="yes">
               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <select class="form-control chosen chosen-select input_type" name="crud[<?= $i; ?>][<?= $row->name; ?>][input_type]" id="input_type" tabi-ndex="5" data-placeholder="Select Type">
                           <option value="" class="<?= $this->model_crud->get_input_type(); ?>"></option>
                           <?php foreach (db_get_all_data('crud_input_type') as $input) :
                              if (preg_match('/image|photo|img|file/', $row->name) and $input->type == 'file') {
                                 $selected = 'selected';
                              } elseif ($row->type == $input->type or ($row->type == 'timestamp' and $input->type == 'timestamp')) {
                                 $selected = 'selected';
                              } elseif ($row->type == 'int' and $input->type == 'number') {
                                 $selected = 'selected';
                              } elseif ($row->type == 'text' and $input->type == 'editor_wysiwyg') {
                                 $selected = 'selected';
                              } elseif ($row->type == 'tinytext' and $input->type == 'textarea') {
                                 $selected = 'selected';
                              } elseif (($row->type == 'varchar' or $row->type == 'tinyint') and $input->type == 'input') {
                                 $selected = 'selected';
                              } elseif (($row->type == 'decimal') and $input->type == 'input') {
                                 $selected = 'selected';
                              } elseif ($input->type == 'input') {
                                 $selected = 'selected';
                              } elseif ($input->type == 'custom_select' and ($row->type == 'enum')) {
                                 $selected = 'selected';
                              } else {
                                 $selected = '';
                              }
                           ?>
                              <option value="<?= $input->type; ?>" class="<?= $input->type; ?>" title="<?= $input->validation_group; ?>" relation="<?= $input->relation; ?>" custom-value="<?= $input->custom_value; ?>" <?= _ent($selected); ?>><?= _ent(ucwords(clean_snake_case($input->type))); ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
                  <?php
                  $matches = [];
                  if ($row->type == 'enum') {
                     $string = $fields[$r_row->name]->detail->Type;
                     preg_match_all('/(?<=[(,])([^,)]+)(?=[,)])/', $string, $matches);
                  }
                  ?>
                  <div class="custom-option-container <?= ($row->type == 'enum') ? '' : 'display-none' ?> ">
                     <div class="custom-option-contain">


                        <?php if (isset($matches[0])) : ?>
                           <?php foreach ($matches[0] as $idx => $val) : ?>
                              <div class="custom-option-item">
                                 <div class="box-custom-option padding-left-0 box-top">
                                    <div class="col-md-3"><?= cclang('value') ?></div> <input value="<?= str_replace("'", '', $val) ?>" type="text" name="crud[<?= $i; ?>][<?= $row->name; ?>][custom_option][<?= $idx + 1 ?>][value]"></label>
                                 </div>
                                 <div class="box-custom-option padding-left-0 box-bottom">
                                    <div class="col-md-3"><?= cclang('label') ?></div> <input value="<?= str_replace("'", '', $val) ?>" type="text" name="crud[<?= $i; ?>][<?= $row->name; ?>][custom_option][<?= $idx + 1 ?>][label]">
                                 </div>
                                 <a class="text-red delete-option fa fa-trash" data-original-title="" title=""></a>
                              </div>
                           <?php endforeach ?>
                        <?php endif ?>
                        <div class="custom-option-item">
                           <div class="box-custom-option padding-left-0 box-top">
                              <div class="col-md-3"><?= cclang('value') ?></div> <input type="text" name="crud[<?= $i; ?>][<?= $row->name; ?>][custom_option][0][value]"></label>
                           </div>
                           <div class="box-custom-option padding-left-0 box-bottom">
                              <div class="col-md-3"><?= cclang('label') ?></div> <input type="text" name="crud[<?= $i; ?>][<?= $row->name; ?>][custom_option][0][label]">
                           </div>
                           <a class="text-red delete-option fa fa-trash" data-original-title="" title=""></a>
                        </div>


                     </div>
                     <a class="box-custom-option input btn btn-flat btn-block bg-black  add-option">
                        <i class="fa fa-plus-circle"></i> <?= cclang('add_new_option') ?>
                     </a>
                  </div>

                  <div class="col-md-12 margin-0">
                     <div class="form-group display-none ">
                        <label><small class="text-muted"><?= cclang('table_reff') ?></small></label>
                        <select class="form-control chosen chosen-select relation_table relation_field" name="crud[<?= $i; ?>][<?= $row->name; ?>][relation_table]" id="relation_table" tabi-ndex="5" data-placeholder="Select Table">
                           <option value=""></option>
                           <?php foreach (array_diff($this->db->list_tables(), get_table_not_allowed_for_builder()) as $table) : ?>
                              <option value="<?= $table; ?>"><?= $table; ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-12  margin-0">
                     <div class="form-group display-none ">
                        <label><small class="text-muted"><?= cclang('value_field_reff') ?></small></label>
                        <select class="form-control chosen chosen-select relation_value relation_field" name="crud[<?= $i; ?>][<?= $row->name; ?>][relation_value]" id="relation_value" tabi-ndex="5" data-placeholder="Select ID">
                           <option value=""></option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-12 margin-0">
                     <div class="form-group display-none ">
                        <label><small class="text-muted"><?= cclang('label_field_reff') ?></small></label>
                        <select class="form-control chosen chosen-select relation_label relation_field" name="crud[<?= $i; ?>][<?= $row->name; ?>][relation_label]" id="relation_label" tabi-ndex="5" data-placeholder="Select Label">
                           <option value=""></option>
                        </select>
                     </div>
                  </div>

                  <hr>
                  <div class="col-md-12 margin-0">
                     <div class="form-group display-none ">
                        <label><small class="text-muted"><?= cclang('where'); ?></small></label>
                        <select class="form-control chosen chosen-select-deselect chain_field_eq relation_label relation_field" name="crud[<?= $i; ?>][<?= $row->name; ?>][chain_field]" id="chain_field" tabi-ndex="5" data-placeholder="Select Label">
                           <option value=""></option>
                        </select>
                     </div>
                  </div>

                  <div class="col-md-12 margin-0">
                     <div class="form-group display-none">
                        <div class=" ">
                           <center>=</center>
                        </div>
                        <label><small class="text-muted"></small></label>
                        <select class="form-control chosen chosen-select-deselect chain_field_eq " name="crud[<?= $i; ?>][<?= $row->name; ?>][chain_field_eq]" id="chain_field_eq" tabi-ndex="5" data-placeholder="Select Label">
                           <option value=""></option>
                           <?php foreach ($this->db->list_fields($table_name) as $field) { ?>
                              <option value="<?= $field; ?>"><?= ucwords($field); ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>

                  <div class="custom-condition-container display-none">
                     <div class="custom-condition-contain">
                        <div class="custom-condition-item">
                           <div class="box-custom-condition padding-left-0 box-top">
                              <div class="col-md-4"><?= cclang('field'); ?></div> <input type="text" name="crud[<?= $i; ?>][<?= $row->name; ?>][custom_condition][0][field]"></label>
                           </div>
                           <div class="box-custom-condition padding-left-0 border-none">
                              <div class="col-md-4"><?= cclang('operator'); ?></div>
                              <select  name="crud[<?= $i; ?>][<?= $row->name; ?>][custom_condition][0][operator]" id="condition_operator">
                                 <?php foreach ([
                                    '=' => 'equal =',
                                    '>' => 'greater than >',
                                    '<' => 'smaller than <',
                                    'LIKE' => 'LIKE',
                                    'IN' => 'IN',
                                    '!=' => 'not equal !='
                                 ] as $key => $val) : ?>
                                    <option value="<?= $key ?>"><?= ucfirst($val) ?></option>
                                 <?php endforeach ?>
                              </select>
                           </div>
                           <div class="box-custom-condition padding-left-0 box-bottom">
                              <div class="col-md-4"><?= cclang('value'); ?></div> <input type="text" name="crud[<?= $i; ?>][<?= $row->name; ?>][custom_condition][0][value]" value="''">
                           </div>
                           <a class="text-red delete-condition fa fa-trash" data-original-title="" title=""></a>
                        </div>
                     </div>
                     <a class="box-custom-condition input btn btn-flat btn-block bg-black  add-condition">
                        <i class="fa fa-plus-circle"></i> <?= cclang('add_new_condition'); ?>
                     </a>
                  </div>


               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <select class="form-control chosen chosen-select validation" name="crud[<?= $i; ?>][<?= $row->name; ?>][validation]" id="validation" tabi-ndex="5" data-placeholder="+ Add Rules">
                           <option value="" class="input file number text datetime select"></option>
                           <?php
                           foreach (db_get_all_data('crud_input_validation') as $input) :
                           ?>
                              <option value="<?= $input->validation; ?>" class="<?= str_replace(',', ' ', $input->group_input); ?>" data-group-validation="<?= str_replace(',', ' ', $input->group_input); ?>" data-placeholder="<?= $input->input_placeholder; ?>" title="<?= $input->input_able; ?>"><?= ucwords(clean_snake_case($input->validation)); ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>

<script>
   $(function() {

      "use strict";
      
      $(document).find("#diagnosis_list tbody .switch-button").switchButton({
         labels_placement: 'right',
         on_label: 'yes',
         off_label: 'no'
      });
   })
</script>