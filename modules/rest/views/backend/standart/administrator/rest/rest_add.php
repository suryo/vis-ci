<link rel="stylesheet" type="text/css" href="<?= BASE_ASSET ?>css/rest.css">

<script src="<?= BASE_ASSET ?>float-thead/jquery.floatThead.min.js"></script>

<section class="content-header">
    <h1>
        Rest
        <small><?= cclang('new', ['Rest']); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= site_url('administrator/rest'); ?>">Rest</a></li>
        <li class="active"><?= cclang('new'); ?></li>
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
                            <h5 class="widget-user-desc"><?= cclang('new', ['Rest']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_rest',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_rest',
                            'method'  => 'POST'
                        ]); ?>
                        <div class="form-group ">
                            <label for="table_name" class="col-sm-2 control-label">Table <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select chosen-select-with-deselect" name="table_name" id="table_name" tabi-ndex="5" data-placeholder="Select Table">
                                    <option value=""></option>
                                    <?php foreach ($tables as $row) : ?>
                                        <option value="<?= $row; ?>"><?= $row; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                    <?= cclang('table_is_being_for_generate'); ?>.
                                </small>
                                <span class="loading2 loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_field_data'); ?></i></span>

                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label">Subject <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?= set_value('subject'); ?>">
                                <small class="info help-block">The subject of rest.</small>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label">Header Required</label>
                            <div class="col-sm-8">
                                <div class="col-md-2 padding-left-0">
                                    <label>
                                        <input class="flat-red check page_read" type="checkbox" id="x_token" value="yes" name="x_token" checked> X-Token
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="wrapper-rest">

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


<script src="<?= BASE_ASSET ?>ckeditor/ckeditor.js"></script>
<script src="<?= BASE_ASSET ?>js/rest.js"></script>
<script src="<?= BASE_ASSET ?>js/page/rest/rest-add.js"></script>