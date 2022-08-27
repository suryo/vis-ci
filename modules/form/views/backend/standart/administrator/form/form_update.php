<link rel="stylesheet" href="<?= BASE_ASSET ?>css/form.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>jquery-switch-button/jquery.switchButton.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>dist/jquery.addressPickerByGiro.css">


<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCOi5vktJx2fjOA4X9orhT_-v2SIvsv060 "></script>
<script src="<?= BASE_ASSET ?>jquery-map/dist/jquery.addressPickerByGiro.js"></script>

<section class="content-header">
    <h1>
        Form
        <small><?= cclang('update', 'form'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li ><a href="<?= site_url('administrator/form'); ?>">Form</a></li>
        <li class="active"><?= cclang('update'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12 col-box-form">
            <div class="box box-warning">
                <div class="box-body ">

                    <div class="box box-widget widget-user-2">

                        <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="Form Avatar">
                            </div>
                            <!-- /.widget-form-image -->
                            <h3 class="widget-user-username">Form</h3>
                            <h5 class="widget-user-desc"><?= cclang('update', 'Form'); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_form',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_form',
                            'method'  => 'POST'
                        ]); ?>
                        <input type="hidden" name="id" id="id" value="<?= $form->id; ?>">
                        <input type="hidden" name="subject" value="<?= $form->subject; ?>">
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= cclang('subject') ?> <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly value="<?= $form->subject; ?>">
                                <small class="info help-block">The subject of form.</small>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= cclang('title') ?> </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= $form->title; ?>">
                                <small class="info help-block">The title of form.</small>
                            </div>
                        </div>
                        <hr>

                        <div class="col-md-12 padding-left-0 padding-right-0">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a class=" active btn-form-designer" href="#tab_1" data-toggle="tab"><i class="fa fa-code text-green"></i> <?= cclang('form_designer', 'Form'); ?></a></li>
                                    <li><a class=" active btn-form-preview" href="#tab_2" data-toggle="tab"><i class="fa fa-tv text-green"></i> <?= cclang('form_preview', 'Form'); ?></a></li>
                                    <li> <span class="loading3 loading-hide "><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_getting_data'); ?></i></span></li>
                                    <li class="pull-right"><a href="#" data-toggle="control-sidebar" class="text-muted btn-tool"><?= cclang('tool'); ?> <i class="fa fa-gear"></i></a></li>

                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane rest-page-test active" id="tab_1">
                                        <div class="wrapper-form">
                                            <table class="table table-responsive table table-striped table-form" id="diagnosis_list">
                                                <tbody>

                                                    <?php $i = 1;
                                                    foreach ($form_field as $toolbox) : ?>
                                                        <?php if (!in_array($toolbox->input_type, ['captcha', 'heading'])) { ?>
                                                            <tr>
                                                                <td class="dragable hide-preview" width="2%">
                                                                    <i class="fa fa-bars fa-lg text-muted"></i>
                                                                    <input type="hidden" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][sort]" class="priority" value="<?= $toolbox->id; ?>">
                                                                    <input type="hidden" class="form-id" id="form-id" value="<?= $toolbox->id; ?>">
                                                                    <input type="hidden" class="form-name" id="form-name" value="<?= $toolbox->field_name; ?>">
                                                                </td>
                                                                <td class="field-name-preview hide-preview" width="30%">
                                                                    <div class="setting-container">
                                                                        <i class="fa fa-minus btn-collapse-setting"></i>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('field_label') ?></div>
                                                                                <input class="input_setting field_label" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][input_label]" value="<?= $toolbox->field_label; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('field_name') ?></div>
                                                                                <input class="input_setting field_name" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][input_name]" value="<?= $toolbox->field_name; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><span><?= cclang('show_in_column'); ?> ?</span>
                                                                                    <div class="pull-right">
                                                                                        <input class="switch-button pull-right" <?= @$toolbox->show_column == 'yes' ? 'checked' : '' ?> type="checkbox" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][show_in_column]" value="yes" title="automatic generated help block">
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                        </div>

                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name">placeholder</div>
                                                                                <input class="input_setting" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][placeholder]" value="<?= $toolbox->placeholder; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><span><?= cclang('auto_generate_help_block') ?> ?</span>
                                                                                    <div class="pull-right">
                                                                                        <input class="switch-button pull-right" type="checkbox" <?= $toolbox->auto_generate_help_block == 'yes' ? 'checked' : ''; ?> name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][auto_generated_helpblock]" value="yes" title="automatic generated help block">
                                                                                    </div>
                                                                                </div>
                                                                                <input class="input_setting  <?= $toolbox->auto_generate_help_block == 'yes' ? 'display-none' : ''; ?>" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][help_block]" value="<?= $toolbox->help_block; ?>" placeholder="type help block here">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <div class="setting-name">
                                                                                <span><?= cclang('custom_attributes') ?></span>
                                                                                <i class="fa fa-minus btn-collapse-attributes pull-right"></i>
                                                                            </div>
                                                                            <div class="custom-option-container  custom-attributes-container" data-type="attributes">
                                                                                <div class="custom-option-contain ignore-first-child">
                                                                                    <?php
                                                                                    if (isset($form_custom_attribute[$toolbox->id])) :
                                                                                        foreach ($form_custom_attribute[$toolbox->id] as $attr) { ?>
                                                                                            <div class="custom-option-item custom-option-<?= $attr->id; ?>">
                                                                                                <div class="box-custom-option input padding-left-0 box-top">
                                                                                                    <div class="col-md-3"><?= cclang('value') ?></div>
                                                                                                    <input class="input_validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_attributes][<?= $attr->id; ?>][value]" value="<?= $attr->attribute_value; ?>" type="text">
                                                                                                </div>
                                                                                                <div class="box-custom-option input padding-left-0 box-bottom">
                                                                                                    <div class="col-md-3"><?= cclang('label') ?></div>
                                                                                                    <input class="input_validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_attributes][<?= $attr->id; ?>][label]" value="<?= $attr->attribute_label; ?>" type="text">
                                                                                                </div>
                                                                                                <a class="text-red delete-option fa fa-trash" data-original-title="" title=""></a>
                                                                                            </div>
                                                                                    <?php
                                                                                        }
                                                                                    endif;
                                                                                    ?>
                                                                                </div>
                                                                                <a class="box-custom-option input btn btn-flat btn-block text-black add-option">
                                                                                    <i class="fa fa-plus-circle"></i> <?= cclang('add_new_attributes') ?>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                                <td class="hide-preview" width="35%">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group ">
                                                                            <select class="form-control chosen chosen-select input_type" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][input_type]" id="input_type" tabi-ndex="5" data-placeholder="Select Type">
                                                                                <?php foreach (db_get_all_data('crud_input_type') as $input) :  ?>
                                                                                    <option value="<?= $input->type; ?>" class="<?= $input->type; ?>" title="<?= $input->validation_group; ?>" relation="<?= $input->relation; ?>" custom-value="<?= $input->custom_value; ?>" <?= $input->type == $toolbox->input_type ? 'selected="selected"' : ''; ?>><?= ucwords(clean_snake_case($input->type)); ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="custom-option-container display-none">
                                                                        <i class="fa fa-minus btn-collapse-option"></i>
                                                                        <div class="custom-option-contain">
                                                                            <?php if (isset($form_custom_option[$toolbox->id])) : ?>
                                                                                <?php foreach ($form_custom_option[$toolbox->id] as $opt) : ?>
                                                                                    <div class="custom-option-item">
                                                                                        <div class="box-custom-option padding-left-0 box-top">
                                                                                            <div class="col-md-3"><?= cclang('value') ?></div> <input type="text" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_option][<?= $opt->id; ?>][value]" value="<?= $opt->option_value; ?>"></label>
                                                                                        </div>
                                                                                        <div class="box-custom-option padding-left-0 box-bottom">
                                                                                            <div class="col-md-3"><?= cclang('label') ?></div> <input type="text" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_option][<?= $opt->id; ?>][label]" value="<?= $opt->option_label; ?>">
                                                                                        </div>
                                                                                        <a class="text-red delete-option fa fa-trash" data-original-title="" title=""></a>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <a class="box-custom-option input btn btn-flat btn-block bg-black  add-option">
                                                                            <i class="fa fa-plus-circle"></i> <?= cclang('add_new_option') ?>
                                                                        </a>
                                                                    </div>
                                                                    <?php if (!empty($toolbox->relation_table)) : ?>
                                                                        <div class="col-md-12 margin-0">
                                                                            <div class="form-group">
                                                                                <label><small class="text-muted"><?= cclang('table_reff') ?></small></label>
                                                                                <select class="form-control chosen chosen-select relation_table relation_field" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][relation_table]" id="relation_table" tab-index="5" data-placeholder="Select Table">
                                                                                    <option value=""></option>
                                                                                    <?php foreach ($this->db->list_tables() as $table) : ?>
                                                                                        <option <?= $toolbox->relation_table == $table ? 'selected' : ''; ?> value="<?= $table; ?>"><?= $table; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 margin-0">
                                                                            <div class="form-group ">
                                                                                <label><small class="text-muted"><?= cclang('value_field_reff') ?></small></label>
                                                                                <select class="form-control chosen chosen-select relation_value relation_field" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][relation_value]" id="relation_value" tabi-ndex="5" data-placeholder="Select ID">
                                                                                    <option value=""></option>
                                                                                    <?php foreach ($this->db->list_fields($toolbox->relation_table) as $field) { ?>
                                                                                        <option <?= $toolbox->relation_value == $field ? 'selected' : ''; ?> value="<?= $field; ?>"><?= ucwords($field); ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 margin-0">
                                                                            <div class="form-group ">
                                                                                <label><small class="text-muted"><?= cclang('label_field_reff') ?></small></label>
                                                                                <select class="form-control chosen chosen-select relation_label relation_field" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][relation_label]" id="relation_label" tabi-ndex="5" data-placeholder="Select Label">
                                                                                    <option value=""></option>
                                                                                    <?php foreach ($this->db->list_fields($toolbox->relation_table) as $field) { ?>
                                                                                        <option <?= $toolbox->relation_label == $field ? 'selected' : ''; ?> value="<?= $field; ?>"><?= ucwords($field); ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <div class="col-md-12 margin-0">
                                                                            <div class="form-group display-none ">
                                                                                <label><small class="text-muted"><?= cclang('table_reff') ?></small></label>
                                                                                <select class="form-control chosen chosen-select relation_table relation_field" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][relation_table]" id="relation_table" tabi-ndex="5" data-placeholder="Select Table">
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
                                                                                <select class="form-control chosen chosen-select relation_value relation_field" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][relation_value]" id="relation_value" tabi-ndex="5" data-placeholder="Select ID">
                                                                                    <option value=""></option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 margin-0">
                                                                            <div class="form-group display-none ">
                                                                                <label><small class="text-muted"><?= cclang('label_field_reff') ?></small></label>
                                                                                <select class="form-control chosen chosen-select relation_label relation_field" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][relation_label]" id="relation_label" tabi-ndex="5" data-placeholder="Select Label">
                                                                                    <option value=""></option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </td>

                                                                <td class="hide-preview" width="35%">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group ">
                                                                            <select class="form-control chosen chosen-select validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][validation]" id="validation" tabi-ndex="5" data-placeholder="+ <?= cclang('add_rules') ?>">
                                                                                <option value="" class="input file number text datetime select"></option>
                                                                                <?php
                                                                                foreach (db_get_all_data('crud_input_validation') as $input) :
                                                                                ?>
                                                                                    <option value="<?= $input->validation; ?>" class="<?= str_replace(',', ' ', $input->group_input); ?>" data-group-validation="<?= str_replace(',', ' ', $input->group_input); ?>" data-placeholder="<?= $input->input_placeholder; ?>" title="<?= $input->input_able; ?>"><?= ucwords(clean_snake_case($input->validation)); ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (isset($form_field_validation[$toolbox->id])) :
                                                                        foreach ($form_field_validation[$toolbox->id] as $rule) {
                                                                    ?>
                                                                            <div class="box-validation <?= str_replace(',', ' ', $rule->group_input) . ' ' . $rule->validation_name; ?>">
                                                                                <label>
                                                                                    <div class="validation-name<?= $rule->input_able == 'yes' ? '' : '-max'; ?>"><?= clean_snake_case($rule->validation); ?></div>
                                                                                    <input class="input_validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][validation][rules][<?= $rule->validation; ?>]" type="<?= $rule->input_able == 'yes' ? 'text' : 'hidden'; ?>" value="<?= $rule->validation_value; ?>">
                                                                                </label> <a class="delete fa fa-trash"></a>
                                                                            </div>
                                                                    <?php
                                                                        }
                                                                    endif; ?>
                                                                </td>
                                                                <td class="hide-preview">
                                                                    <i class="fa fa-close pointer  delete-item" title="delete item"></i>
                                                                </td>
                                                            </tr>
                                                        <?php } elseif ($toolbox->input_type == 'heading') { ?>
                                                            <tr>
                                                                <td class="dragable hide-preview" width="2%">
                                                                    <i class="fa fa-bars fa-lg text-muted"></i>
                                                                    <input type="hidden" name="form[<?= $toolbox->id; ?>][heading][sort]" class="priority" value="<?= $toolbox->id; ?>">
                                                                    <input type="hidden" class="form-id" id="form-id" value="<?= $toolbox->id; ?>">
                                                                    <input type="hidden" class="form-name" id="form-name" value="heading">
                                                                </td>
                                                                <td class="dragable hide-designer" width="10%">
                                                                    <i class="fa fa-paragraph"></i>
                                                                </td>
                                                                <td class=" hide-designer" width="80%">
                                                                    Heading
                                                                </td>
                                                                <td class="field-name-preview hide-preview" width="28%">
                                                                    <div class="setting-container">
                                                                        <i class="fa fa-minus btn-collapse-setting"></i>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('heading_label') ?></div>
                                                                                <input class="input_setting" name="form[<?= $toolbox->id; ?>][heading][input_label]" value="<?= $toolbox->field_label; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('heading_type') ?></div>
                                                                                <div >
                                                                                    <div class="form-group ">
                                                                                        <select class="form-control chosen chosen-select " name="form[<?= $toolbox->id; ?>][heading][input_name]" id="input_type" tabi-ndex="5" data-placeholder="Select Type">
                                                                                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                                                                                <option <?= $toolbox->field_name == 'h' . $i ? 'selected' : '' ?> value="h<?= $i; ?>">H<?= $i; ?></option>
                                                                                            <?php endfor; ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <div class="setting-name">
                                                                                <span><?= cclang('custom_attributes') ?> </span>
                                                                                <i class="fa fa-minus btn-collapse-attributes pull-right"></i>
                                                                            </div>
                                                                            <div class="custom-option-container custom-attributes-container" data-type="attributes">
                                                                                <div class="custom-option-contain ignore-first-child">
                                                                                    <?php
                                                                                    if (isset($form_custom_attribute[$toolbox->id])) :
                                                                                        foreach ($form_custom_attribute[$toolbox->id] as $attr) { ?>
                                                                                            <div class="custom-option-item custom-option-<?= $attr->id; ?>">
                                                                                                <div class="box-custom-option input padding-left-0 box-top">
                                                                                                    <div class="col-md-3">value</div>
                                                                                                    <input class="input_validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_attributes][<?= $attr->id; ?>][value]" value="<?= $attr->attribute_value; ?>" type="text">
                                                                                                </div>
                                                                                                <div class="box-custom-option input padding-left-0 box-bottom">
                                                                                                    <div class="col-md-3">label</div>
                                                                                                    <input class="input_validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_attributes][<?= $attr->id; ?>][label]" value="<?= $attr->attribute_label; ?>" type="text">
                                                                                                </div>
                                                                                                <a class="text-red delete-option fa fa-trash" data-original-title="" title=""></a>
                                                                                            </div>
                                                                                    <?php
                                                                                        }
                                                                                    endif;
                                                                                    ?>
                                                                                </div>
                                                                                <a class="box-custom-option input btn btn-flat btn-block text-black add-option">
                                                                                    <i class="fa fa-plus-circle"></i> <?= cclang('add_new_attributes') ?>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                </td>
                                                                <td class="hide-preview">
                                                                    <div class="col-md-12 ">
                                                                        <div class="form-group ">
                                                                            <select class="form-control chosen chosen-select input_type" name="form[<?= $toolbox->id; ?>][heading][input_type]" id="input_type" tabi-ndex="5" data-placeholder="Select Type">
                                                                                <option value="heading">Heading</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="hide-preview"></td>
                                                                <td class="hide-preview">
                                                                    <i class="fa fa-close pointer  delete-item" title="delete item"></i>
                                                                </td>
                                                            </tr>
                                                        <?php } elseif ($toolbox->input_type == 'captcha') { ?>

                                                            <tr>
                                                                <td class="dragable hide-preview" width="2%">
                                                                    <i class="fa fa-bars fa-lg text-muted"></i>
                                                                    <input type="hidden" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][sort]" class="priority" value="<?= $toolbox->id; ?>">
                                                                    <input type="hidden" class="form-id" id="form-id" value="<?= $toolbox->id; ?>">
                                                                    <input type="hidden" class="form-name" id="form-name" value="<?= $toolbox->field_name; ?>">
                                                                </td>
                                                                <td class="dragable hide-designer" width="10%">
                                                                    <span class="demo-icon">&#xe80d;</span>
                                                                </td>
                                                                <td class=" hide-designer" width="80%">
                                                                    Captcha
                                                                </td>
                                                                <td class="field-name-preview hide-preview" width="30%">
                                                                    <div class="setting-container">
                                                                        <i class="fa fa-minus btn-collapse-setting"></i>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('field_label') ?></div>
                                                                                <input class="input_setting field_label" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][input_label]" value="<?= $toolbox->field_label; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('field_name') ?></div>
                                                                                <input class="input_setting field_name" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][input_name]" value="<?= $toolbox->field_name; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><span><?= cclang('show_in_column'); ?> ?</span>
                                                                                    <div class="pull-right">
                                                                                        <input class="switch-button pull-right" type="checkbox" checked="" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][show_in_column]" value="yes" title="automatic generated help block">
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('placeholder') ?></div>
                                                                                <input class="input_setting" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][placeholder]" value="<?= $toolbox->placeholder; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><?= cclang('field_name') ?></div>
                                                                                <input class="input_setting field_name" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][input_name]" value="<?= $toolbox->field_name; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <label>
                                                                                <div class="setting-name"><span><?= cclang('auto_generate_help_block') ?> ?</span>
                                                                                    <div class="pull-right">
                                                                                        <input class="switch-button pull-right" type="checkbox" <?= $toolbox->auto_generate_help_block == 'yes' ? 'checked' : ''; ?> name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][auto_generated_helpblock]" value="yes" title="automatic generated help block">
                                                                                    </div>
                                                                                </div>
                                                                                <input class="input_setting  <?= $toolbox->auto_generate_help_block == 'yes' ? 'display-none' : ''; ?>" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][help_block]" value="<?= $toolbox->help_block; ?>" placeholder="type help block here">
                                                                            </label>
                                                                        </div>
                                                                        <div class="box-setting">
                                                                            <div class="setting-name">
                                                                                <span><?= cclang('custom_attributes') ?> </span>
                                                                                <i class="fa fa-minus btn-collapse-attributes pull-right"></i>
                                                                            </div>
                                                                            <div class="custom-option-container  custom-attributes-container" data-type="attributes">
                                                                                <div class="custom-option-contain ignore-first-child">
                                                                                    <?php
                                                                                    if (isset($form_custom_attribute[$toolbox->id])) :
                                                                                        foreach ($form_custom_attribute[$toolbox->id] as $attr) { ?>
                                                                                            <div class="custom-option-item custom-option-<?= $attr->id; ?>">
                                                                                                <div class="box-custom-option input padding-left-0 box-top">
                                                                                                    <div class="col-md-3">value</div>
                                                                                                    <input class="input_validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_attributes][<?= $attr->id; ?>][value]" value="<?= $attr->attribute_value; ?>" type="text">
                                                                                                </div>
                                                                                                <div class="box-custom-option input padding-left-0 box-bottom">
                                                                                                    <div class="col-md-3">label</div>
                                                                                                    <input class="input_validation" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][custom_attributes][<?= $attr->id; ?>][label]" value="<?= $attr->attribute_label; ?>" type="text">
                                                                                                </div>
                                                                                                <a class="text-red delete-option fa fa-trash" data-original-title="" title=""></a>
                                                                                            </div>
                                                                                    <?php
                                                                                        }
                                                                                    endif;
                                                                                    ?>
                                                                                </div>
                                                                                <a class="box-custom-option input btn btn-flat btn-block text-black add-option">
                                                                                    <i class="fa fa-plus-circle"></i> <?= cclang('add_new_attributes') ?>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                                <td class="hide-preview" colspan="1">
                                                                    <div class="col-md-12 ">
                                                                        <div class="form-group ">
                                                                            <select class="form-control chosen chosen-select input_type" name="form[<?= $toolbox->id; ?>][<?= $toolbox->field_name; ?>][input_type]" id="input_type" tabi-ndex="5" data-placeholder="Select Type">
                                                                                <option value="captcha">Captcha</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="hide-preview"></td>
                                                                <td class="hide-preview">
                                                                    <i class="fa fa-close pointer  delete-item" title="delete item"></i>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="view-nav">
                                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="save (Ctrl+s)"><i class="fa fa-save"></i> <?= cclang('save_button'); ?></button>
                                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)"><i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?></a>
                                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)"><i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?></a>
                                            <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_saving_data'); ?></i></span>
                                        </div>
                                    </div>
                                    <div class="tab-pane rest-page-test" id="tab_2">
                                        <div class="preview-form display-none">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="validation_rules display-none">
                            <option value="" class="<?= $this->model_form->get_input_type(); ?>"></option>
                            <?php foreach (db_get_all_data('crud_input_validation') as $input) : ?>
                                <option value="<?= $input->validation; ?>" class="<?= str_replace(',', ' ', $input->group_input); ?>" title="<?= $input->input_able; ?>" data-placeholder="<?= $input->input_placeholder; ?>"><?= ucwords(clean_snake_case($input->validation)); ?></option>
                            <?php endforeach; ?>
                        </div>
                        <div class="message no-message-padding">
                        </div>

                        <?= form_close(); ?>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <?php $this->load->view('backend/standart/administrator/form/form_component'); ?>

    <div class="btn-round-element noselect " title="<?= cclang('add_block_element'); ?>" data-toggle="control-sidebar">
        <span>+</span>
    </div>
</section>


<script src="<?= BASE_ASSET ?>float-thead/jquery.floatThead.min.js"></script>
<script src="<?= BASE_ASSET ?>ckeditor/ckeditor.js"></script>
<script src="<?= BASE_ASSET ?>js/form.js"></script>
<script src="<?= BASE_ASSET ?>js/page/form/form-update.js"></script>