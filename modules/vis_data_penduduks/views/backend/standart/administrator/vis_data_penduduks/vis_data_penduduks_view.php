<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+e', function() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function() {
      $('#btn_back').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>
<section class="content-header">
   <h1>
      Vis Data Penduduks      <small><?= cclang('detail', ['Vis Data Penduduks']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/vis_data_penduduks'); ?>">Vis Data Penduduks</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>
<section class="content">
   <div class="row" >
     
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <div class="box box-widget widget-user-2">
                  <div class="widget-user-header ">
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username">Vis Data Penduduks</h3>
                     <h5 class="widget-user-desc">Detail Vis Data Penduduks</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal form-step" name="form_vis_data_penduduks" id="form_vis_data_penduduks" >
                  
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id"><?= _ent($vis_data_penduduks->id); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Nama </label>

                        <div class="col-sm-8">
                        <span class="detail_group-nama"><?= _ent($vis_data_penduduks->nama); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Jenis Kelamin </label>

                        <div class="col-sm-8">
                        <span class="detail_group-jk"><?= _ent($vis_data_penduduks->jk); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">NIK </label>

                        <div class="col-sm-8">
                        <span class="detail_group-nik"><?= _ent($vis_data_penduduks->nik); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Tempat Lahir </label>

                        <div class="col-sm-8">
                        <span class="detail_group-tempat_lahir"><?= _ent($vis_data_penduduks->tempat_lahir); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Tanggal Lahir </label>

                        <div class="col-sm-8">
                        <span class="detail_group-tanggal_lahir"><?= _ent($vis_data_penduduks->tanggal_lahir); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Agama </label>

                        <div class="col-sm-8">
                        <span class="detail_group-agama"><?= _ent($vis_data_penduduks->agama); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Status Perkawinan </label>

                        <div class="col-sm-8">
                        <span class="detail_group-status_perkawinan"><?= _ent($vis_data_penduduks->status_perkawinan); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Kewarganegaraan </label>

                        <div class="col-sm-8">
                        <span class="detail_group-kewarganegaraan"><?= _ent($vis_data_penduduks->kewarganegaraan); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Pekerjaan </label>

                        <div class="col-sm-8">
                        <span class="detail_group-pekerjaan"><?= _ent($vis_data_penduduks->pekerjaan); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Provinsi </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_provinsi"><?= _ent($vis_data_penduduks->id_provinsi); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Kabupaten </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_kabupaten"><?= _ent($vis_data_penduduks->id_kabupaten); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Kecamatan </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_kecamatan"><?= _ent($vis_data_penduduks->id_kecamatan); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Desa </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_desa"><?= _ent($vis_data_penduduks->id_desa); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Dusun </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_dusun"><?= _ent($vis_data_penduduks->id_dusun); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">RW </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_rw"><?= _ent($vis_data_penduduks->id_rw); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">RT </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_rt"><?= _ent($vis_data_penduduks->id_rt); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Telp 1 </label>

                        <div class="col-sm-8">
                        <span class="detail_group-telp"><?= _ent($vis_data_penduduks->telp); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Telp 2 </label>

                        <div class="col-sm-8">
                        <span class="detail_group-telp2"><?= _ent($vis_data_penduduks->telp2); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> File </label>
                        <div class="col-sm-8">
                             <?php if (is_image($vis_data_penduduks->file)): ?>
                              <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/vis_data_penduduks/' . $vis_data_penduduks->file; ?>">
                                <img src="<?= BASE_URL . 'uploads/vis_data_penduduks/' . $vis_data_penduduks->file; ?>" class="image-responsive" alt="image vis_data_penduduks" title="file vis_data_penduduks" width="40px">
                              </a>
                              <?php else: ?>
                              <label>
                                <a href="<?= BASE_URL . 'administrator/file/download/vis_data_penduduks/' . $vis_data_penduduks->file; ?>">
                                 <img src="<?= get_icon_file($vis_data_penduduks->file); ?>" class="image-responsive" alt="image vis_data_penduduks" title="file <?= $vis_data_penduduks->file; ?>" width="40px"> 
                               <?= $vis_data_penduduks->file ?>
                               </a>
                               </label>
                              <?php endif; ?>
                        </div>
                    </div>
                                      
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">No KK </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id_kk"><?= _ent($vis_data_penduduks->id_kk); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Created At </label>

                        <div class="col-sm-8">
                        <span class="detail_group-created_at"><?= _ent($vis_data_penduduks->created_at); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Updated At </label>

                        <div class="col-sm-8">
                        <span class="detail_group-updated_at"><?= _ent($vis_data_penduduks->updated_at); ?></span>
                        </div>
                    </div>
                                        
                    <br>
                    <br>


                     
                         
                    <div class="view-nav">
                        <?php is_allowed('vis_data_penduduks_update', function() use ($vis_data_penduduks){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit vis_data_penduduks (Ctrl+e)" href="<?= site_url('administrator/vis_data_penduduks/edit/'.$vis_data_penduduks->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Vis Data Penduduks']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/vis_data_penduduks/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Vis Data Penduduks']); ?></a>
                     </div>
                    
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
$(document).ready(function(){

    "use strict";
    
   
   });
</script>