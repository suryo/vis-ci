

    <link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
    <script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
    <?php $this->load->view('core_template/fine_upload'); ?>
<script type="text/javascript">
    function domo() {

        $('*').bind('keydown', 'Ctrl+s', function() {
            $('#btn_save').trigger('click');
            return false;
        });

        $('*').bind('keydown', 'Ctrl+x', function() {
            $('#btn_cancel').trigger('click');
            return false;
        });

        $('*').bind('keydown', 'Ctrl+d', function() {
            $('.btn_save_back').trigger('click');
            return false;
        });

    }

    jQuery(document).ready(domo);
</script>
<section class="content-header">
    <h1>
        Vis Data Penduduks        <small>Edit Vis Data Penduduks</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= site_url('administrator/vis_data_penduduks'); ?>">Vis Data Penduduks</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<style>

</style>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <h3 class="widget-user-username">Vis Data Penduduks</h3>
                            <h5 class="widget-user-desc">Edit Vis Data Penduduks</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/vis_data_penduduks/edit_save/'.$this->uri->segment(4)), [
                            'name' => 'form_vis_data_penduduks',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_vis_data_penduduks',
                            'method' => 'POST'
                        ]); ?>

                        <?php
                        $user_groups = $this->model_group->get_user_group_ids();
                        ?>

                                                    
                        
                        <div class="form-group group-nama  ">
                                <label for="nama" class="col-sm-2 control-label">Nama                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="" value="<?= set_value('nama', $vis_data_penduduks->nama); ?>">
                                    <small class="info help-block">
                                        <b>Input Nama</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-jk  ">
                                <label for="jk" class="col-sm-2 control-label">Jenis Kelamin                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="jk" id="jk" placeholder="" value="<?= set_value('jk', $vis_data_penduduks->jk); ?>">
                                    <small class="info help-block">
                                        <b>Input Jk</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-nik  ">
                                <label for="nik" class="col-sm-2 control-label">NIK                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nik" id="nik" placeholder="" value="<?= set_value('nik', $vis_data_penduduks->nik); ?>">
                                    <small class="info help-block">
                                        <b>Input Nik</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-tempat_lahir  ">
                                <label for="tempat_lahir" class="col-sm-2 control-label">Tempat Lahir                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="" value="<?= set_value('tempat_lahir', $vis_data_penduduks->tempat_lahir); ?>">
                                    <small class="info help-block">
                                        <b>Input Tempat Lahir</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-tanggal_lahir  ">
                                <label for="tanggal_lahir" class="col-sm-2 control-label">Tanggal Lahir                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-6">
                                    <div class="input-group date col-sm-8">
                                        <input type="text" class="form-control pull-right datepicker" name="tanggal_lahir" placeholder="" id="tanggal_lahir" value="<?= set_value('vis_data_penduduks_tanggal_lahir_name', $vis_data_penduduks->tanggal_lahir); ?>">
                                    </div>
                                    <small class="info help-block">
                                        </small>
                                </div>
                            </div>

                        
                        
                                                    
                        
                        <div class="form-group group-agama  ">
                                <label for="agama" class="col-sm-2 control-label">Agama                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="agama" id="agama" placeholder="" value="<?= set_value('agama', $vis_data_penduduks->agama); ?>">
                                    <small class="info help-block">
                                        <b>Input Agama</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-status_perkawinan  ">
                                <label for="status_perkawinan" class="col-sm-2 control-label">Status Perkawinan                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="status_perkawinan" id="status_perkawinan" placeholder="" value="<?= set_value('status_perkawinan', $vis_data_penduduks->status_perkawinan); ?>">
                                    <small class="info help-block">
                                        <b>Input Status Perkawinan</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-kewarganegaraan  ">
                                <label for="kewarganegaraan" class="col-sm-2 control-label">Kewarganegaraan                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="kewarganegaraan" id="kewarganegaraan" placeholder="" value="<?= set_value('kewarganegaraan', $vis_data_penduduks->kewarganegaraan); ?>">
                                    <small class="info help-block">
                                        <b>Input Kewarganegaraan</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-pekerjaan  ">
                                <label for="pekerjaan" class="col-sm-2 control-label">Pekerjaan                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" placeholder="" value="<?= set_value('pekerjaan', $vis_data_penduduks->pekerjaan); ?>">
                                    <small class="info help-block">
                                        <b>Input Pekerjaan</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_provinsi  ">
                                <label for="id_provinsi" class="col-sm-2 control-label">Provinsi                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="id_provinsi" id="id_provinsi" placeholder="" value="<?= set_value('id_provinsi', $vis_data_penduduks->id_provinsi); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Provinsi</b> Max Length : 11.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_kabupaten  ">
                                <label for="id_kabupaten" class="col-sm-2 control-label">Kabupaten                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="id_kabupaten" id="id_kabupaten" placeholder="" value="<?= set_value('id_kabupaten', $vis_data_penduduks->id_kabupaten); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Kabupaten</b> Max Length : 11.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_kecamatan  ">
                                <label for="id_kecamatan" class="col-sm-2 control-label">Kecamatan                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="" value="<?= set_value('id_kecamatan', $vis_data_penduduks->id_kecamatan); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Kecamatan</b> Max Length : 11.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_desa  ">
                                <label for="id_desa" class="col-sm-2 control-label">Desa                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="id_desa" id="id_desa" placeholder="" value="<?= set_value('id_desa', $vis_data_penduduks->id_desa); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Desa</b> Max Length : 11.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_dusun  ">
                                <label for="id_dusun" class="col-sm-2 control-label">Dusun                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="id_dusun" id="id_dusun" placeholder="" value="<?= set_value('id_dusun', $vis_data_penduduks->id_dusun); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Dusun</b> Max Length : 11.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_rw  ">
                                <label for="id_rw" class="col-sm-2 control-label">RW                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="id_rw" id="id_rw" placeholder="" value="<?= set_value('id_rw', $vis_data_penduduks->id_rw); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Rw</b> Max Length : 11.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_rt  ">
                                <label for="id_rt" class="col-sm-2 control-label">RT                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="id_rt" id="id_rt" placeholder="" value="<?= set_value('id_rt', $vis_data_penduduks->id_rt); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Rt</b> Max Length : 11.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-telp  ">
                                <label for="telp" class="col-sm-2 control-label">Telp 1                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="telp" id="telp" placeholder="" value="<?= set_value('telp', $vis_data_penduduks->telp); ?>">
                                    <small class="info help-block">
                                        <b>Input Telp</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-telp2  ">
                                <label for="telp2" class="col-sm-2 control-label">Telp 2                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="telp2" id="telp2" placeholder="" value="<?= set_value('telp2', $vis_data_penduduks->telp2); ?>">
                                    <small class="info help-block">
                                        <b>Input Telp2</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-file  ">
                                <label for="file" class="col-sm-2 control-label">File                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <div id="vis_data_penduduks_file_galery"></div>
                                    <input class="data_file data_file_uuid" name="vis_data_penduduks_file_uuid" id="vis_data_penduduks_file_uuid" type="hidden" value="<?= set_value('vis_data_penduduks_file_uuid'); ?>">
                                    <input class="data_file" name="vis_data_penduduks_file_name" id="vis_data_penduduks_file_name" type="hidden" value="<?= set_value('vis_data_penduduks_file_name', $vis_data_penduduks->file); ?>">
                                    <small class="info help-block">
                                        <b>Input File</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-id_kk  ">
                                <label for="id_kk" class="col-sm-2 control-label">No KK                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="id_kk" id="id_kk" placeholder="" value="<?= set_value('id_kk', $vis_data_penduduks->id_kk); ?>">
                                    <small class="info help-block">
                                        <b>Input Id Kk</b> Max Length : 255.</small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-created_at  ">
                                <label for="created_at" class="col-sm-2 control-label">Created At                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-6">
                                    <div class="input-group date col-sm-8">
                                        <input type="text" class="form-control pull-right datetimepicker" name="created_at" placeholder="" id="created_at" value="<?= set_value('created_at', $vis_data_penduduks->created_at); ?>">
                                    </div>
                                    <small class="info help-block">
                                        </small>
                                </div>
                            </div>
                        
                        
                                                    
                        
                        <div class="form-group group-updated_at  ">
                                <label for="updated_at" class="col-sm-2 control-label">Updated At                                    <i class="required">*</i>
                                    </label>
                                <div class="col-sm-6">
                                    <div class="input-group date col-sm-8">
                                        <input type="text" class="form-control pull-right datetimepicker" name="updated_at" placeholder="" id="updated_at" value="<?= set_value('updated_at', $vis_data_penduduks->updated_at); ?>">
                                    </div>
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

                            <div class="custom-button-wrapper">

                                                        </div>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                                <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
                            </a>
                            <span class="loading loading-hide">
                                <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg">
                                <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                                                <?= form_close(); ?>
                        </div>
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>


<script>
    $(document).ready(function() {

        "use strict";
        
    window.event_submit_and_action = '';
            
    
      
      
      
        
        
    
    $('#btn_cancel').click(function() {
        swal({
                title: "Are you sure?",
                text: "the data that you have created will be in the exhaust!",
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
                    window.location.href = BASE_URL + 'administrator/vis_data_penduduks';
                }
            });

        return false;
    }); /*end btn cancel*/

    $('.btn_save').click(function() {
        $('.message').fadeOut();
        
    var form_vis_data_penduduks = $('#form_vis_data_penduduks');
    var data_post = form_vis_data_penduduks.serializeArray();
    var save_type = $(this).attr('data-stype');
    data_post.push({
        name: 'save_type',
        value: save_type
    });

    
      
    data_post.push({
        name: 'event_submit_and_action',
        value: window.event_submit_and_action
    });

    $('.loading').show();

    $.ajax({
            url: form_vis_data_penduduks.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
        .done(function(res) {
            $('form').find('.form-group').removeClass('has-error');
            $('form').find('.error-input').remove();
            $('.steps li').removeClass('error');
            if (res.success) {
                var id = $('#vis_data_penduduks_image_galery').find('li').attr('qq-file-id');
                if (save_type == 'back') {
                    window.location.href = res.redirect;
                    return;
                }

                $('.message').printMessage({
                    message: res.message
                });
                $('.message').fadeIn();
                $('.data_file_uuid').val('');

            } else {
                if (res.errors) {
                    parseErrorField(res.errors);
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

            $('#vis_data_penduduks_file_galery').fineUploader({
                template: 'qq-template-gallery',
                request: {
                    endpoint: BASE_URL + '/administrator/vis_data_penduduks/upload_file_file',
                    params: params
                },
                deleteFile: {
                    enabled: true, // defaults to false
                    endpoint: BASE_URL + '/administrator/vis_data_penduduks/delete_file_file'
                },
                thumbnails: {
                    placeholders: {
                        waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                        notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
                    }
                },
                session: {
                    endpoint: BASE_URL + 'administrator/vis_data_penduduks/get_file_file/<?= $vis_data_penduduks->id; ?>',
                    refreshOnRequest: true
                },
                multiple: false,
                validation: {
                    allowedExtensions: ["*"],
                    sizeLimit: 0,
                                    },
                showMessage: function(msg) {
                    toastr['error'](msg);
                },
                callbacks: {
                    onComplete: function(id, name, xhr) {
                        if (xhr.success) {
                            var uuid = $('#vis_data_penduduks_file_galery').fineUploader('getUuid', id);
                            $('#vis_data_penduduks_file_uuid').val(uuid);
                            $('#vis_data_penduduks_file_name').val(xhr.uploadName);
                        } else {
                            toastr['error'](xhr.error);
                        }
                    },
                    onSubmit: function(id, name) {
                        var uuid = $('#vis_data_penduduks_file_uuid').val();
                        $.get(BASE_URL + '/administrator/vis_data_penduduks/delete_file_file/' + uuid);
                    },
                    onDeleteComplete: function(id, xhr, isError) {
                        if (isError == false) {
                            $('#vis_data_penduduks_file_uuid').val('');
                            $('#vis_data_penduduks_file_name').val('');
                        }
                    }
                }
            }); /*end file galey*/
            

    

    async function chain() {
            }

    chain();




    }); /*end doc ready*/
</script>