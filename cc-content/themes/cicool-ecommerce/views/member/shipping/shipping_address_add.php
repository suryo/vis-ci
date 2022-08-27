<script src="<?= BASE_ASSET ?>js/loadingoverlay.min.js"></script>
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

                            <h3 class="widget-user-username">Shipping Address</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Shipping Address']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_shipping_address',
                            'class'   => 'form-horizontal form-step',
                            'id'      => 'form_shipping_address',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'POST'
                        ]); ?>

                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label">Label
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="label" id="label" placeholder="Label" value="<?= set_value('label'); ?>">
                                <small class="info help-block">
                                    <b>Input Label</b> Max Length : 255.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="phone" class="col-sm-2 control-label">Phone
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?= set_value('phone'); ?>">
                                <small class="info help-block">
                                    <b>Input Phone</b> Max Length : 200.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="country_id" class="col-sm-2 control-label">Country
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="country_id" id="country_id" data-placeholder="Select Country">
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('countries') as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                    <b>Input Country Id</b> Max Length : 11.</small>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="state_id" class="col-sm-2 control-label">State
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="state_id" id="state_id" data-placeholder="Select State">
                                    <option value=""></option>
                                </select>
                                <small class="info help-block">
                                    <b>Input State Id</b> Max Length : 11.</small>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="city_id" class="col-sm-2 control-label">City
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="city_id" id="city_id" data-placeholder="Select City">
                                    <option value=""></option>
                                </select>
                                <small class="info help-block">
                                    <b>Input City Id</b> Max Length : 11.</small>
                            </div>
                        </div>



                        <div class="form-group ">
                            <label for="main" class="col-sm-2 control-label">Main
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-6">
                                <div class="col-md-2 padding-left-0">
                                    <label>
                                        <input type="radio" class="flat-red" name="main" id="main" value="yes">
                                        <?= cclang('yes'); ?>
                                    </label>
                                </div>
                                <div class="col-md-14">
                                    <label>
                                        <input type="radio" class="flat-red" name="main" id="main" value="no">
                                        <?= cclang('no'); ?>
                                    </label>
                                </div>
                                <small class="info help-block">
                                    <b>Input Main</b> Max Length : 50.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="address_detail" class="col-sm-2 control-label">Address Detail
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="address_detail" name="address_detail" rows="5" class="textarea form-control"><?= set_value('address_detail'); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>



                        <div class="message"></div>
                        <div class="row-fluid col-md-7 container-button-bottom">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                                <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
                            </button>
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

<!-- Page script -->
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
                        window.location.href = BASE_URL + 'member/shipping';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').on('click', function() {
            $('.message').fadeOut();

            var form_shipping_address = $('#form_shipping_address');
            var data_post = form_shipping_address.serializeArray();
            var save_type = $(this).attr('data-stype');

            data_post.push({
                name: 'save_type',
                value: save_type
            });

            $('.loading').show();

            $.ajax({
                    url: BASE_URL + '/member/shipping/add_save',
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('.steps li').removeClass('error');
                    $('form').find('.error-input').remove();
                    if (res.success) {

                        if (save_type == 'back') {
                            window.location.href = res.redirect;
                            return;
                        }

                        $('.message').printMessage({
                            message: res.message
                        });
                        $('.message').fadeIn();
                        resetForm();
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





        $('#country_id').on('change', function(event) {
            var val = $(this).val();
            $.LoadingOverlay('show')
            $.ajax({
                    url: BASE_URL + '/member/shipping/ajax_state_id/' + val,
                    dataType: 'JSON',
                })
                .done(function(res) {
                    var html = '<option value=""></option>';
                    $.each(res, function(index, val) {
                        html += '<option value="' + val.id + '">' + val.name + '</option>'
                    });
                    $('#state_id').html(html);
                    $('#state_id').trigger('chosen:updated');

                })
                .fail(function() {
                    toastr['error']('Error', 'Getting data fail')
                })
                .always(function() {
                    $.LoadingOverlay('hide')
                });

        });

        $('#state_id').on('change', function(event) {
            var val = $(this).val();
            $.LoadingOverlay('show')
            $.ajax({
                    url: BASE_URL + '/member/shipping/ajax_city_id/' + val,
                    dataType: 'JSON',
                })
                .done(function(res) {
                    var html = '<option value=""></option>';
                    $.each(res, function(index, val) {
                        html += '<option value="' + val.id + '">' + val.name + '</option>'
                    });
                    $('#city_id').html(html);
                    $('#city_id').trigger('chosen:updated');

                })
                .fail(function() {
                    toastr['error']('Error', 'Getting data fail')
                })
                .always(function() {
                    $.LoadingOverlay('hide')
                });

        });




    }); /*end doc ready*/
</script>