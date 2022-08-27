<link href="<?= BASE_ASSET ?>fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET ?>fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>

<script type="text/javascript">
    function domo() {

        $('*').bind('keydown', 'Ctrl+s', function assets() {
            $('#btn_save').trigger('click');
            return false;
        });

        $('*').bind('keydown', 'Ctrl+x', function assets() {
            $('#btn_cancel').trigger('click');
            return false;
        });

        $('*').bind('keydown', 'Ctrl+d', function assets() {
            $('.btn_save_back').trigger('click');
            return false;
        });

    }

    jQuery(document).ready(domo);
</script>

<section class="content-header">
    <h1>
        Order Confirmation <small><?= cclang('new', ['Order Confirmation']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= site_url('member/order'); ?>">Order </a></li>
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

                            <h3 class="widget-user-username">Order Confirmation</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Order Confirmation']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_order_confirmation',
                            'class'   => 'form-horizontal form-step',
                            'id'      => 'form_order_confirmation',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'POST'
                        ]); ?>

                        <div class="form-group ">
                            <label for="transaction_id" class="col-sm-2 control-label">Transaction Id
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="transaction_id" id="transaction_id" data-placeholder="Select Transaction Id">
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('transaction', ['user_id' => get_user_data('id')]) as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->invoice_id; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                    <b>Input Transaction Id</b> Max Length : 11.</small>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="image" class="col-sm-2 control-label">Image
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="order_confirmation_image_galery"></div>
                                <input class="data_file" name="order_confirmation_image_uuid" id="order_confirmation_image_uuid" type="hidden" value="<?= set_value('order_confirmation_image_uuid'); ?>">
                                <input class="data_file" name="order_confirmation_image_name" id="order_confirmation_image_name" type="hidden" value="<?= set_value('order_confirmation_image_name'); ?>">
                                <small class="info help-block">
                                    <b>Extension file must</b> JPG,PNG,PDF,WORD,JPEG.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="title" class="col-sm-2 control-label">Title
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                                <small class="info help-block">
                                    <b>Input Title</b> Max Length : 255.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="description" class="col-sm-2 control-label">Description
                            </label>
                            <div class="col-sm-8">
                                <textarea id="description" name="description" rows="5" class="textarea form-control"><?= set_value('description'); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                        <div class="message"></div>
                        <div class="row-fluid col-md-7 container-button-bottom">

                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                                <i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                                <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
                            </a>
                            <span class="loading loading-hide">
                                <img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg">
                                <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {


        $('#btn_cancel').on('click', function() {
            swal({
                    title: "<?= cclang('are_you_sure'); ?>",
                    text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = BASE_URL + 'member/order';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').on('click', function() {
            $('.message').fadeOut();

            var form_order_confirmation = $('#form_order_confirmation');
            var data_post = form_order_confirmation.serializeArray();
            var save_type = $(this).attr('data-stype');

            data_post.push({
                name: 'save_type',
                value: save_type
            });

            $('.loading').show();

            $.ajax({
                    url: BASE_URL + '/member/order/add_save',
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('.steps li').removeClass('error');
                    $('form').find('.error-input').remove();
                    if (res.success) {
                        var id_image = $('#order_confirmation_image_galery').find('li').attr('qq-file-id');

                        if (save_type == 'back') {
                            window.location.href = res.redirect;
                            return;
                        }

                        $('.message').printMessage({
                            message: res.message
                        });
                        $('.message').fadeIn();
                        resetForm();
                        if (typeof id_image !== 'undefined') {
                            $('#order_confirmation_image_galery').fineUploader('deleteFile', id_image);
                        }
                        $('.chosen option').prop('selected', false).trigger('chosen:updated');

                    } else {
                        if (res.errors) {

                            $.each(res.errors, function(index, val) {
                                $('form #' + index).parents('.form-group').addClass('has-error');
                                $('form #' + index).parents('.form-group').find('small').prepend(`
                      <div class="error-input">` + val + `</div>
                      `);
                            });
                            $('.steps li').removeClass('error');
                            $('.content section').each(function(index, el) {
                                if ($(this).find('.has-error').length) {
                                    $('.steps li:eq(' + index + ')').addClass('error').find('a').trigger('click');
                                }
                            });
                        }
                        $('.message').printMessage({
                            message: res.message,
                            type: 'warning'
                        });
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
                    }, 2000);
                });

            return false;
        }); /*end btn save*/

        var params = {};
        params[csrf] = token;

        $('#order_confirmation_image_galery').fineUploader({
            template: 'qq-template-gallery',
            request: {
                endpoint: BASE_URL + '/member/order/upload_image_file',
                params: params
            },
            deleteFile: {
                enabled: true,
                endpoint: BASE_URL + '/member/order/delete_image_file',
            },
            thumbnails: {
                placeholders: {
                    waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                    notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
                }
            },
            multiple: false,
            validation: {
                allowedExtensions: ["jpg", "png", "pdf", "word", "jpeg"],
                sizeLimit: 0,
            },
            showMessage: function(msg) {
                toastr['error'](msg);
            },
            callbacks: {
                onComplete: function(id, name, xhr) {
                    if (xhr.success) {
                        var uuid = $('#order_confirmation_image_galery').fineUploader('getUuid', id);
                        $('#order_confirmation_image_uuid').val(uuid);
                        $('#order_confirmation_image_name').val(xhr.uploadName);
                    } else {
                        toastr['error'](xhr.error);
                    }
                },
                onSubmit: function(id, name) {
                    var uuid = $('#order_confirmation_image_uuid').val();
                    $.get(BASE_URL + '/member/order/delete_image_file/' + uuid);
                },
                onDeleteComplete: function(id, xhr, isError) {
                    if (isError == false) {
                        $('#order_confirmation_image_uuid').val('');
                        $('#order_confirmation_image_name').val('');
                    }
                }
            }
        }); /*end image galery*/
    }); /*end doc ready*/
</script>