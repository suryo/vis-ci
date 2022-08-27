<link href="<?= BASE_ASSET ?>fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET ?>fine-upload/jquery.fine-uploader.js"></script>

<?php $this->load->view('core_template/fine_upload'); ?>

<?php $user = $this->db->get_where('aauth_users', ['id' => get_user_data('id')])->row() ?>

<section class="content-header">
    <h1>
        Account <small><?= cclang('update', ['Account']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li ><a href="<?= site_url('member/order'); ?>">Account</a></li>
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
                                <img class="img-circle" src="<?= BASE_ASSET ?>img/view.png" alt="User Avatar">
                            </div>
                            <div class="pull-right">
                                <?php is_allowed('shipping_address_add', function () { ?>
                                    <a class="btn btn-flat btn-danger btn_add_new" id="btn_add_new" title="<?= cclang('continue_for_checkout'); ?>  (Ctrl+a)" href="<?= site_url('checkout'); ?>"><span class="fal fa-plus-square"></span> <?= cclang('continue_for_checkout'); ?></a>
                                <?php }) ?>
                            </div>

                            <h3 class="widget-user-username">Account</h3>
                            <h5 class="widget-user-desc">Update Account</h5>

                            <hr>
                        </div>

                        <?= form_open(base_url('member/account/edit_profile_save/'), [
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
                            <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_saving_data'); ?></i></span>

                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>

    <script src="<?= BASE_ASSET ?>ckeditor/ckeditor.js"></script>

    <script>
        $(document).ready(function() {

            "use strict";

            $('.btn_save').on('click', function() {
                $('.message').fadeOut();

                var form_user = $('#form_user');
                var data_post = form_user.serializeArray();
                var save_type = $(this).attr('data-stype');

                data_post.push({
                    name: 'save_type',
                    value: save_type
                });
                $('.loading').show();

                $.ajax({
                        url: form_user.attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: data_post,
                    })
                    .done(function(res) {
                        if (res.success) {
                            var id = $('#user_avatar_galery').find('li').attr('qq-file-id');
                            $('#user_avatar_uuid').val('');
                            $('#user_avatar_name').val('');

                            if (save_type == 'back') {
                                window.location.href = window.base_url + 'member/account/profile';
                                return;
                            }

                            $('.message').printMessage({
                                message: res.message
                            });
                            $('.message').fadeIn();

                        } else {
                            $('.message').printMessage({
                                message: res.message,
                                type: 'warning'
                            });
                            $('.message').fadeIn();
                        }

                    })
                    .fail(function() {
                        $('.message').printMessage({
                            message: 'Error save data',
                            type: 'warning'
                        });
                    })
                    .always(function() {
                        $('.loading').hide();
                        $('html, body').animate({
                            scrollTop: $(document).height()
                        }, 1000);
                    });

                return false;
            }); 

            $('#user_avatar_galery').fineUploader({
                template: 'qq-template-gallery',
                request: {
                    endpoint: window.base_url + 'member/account/upload_avatar_file',
                    params: {
                        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                    }
                },
                deleteFile: {
                    enabled: true,
                    endpoint: window.base_url + 'member/account/delete_avatar_file',
                },
                thumbnails: {
                    placeholders: {
                        waitingPath: window.base_url + '/asset/fine-upload/placeholders/waiting-generic.png',
                        notAvailablePath: window.base_url + '/asset/fine-upload/placeholders/not_available-generic.png'
                    }
                },
                session: {
                    endpoint: window.base_url + 'member/account/get_avatar_file/<?= $user->id; ?>',
                    refreshOnRequest: true
                },
                multiple: false,
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
                },
                showMessage: function(msg) {
                    toastr['error'](msg);
                },
                callbacks: {
                    onComplete: function(id, name) {
                        var uuid = $('#user_avatar_galery').fineUploader('getUuid', id);
                        $('#user_avatar_uuid').val(uuid);
                        $('#user_avatar_name').val(name);
                    },
                    onSubmit: function(id, name) {
                        var uuid = $('#user_avatar_uuid').val();
                        $.get(window.base_url + '/administrator/user/delete_image_file/' + uuid);
                    }
                }
            });
        }); 
    </script>