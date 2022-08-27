<section class="content-header">
    <h1>
        API Keys <small><?= cclang('new', 'API Keys'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li ><a href="<?= site_url('administrator/keys'); ?>">API Keys</a></li>
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
                                <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="User Avatar">
                            </div>

                            <h3 class="widget-user-username">API Keys</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', 'API Keys'); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_keys',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_keys',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'POST'
                        ]); ?>

                        <div class="form-group ">
                            <label for="key" class="col-sm-2 control-label">Key
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="key" id="key" placeholder="Key" value="<?= strtoupper(md5(generate_key())); ?>">
                                <small class="info help-block">
                                    <b>Input Key</b> Max Length : 40.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="ip_addresses" class="col-sm-2 control-label">Ip Addresses
                            </label>
                            <div class="col-sm-8">
                                <textarea id="ip_addresses" name="ip_addresses" rows="10" class="textarea form-control"><?= set_value('ip_addresses'); ?></textarea>
                                <small class="info help-block">
                                    IP addreses can access this API.
                                </small>
                            </div>
                        </div>

                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
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

<script src="<?= BASE_ASSET ?>js/page/keys/keys-add.js"></script>