<link href="<?= BASE_ASSET ?>fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET ?>fine-upload/jquery.fine-uploader.js"></script>

<?php $this->load->view('core_template/fine_upload'); ?>

<section class="content-header">
    <h1>
        User
        <small><?= cclang('update', 'Profile'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li ><a href="<?= site_url('administrator/user'); ?>">User</a></li>
        <li class="active"><?= cclang('update', 'Profile'); ?></li>
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

                            <h3 class="widget-user-username">User</h3>
                            <h5 class="widget-user-desc"><?= cclang('update', 'Profile'); ?></h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/user/edit_profile_save/' . $this->uri->segment(4)), [
                            'name'    => 'form_user',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_user',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'POST'
                        ]); ?>

                        <div class="form-group ">
                            <label for="username" class="col-sm-2 control-label">Username <i class="required">*</i></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?= set_value('username', $user->username); ?>">
                                <small class="info help-block">The username of user.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="email" class="col-sm-2 control-label">Email <i class="required">*</i></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= set_value('email', $user->email); ?>">
                                <small class="info help-block">The email of user.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="full_name" class="col-sm-2 control-label">Full Name <i class="required">*</i></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" value="<?= set_value('full_name', $user->full_name); ?>">
                                <small class="info help-block">The full name of user.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="username" class="col-sm-2 control-label">Avatar </label>

                            <div class="col-sm-8">
                                <div id="user_avatar_galery" src="<?= BASE_URL . 'uploads/user/' . $user->avatar; ?>"></div>
                                <input name="user_avatar_uuid" id="user_avatar_uuid" type="hidden" value="<?= set_value('user_avatar_uuid'); ?>">
                                <input name="user_avatar_name" id="user_avatar_name" type="hidden" value="<?= set_value('user_avatar_name', $user->avatar); ?>">
                                <small class="info help-block">
                                    Format file must PNG, JPEG.
                                </small>
                            </div>
                        </div>

                        <?php is_allowed('user_update_password', function () { ?>
                            <div class="form-group ">
                                <label for="password" class="col-sm-2 control-label">Password </label>

                                <div class="col-sm-6">
                                    <div class="input-group col-md-8 input-password">
                                        <input type="password" class="form-control password" name="password" id="password" placeholder="Password" value="<?= set_value('password'); ?>">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-flat show-password"><i class="fa fa-eye eye"></i></button>
                                        </span>
                                    </div>
                                    <small class="info help-block">
                                        <?= cclang('do_not_be_fill_if_you_do_not_want_to_change_the_password'); ?>, <br>The password character must 6 or more.
                                    </small>
                                </div>
                            </div>
                        <?php }) ?>

                        <div class="message">
                        </div>

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

<script src="<?= BASE_ASSET ?>js/page/user/user-update-profile.js"></script>