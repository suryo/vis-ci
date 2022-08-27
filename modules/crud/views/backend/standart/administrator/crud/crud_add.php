<link rel="stylesheet" type="text/css" href="<?= BASE_ASSET ?>css/crud.css">

<script src="<?= BASE_ASSET ?>float-thead/jquery.floatThead.min.js"></script>
<?php $this->load->view('backend/standart/administrator/crud/crud_config_component') ?>

<h1 class="not-working">if this page does not work, please click <?= anchor('web/set_full_group_sql', 'this link') ?> first, you must enable SQL mode to full GROUP </h1>

<section class="content-header">
    <h1>
        Crud
        <small><?= cclang('new', ['Crud']);  ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('home');  ?></a></li>
        <li ><a href="<?= site_url('administrator/crud'); ?>">Crud</a></li>
        <li class="active"><?= cclang('new');  ?></li>
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
                                <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="Crud Avatar">
                            </div>
                            <!-- /.widget-crud-image -->
                            <h3 class="widget-user-username">Crud</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Crud']);  ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_crud',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_crud',
                            'method'  => 'POST'
                        ]); ?>
                        <div class="form-group ">
                            <label for="table_name" class="col-sm-2 control-label"><?= cclang('table_name') ?> <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select chosen-select-with-deselect" name="table_name" id="table_name" tabi-ndex="5" data-placeholder="Select Table">
                                    <option value=""></option>
                                    <?php foreach ($tables as $row) : ?>
                                        <option value="<?= $row; ?>"><?= $row; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                    <?= cclang('table_is_being_for_generate'); ?>
                                </small>
                                <span class="loading2 loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_field_data'); ?></i></span>

                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= cclang('subject') ?> <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?= set_value('subject'); ?>">
                                <small class="info help-block">The subject of crud.</small>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= cclang('title') ?> </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                                <small class="info help-block">The title of crud.</small>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= cclang('page') ?></label>
                            <div class="col-sm-7">
                                <div class="col-xs-3">
                                    <label>
                                        <input class="flat-red check page_create" type="checkbox" id="create" value="yes" name="create" checked> <?= cclang('create'); ?>
                                    </label>
                                </div>
                                <div class="col-xs-3">
                                    <label>
                                        <input class="flat-red check page_read" type="checkbox" id="read" value="yes" name="read" checked> <?= cclang('read'); ?>
                                    </label>
                                </div>
                                <div class="col-xs-3">
                                    <label>
                                        <input class="flat-red check page_update" type="checkbox" id="update" value="yes" name="update" checked> <?= cclang('update'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="wrapper-crud">

                        </div>
                        <div class="validation_rules display-none">
                            <option value="" class="<?= $this->model_crud->get_input_type(); ?>"></option>
                            <?php foreach (db_get_all_data('crud_input_validation') as $input) : ?>
                                <option value="<?= $input->validation; ?>" class="<?= str_replace(',', ' ', $input->group_input); ?>" title="<?= $input->input_able; ?>" data-placeholder="<?= $input->input_placeholder; ?>"><?= ucwords(clean_snake_case($input->validation)); ?></option>
                            <?php endforeach; ?>
                        </div>
                        <div class="message no-message-padding">
                        </div>
                        <div class="view-nav">
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
<script src="<?= BASE_ASSET ?>ckeditor/ckeditor.js"></script>
<script src="<?= BASE_ASSET ?>js/crud.js"></script>
<script src="<?= BASE_ASSET ?>js/page/crud/crud-add.js"></script>