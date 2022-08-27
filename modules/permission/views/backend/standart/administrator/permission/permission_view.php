<section class="content-header">
   <h1>
      Permission
      <small><?= cclang('detail', 'Permission'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li ><a href="<?= site_url('administrator/permission'); ?>">Permission</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
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
                     <h3 class="widget-user-username">Permission</h3>
                     <h5 class="widget-user-desc"><?= cclang('detail', 'Permission'); ?></h5>
                     <hr>
                  </div>

                  <div class="form-horizontal" name="form_permission" id="form_permission">

                     <div class="form-group ">
                        <label for="id" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($permission->id); ?>
                        </div>
                     </div>

                     <div class="form-horizontal" name="form_permission" id="form_permission">

                        <div class="form-group ">
                           <label for="title" class="col-sm-2 control-label">Name </label>

                           <div class="col-sm-8">
                              <?= _ent($permission->name); ?>
                           </div>
                        </div>

                        <div class="form-group ">
                           <label for="definition" class="col-sm-2 control-label">Definition </label>

                           <div class="col-sm-8">
                              <?= _ent($permission->definition); ?>
                           </div>
                        </div>

                        <br>
                        <br>

                        <div class="view-nav">
                           <?php is_allowed('permission_update', function () use ($permission) { ?>
                              <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit permission (Ctrl+e)" href="<?= site_url('administrator/permission/edit/' . $permission->id); ?>"><i class="fa fa-edit"></i> <?= cclang('update_button', 'Permission'); ?></a>
                           <?php }) ?>
                           <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/permission/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', 'Permission'); ?></a>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
</section>