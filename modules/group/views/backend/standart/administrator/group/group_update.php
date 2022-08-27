<?php $this->load->view('core_template/fine_upload'); ?>
<section class="content-header">
   <h1>
      Group
      <small><?= cclang('update', 'Group'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li ><a href="<?= site_url('administrator/group'); ?>">Group</a></li>
      <li class="active"><?= cclang('update', 'Group'); ?></li>
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

                     <h3 class="widget-user-username">Group</h3>
                     <h5 class="widget-user-desc"><?= cclang('update', 'Group'); ?></h5>
                     <hr>
                  </div>
                  <?= form_open(base_url('administrator/group/edit_save/' . $this->uri->segment(4)), [
                     'name'    => 'form_group',
                     'class'   => 'form-horizontal',
                     'id'      => 'form_group',
                     'enctype' => 'multipart/form-data',
                     'method'  => 'POST'
                  ]); ?>

                  <div class="form-group ">
                     <label for="name" class="col-sm-2 control-label">Name <i class="required">*</i></label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?= set_value('name', $group->name); ?>">
                        <small class="info help-block">The name of group.</small>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="definition" class="col-sm-2 control-label">Definition</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="definition" id="definition" placeholder="Definition" value="<?= set_value('definition', $group->definition); ?>">
                        <small class="info help-block">The definition of group.</small>
                     </div>
                  </div>
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



<script src="<?= BASE_ASSET ?>js/page/group/group-update.js"></script>