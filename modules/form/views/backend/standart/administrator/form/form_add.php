<link rel="stylesheet" href="<?= BASE_ASSET ?>css/form.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>jquery-switch-button/jquery.switchButton.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>dist/jquery.addressPickerByGiro.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>jquery-map/dist/jquery.addressPickerByGiro.css">

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCOi5vktJx2fjOA4X9orhT_-v2SIvsv060 "></script>
<script src="<?= BASE_ASSET ?>jquery-map/dist/jquery.addressPickerByGiro.js"></script>

<section class="content-header">
    <h1>
        <?= cclang('form'); ?>
        <small><?= cclang('new', 'Form'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('home'); ?></a></li>
        <li ><a href="<?= site_url('administrator/form'); ?>"><?= cclang('form'); ?></a></li>
        <li class="active"><?= cclang('new'); ?></li>
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
                            <h5 class="widget-user-desc"><?= cclang('new', cclang('form')); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_form',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_form',
                            'method'  => 'POST'
                        ]); ?>
                        <input type="hidden" name="id" id="id">
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= cclang('subject'); ?> <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?= set_value('subject'); ?>">
                                <small class="info help-block">The subject of form.</small>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= cclang('title'); ?> </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                                <small class="info help-block">The title of form.</small>
                            </div>
                        </div>
                        <hr>

                        <div class="col-md-12 padding-left-0 padding-right-0">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a class=" active btn-form-designer" href="#tab_1" data-toggle="tab"><i class="fa fa-code text-green"></i> <?= cclang('form_designer'); ?></a></li>
                                    <li><a class=" active btn-form-preview" href="#tab_2" data-toggle="tab"><i class="fa fa-tv text-green"></i> <?= cclang('form_preview'); ?></a></li>
                                    <li> <span class="loading3 loading-hide "><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_getting_data'); ?></i></span></li>
                                    <li class="pull-right"><a href="#" data-toggle="control-sidebar" class="text-muted btn-tool"><?= cclang('tool'); ?> <i class="fa fa-gear"></i></a></li>

                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane rest-page-test active" id="tab_1">
                                        <div class="wrapper-form">
                                            <table class="table table-responsive table table-striped table-form" id="diagnosis_list">
                                                <tbody>
                                                    <tr class="sort-placeholder">
                                                        <td colspan="4"><?= cclang('drag_form_here'); ?></td>
                                                    </tr>
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
<script src="<?= BASE_ASSET ?>js/page/form/form-add.js"></script>