<script type="text/javascript">
function domo(){
 
   $('*').bind('keydown', 'Ctrl+a', function() {
       window.location.href = BASE_URL + '/administrator/Vis_data_penduduks/add';
       return false;
   });

   $('*').bind('keydown', 'Ctrl+f', function() {
       $('#sbtn').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function() {
       $('#reset').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function() {

       $('#reset').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>
<section class="content-header">
   <h1>
      <?= cclang('vis_data_penduduks') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('vis_data_penduduks') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
      
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <div class="widget-user-header ">
                     <div class="row pull-right">
                        <?php is_allowed('vis_data_penduduks_add', function(){?>
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('vis_data_penduduks')]); ?>  (Ctrl+a)" href="<?=  site_url('administrator/vis_data_penduduks/add'); ?>"><i class="fa fa-plus-square-o" ></i> <?= cclang('add_new_button', [cclang('vis_data_penduduks')]); ?></a>
                        <?php }) ?>
                        <?php is_allowed('vis_data_penduduks_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> <?= cclang('vis_data_penduduks') ?> " href="<?= site_url('administrator/vis_data_penduduks/export?q='.$this->input->get('q').'&f='.$this->input->get('f')); ?>"><i class="fa fa-file-excel-o" ></i> <?= cclang('export'); ?> XLS</a>
                        <?php }) ?>
                                                <?php is_allowed('vis_data_penduduks_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> pdf <?= cclang('vis_data_penduduks') ?> " href="<?= site_url('administrator/vis_data_penduduks/export_pdf?q='.$this->input->get('q').'&f='.$this->input->get('f')); ?>"><i class="fa fa-file-pdf-o" ></i> <?= cclang('export'); ?> PDF</a>
                        <?php }) ?>
                                             </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username"><?= cclang('vis_data_penduduks') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('vis_data_penduduks')]); ?>  <i class="label bg-yellow"><?= $vis_data_penduduks_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_vis_data_penduduks" id="form_vis_data_penduduks" action="<?= base_url('administrator/vis_data_penduduks/index'); ?>">
                  


                     <!-- /.widget-user -->
                  <div class="row">
                     <div class="col-md-8">
                                                <div class="col-sm-2 padd-left-0 " >
                           <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email" >
                                                         <option value="delete">Delete</option>
                                                      </select>
                        </div>
                        <div class="col-sm-2 padd-left-0 ">
                           <button type="button" class="btn btn-flat" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>"><?= cclang('apply_button'); ?></button>
                        </div>
                                                <div class="col-sm-3 padd-left-0  " >
                           <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                        </div>
                        <div class="col-sm-3 padd-left-0 " >
                           <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                              <option value=""><?= cclang('all'); ?></option>
                               <option <?= $this->input->get('f') == 'nama' ? 'selected' :''; ?> value="nama">Nama</option>
                            <option <?= $this->input->get('f') == 'jk' ? 'selected' :''; ?> value="jk">Jenis Kelamin</option>
                            <option <?= $this->input->get('f') == 'nik' ? 'selected' :''; ?> value="nik">NIK</option>
                            <option <?= $this->input->get('f') == 'tempat_lahir' ? 'selected' :''; ?> value="tempat_lahir">Tempat Lahir</option>
                            <option <?= $this->input->get('f') == 'tanggal_lahir' ? 'selected' :''; ?> value="tanggal_lahir">Tanggal Lahir</option>
                            <option <?= $this->input->get('f') == 'agama' ? 'selected' :''; ?> value="agama">Agama</option>
                            <option <?= $this->input->get('f') == 'status_perkawinan' ? 'selected' :''; ?> value="status_perkawinan">Status Perkawinan</option>
                            <option <?= $this->input->get('f') == 'kewarganegaraan' ? 'selected' :''; ?> value="kewarganegaraan">Kewarganegaraan</option>
                            <option <?= $this->input->get('f') == 'pekerjaan' ? 'selected' :''; ?> value="pekerjaan">Pekerjaan</option>
                            <option <?= $this->input->get('f') == 'id_provinsi' ? 'selected' :''; ?> value="id_provinsi">Provinsi</option>
                            <option <?= $this->input->get('f') == 'id_kabupaten' ? 'selected' :''; ?> value="id_kabupaten">Kabupaten</option>
                            <option <?= $this->input->get('f') == 'id_kecamatan' ? 'selected' :''; ?> value="id_kecamatan">Kecamatan</option>
                            <option <?= $this->input->get('f') == 'id_desa' ? 'selected' :''; ?> value="id_desa">Desa</option>
                            <option <?= $this->input->get('f') == 'id_dusun' ? 'selected' :''; ?> value="id_dusun">Dusun</option>
                            <option <?= $this->input->get('f') == 'id_rw' ? 'selected' :''; ?> value="id_rw">RW</option>
                            <option <?= $this->input->get('f') == 'id_rt' ? 'selected' :''; ?> value="id_rt">RT</option>
                            <option <?= $this->input->get('f') == 'telp' ? 'selected' :''; ?> value="telp">Telp 1</option>
                            <option <?= $this->input->get('f') == 'telp2' ? 'selected' :''; ?> value="telp2">Telp 2</option>
                            <option <?= $this->input->get('f') == 'file' ? 'selected' :''; ?> value="file">File</option>
                            <option <?= $this->input->get('f') == 'id_kk' ? 'selected' :''; ?> value="id_kk">No KK</option>
                            <option <?= $this->input->get('f') == 'created_at' ? 'selected' :''; ?> value="created_at">Created At</option>
                            <option <?= $this->input->get('f') == 'updated_at' ? 'selected' :''; ?> value="updated_at">Updated At</option>
                           </select>
                        </div>
                        <div class="col-sm-1 padd-left-0 ">
                           <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                           Filter
                           </button>
                        </div>
                        <div class="col-sm-1 padd-left-0 ">
                           <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/vis_data_penduduks');?>" title="<?= cclang('reset_filter'); ?>">
                           <i class="fa fa-undo"></i>
                           </a>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate" >
                           <?= $pagination; ?>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive"> 

                  <br>
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr class="">
                                                     <th>
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                           </th>
                                                    <th data-field="nama"data-sort="1" data-primary-key="0"> <?= cclang('nama') ?></th>
                           <th data-field="jk"data-sort="1" data-primary-key="0"> <?= cclang('jk') ?></th>
                           <th data-field="nik"data-sort="1" data-primary-key="0"> <?= cclang('nik') ?></th>
                           <th data-field="tempat_lahir"data-sort="1" data-primary-key="0"> <?= cclang('tempat_lahir') ?></th>
                           <th data-field="tanggal_lahir"data-sort="1" data-primary-key="0"> <?= cclang('tanggal_lahir') ?></th>
                           <th data-field="agama"data-sort="1" data-primary-key="0"> <?= cclang('agama') ?></th>
                           <th data-field="status_perkawinan"data-sort="1" data-primary-key="0"> <?= cclang('status_perkawinan') ?></th>
                           <th data-field="kewarganegaraan"data-sort="1" data-primary-key="0"> <?= cclang('kewarganegaraan') ?></th>
                           <th data-field="pekerjaan"data-sort="1" data-primary-key="0"> <?= cclang('pekerjaan') ?></th>
                           <th data-field="id_provinsi"data-sort="1" data-primary-key="0"> <?= cclang('id_provinsi') ?></th>
                           <th data-field="id_kabupaten"data-sort="1" data-primary-key="0"> <?= cclang('id_kabupaten') ?></th>
                           <th data-field="id_kecamatan"data-sort="1" data-primary-key="0"> <?= cclang('id_kecamatan') ?></th>
                           <th data-field="id_desa"data-sort="1" data-primary-key="0"> <?= cclang('id_desa') ?></th>
                           <th data-field="id_dusun"data-sort="1" data-primary-key="0"> <?= cclang('id_dusun') ?></th>
                           <th data-field="id_rw"data-sort="1" data-primary-key="0"> <?= cclang('id_rw') ?></th>
                           <th data-field="id_rt"data-sort="1" data-primary-key="0"> <?= cclang('id_rt') ?></th>
                           <th data-field="telp"data-sort="1" data-primary-key="0"> <?= cclang('telp') ?></th>
                           <th data-field="telp2"data-sort="1" data-primary-key="0"> <?= cclang('telp2') ?></th>
                           <th data-field="file"data-sort="0" data-primary-key="0"> <?= cclang('file') ?></th>
                           <th data-field="id_kk"data-sort="1" data-primary-key="0"> <?= cclang('id_kk') ?></th>
                           <th data-field="created_at"data-sort="1" data-primary-key="0"> <?= cclang('created_at') ?></th>
                           <th data-field="updated_at"data-sort="1" data-primary-key="0"> <?= cclang('updated_at') ?></th>
                           <th>Action</th>                        </tr>
                     </thead>
                     <tbody id="tbody_vis_data_penduduks">
                     <?php foreach($vis_data_pendudukss as $vis_data_penduduks): ?>
                        <tr>
                                                       <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $vis_data_penduduks->id; ?>">
                           </td>
                                                       
                           <td><span class="list_group-nama"><?= _ent($vis_data_penduduks->nama); ?></span></td> 
                           <td><span class="list_group-jk"><?= _ent($vis_data_penduduks->jk); ?></span></td> 
                           <td><span class="list_group-nik"><?= _ent($vis_data_penduduks->nik); ?></span></td> 
                           <td><span class="list_group-tempat_lahir"><?= _ent($vis_data_penduduks->tempat_lahir); ?></span></td> 
                           <td><span class="list_group-tanggal_lahir"><?= _ent($vis_data_penduduks->tanggal_lahir); ?></span></td> 
                           <td><span class="list_group-agama"><?= _ent($vis_data_penduduks->agama); ?></span></td> 
                           <td><span class="list_group-status_perkawinan"><?= _ent($vis_data_penduduks->status_perkawinan); ?></span></td> 
                           <td><span class="list_group-kewarganegaraan"><?= _ent($vis_data_penduduks->kewarganegaraan); ?></span></td> 
                           <td><span class="list_group-pekerjaan"><?= _ent($vis_data_penduduks->pekerjaan); ?></span></td> 
                           <td><span class="list_group-id_provinsi"><?= _ent($vis_data_penduduks->id_provinsi); ?></span></td> 
                           <td><span class="list_group-id_kabupaten"><?= _ent($vis_data_penduduks->id_kabupaten); ?></span></td> 
                           <td><span class="list_group-id_kecamatan"><?= _ent($vis_data_penduduks->id_kecamatan); ?></span></td> 
                           <td><span class="list_group-id_desa"><?= _ent($vis_data_penduduks->id_desa); ?></span></td> 
                           <td><span class="list_group-id_dusun"><?= _ent($vis_data_penduduks->id_dusun); ?></span></td> 
                           <td><span class="list_group-id_rw"><?= _ent($vis_data_penduduks->id_rw); ?></span></td> 
                           <td><span class="list_group-id_rt"><?= _ent($vis_data_penduduks->id_rt); ?></span></td> 
                           <td><span class="list_group-telp"><?= _ent($vis_data_penduduks->telp); ?></span></td> 
                           <td><span class="list_group-telp2"><?= _ent($vis_data_penduduks->telp2); ?></span></td> 
                           <td>
                              <?php if (!empty($vis_data_penduduks->file)): ?>
                                <?php if (is_image($vis_data_penduduks->file)): ?>
                                <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/vis_data_penduduks/' . $vis_data_penduduks->file; ?>">
                                  <img src="<?= BASE_URL . 'uploads/vis_data_penduduks/' . $vis_data_penduduks->file; ?>" class="image-responsive" alt="image vis_data_penduduks" title="file vis_data_penduduks" width="40px">
                                </a>
                                <?php else: ?>
                                  <a href="<?= BASE_URL . 'uploads/vis_data_penduduks/' . $vis_data_penduduks->file; ?>" target="blank">
                                   <img src="<?= get_icon_file($vis_data_penduduks->file); ?>" class="image-responsive image-icon" alt="image vis_data_penduduks" title="file <?= $vis_data_penduduks->file; ?>" width="40px"> 
                                 </a>
                                <?php endif; ?>
                              <?php endif; ?>
                           </td>
                            
                           <td><span class="list_group-id_kk"><?= _ent($vis_data_penduduks->id_kk); ?></span></td> 
                           <td><span class="list_group-created_at"><?= _ent($vis_data_penduduks->created_at); ?></span></td> 
                           <td><span class="list_group-updated_at"><?= _ent($vis_data_penduduks->updated_at); ?></span></td> 
                           <td width="200">
                            
                                                              <?php is_allowed('vis_data_penduduks_view', function() use ($vis_data_penduduks){?>
                                                              <a href="<?= site_url('administrator/vis_data_penduduks/view/' . $vis_data_penduduks->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                              <?php }) ?>
                              <?php is_allowed('vis_data_penduduks_update', function() use ($vis_data_penduduks){?>
                              <a href="<?= site_url('administrator/vis_data_penduduks/edit/' . $vis_data_penduduks->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                              <?php }) ?>
                              <?php is_allowed('vis_data_penduduks_delete', function() use ($vis_data_penduduks){?>
                              <a href="javascript:void(0);" data-href="<?= site_url('administrator/vis_data_penduduks/delete/' . $vis_data_penduduks->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                               <?php }) ?>

                           </td>                        </tr>
                      <?php endforeach; ?>
                      <?php if ($vis_data_penduduks_counts == 0) :?>
                         <tr>
                           <td colspan="100">
                           Vis Data Penduduks data is not available
                           </td>
                         </tr>
                      <?php endif; ?>

                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
             
            </div>
            </form>            
         </div>
      </div>
   </div>
</section>


<script>
  $(document).ready(function(){

    "use strict";
   
    
      
    $('.remove-data').click(function(){

      var url = $(this).attr('data-href');

      swal({
          title: "<?= cclang('are_you_sure'); ?>",
          text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
          cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });

      return false;
    });


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_vis_data_penduduks').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/vis_data_penduduks/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Okay!",
            closeOnConfirm: true,
            closeOnCancel: true
          });

        return false;
      }

      return false;

    });/*end appliy click*/


    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });
    initSortable('vis_data_penduduks', $('table.dataTable'));
  }); /*end doc ready*/
</script>