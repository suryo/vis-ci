<link rel="stylesheet" type="text/css" href="<?= BASE_ASSET ?>css/rest.css">

<section class="content-header">
    <h1>
        Rest <small><?= cclang('detail', ['Rest']); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= site_url('administrator/rest'); ?>">Rest</a></li>
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
                            <div class="row pull-right">
                                <a class="btn btn-flat btn-success btn_rest_tool" id="btn_add_new" title="rest API tool" href="<?= site_url('administrator/rest/tool'); ?>"><i class="fa fa-chrome"></i> <?= cclang('tool', ['Rest']); ?></a>
                                <a class="btn btn-flat btn-success btn_rest_tool" id="btn_request_token" title="rest API user request token" href="<?= site_url('administrator/rest/tool/get-token'); ?>"><i class="fa  fa-unlock-alt"></i> <?= cclang('get_token'); ?></a>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET ?>img/view.png" alt="User Avatar">
                            </div>

                            <h3 class="widget-user-username">Rest</h3>
                            <h5 class="widget-user-desc"><?= cclang('detail', ['Rest']); ?></h5>
                            <hr>
                        </div>

                        <div class="form-horizontal" name="form_rest" id="form_rest">

                            <div class="form-group ">
                                <label for="content" class="col-sm-2 control-label">Endpoint </label>

                                <div class="col-sm-8">
                                    <?= base_url('api/' . $rest->table_name); ?>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="content" class="col-sm-2 control-label">Subject </label>

                                <div class="col-sm-8">
                                    <?= _ent($rest->subject); ?>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="content" class="col-sm-2 control-label">Table Name </label>

                                <div class="col-sm-8">
                                    <?= _ent($rest->table_name); ?>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="content" class="col-sm-2 control-label">Request Header </label>

                                <div class="col-sm-8">
                                    <div class="col-sm-2 padding-left-0">
                                        <input class="flat-red check" type="checkbox" checked> X-Api-Key
                                    </div>
                                    <div class="col-sm-2 padding-left-0">
                                        <input class="flat-red check" type="checkbox" <?= $rest->x_token == 'yes' ? 'checked' : ''; ?>> X-Token
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>

                            <div class="col-md-12 padding-left-0 padding-right-0">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">

                                        <li><a class="btn-call-page-test" data-url="<?= base_url('administrator/rest/get_rest_test_all/' . $rest->id); ?>" href="#tab_1" data-toggle="tab">API <?= cclang('all'); ?> <span class="method">GET</span></a></li>
                                        <?php if ($rest->primary_key) : ?>
                                            <li><a class="btn-call-page-test" data-url="<?= base_url('administrator/rest/get_rest_test_add/' . $rest->id); ?>" href="#tab_1" data-toggle="tab">API <?= cclang('add'); ?> <span class="method">POST</span></a></li>
                                            <li><a class="btn-call-page-test" data-url="<?= base_url('administrator/rest/get_rest_test_update/' . $rest->id); ?>" href="#tab_1" data-toggle="tab">API <?= cclang('update'); ?> <span class="method">POST</span></a></li>
                                            <li><a class="btn-call-page-test" data-url="<?= base_url('administrator/rest/get_rest_test_detail/' . $rest->id); ?>" href="#tab_1" data-toggle="tab">API <?= cclang('detail'); ?> <span class="method">GET</span></a></li>

                                            <li><a class="btn-call-page-test" data-url="<?= base_url('administrator/rest/get_rest_test_delete/' . $rest->id); ?>" href="#tab_1" data-toggle="tab">API <?= cclang('delete'); ?> <span class="method">POST</span></a></li>
                                            <li class="active"><a href="#tab_6" data-toggle="tab"><?= cclang('detail'); ?> Rest</a></li>
                                        <?php endif ?>

                                        <li class="pull-right"><a href="<?= site_url('administrator/doc/api#api-' . $rest->subject); ?>" class="text-muted"><i class="fa fa-book text-red"></i> <span> <?= cclang('api_documentation'); ?></span></a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane rest-page-test" id="tab_1">

                                        </div>
                                        <div class="tab-pane active" id="tab_6">

                                            <table class="table table-responsive table table-bordered table-striped" id="diagnosis_list">
                                                <thead>
                                                    <tr>
                                                        <th width="20" rowspan="2" valign="midle" class="th-builder-va">No</th>
                                                        <th width="120" rowspan="2" valign="midle" class="th-builder-va">Field</th>
                                                        <th width="80" colspan="4" class="text-center">Show in</th>
                                                        <th width="100" rowspan="2" valign="midle" class="th-builder-va">Input Type</th>
                                                        <th width="200" rowspan="2" valign="midle" class="th-builder-va">Validation</th>
                                                    </tr>
                                                    <tr>
                                                        <th width="60" class="module-page-list column th-builder-va">All <i><b>GET</b></i></th>
                                                        <th width="60" class="module-page-add add_form th-builder-va">Add <i><b>POST</b></i></th>
                                                        <th width="60" class="module-page-update update_form th-builder-va">Update <i><b>POST</b></i></th>
                                                        <th width="60" class="detail_page th-builder-va">Detail <i><b>GET</b></i></th>
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
                                                                        <?= ucwords(clean_snake_case($row->input_type)); ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php if (isset($rest_field_validation[$row->id])) :
                                                                    foreach ($rest_field_validation[$row->id] as $rule) {
                                                                ?>
                                                                        <div class="box-validation <?= str_replace(',', ' ', $rule->group_input) . ' ' . $rule->validation_name; ?>">
                                                                            <label><?= _ent(clean_snake_case($rule->validation)); ?> <?= $rule->input_able == 'yes' ? ':' : ''; ?> <span class="text-red"> <?= _ent($rule->validation_value); ?></span>
                                                                        </div>

                                        </div>
                                <?php }
                                                                endif; ?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </table>

                            <div class="view-nav">
                                <?php is_allowed('rest_update', function () use ($rest) { ?>
                                    <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="<?= cclang('update', ['Rest']); ?> (Ctrl+e)" href="<?= site_url('administrator/rest/edit/' . $rest->id); ?>"><i class="fa fa-edit"></i> <?= cclang('update', ['Rest']); ?></a>
                                <?php }) ?>
                                <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/rest/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list', ['Rest']); ?></a>
                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>
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

    var rest_fields = <?= json_encode($rest_field) ?>;
    window.rest = <?= json_encode($rest) ?>;
</script>
<script src="<?= BASE_ASSET ?>js/page/rest/rest-view.js"></script>