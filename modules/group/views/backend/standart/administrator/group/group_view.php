<section class="content-header">
   <h1>
      Group
      <small>Detail Group</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li ><a href="<?= site_url('administrator/group'); ?>">Group</a></li>
      <li class="active">Detail</li>
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
                     <h3 class="widget-user-username">Group</h3>
                     <h5 class="widget-user-desc">Detail Group</h5>
                     <hr>
                  </div>

                  <div class="form-horizontal" name="form_group" id="form_group">
                     <div class="form-group ">
                        <label for="id" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($group->id); ?>
                        </div>
                     </div>

                     <div class="form-horizontal" name="form_group" id="form_group">

                        <div class="form-group ">
                           <label for="title" class="col-sm-2 control-label">Name </label>

                           <div class="col-sm-8">
                              <?= _ent($group->name); ?>
                           </div>
                        </div>

                        <div class="form-group ">
                           <label for="definition" class="col-sm-2 control-label">Definition </label>

                           <div class="col-sm-8">
                              <?= _ent($group->definition); ?>
                           </div>
                        </div>

                        <br>
                        <br>

                        <div class="view-nav">
                           <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit group (Ctrl+e)" href="<?= site_url('administrator/group/edit/' . $group->id); ?>"><i class="fa fa-edit"></i> <?= cclang('update_button', 'Group'); ?></a>
                           <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/group/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button'); ?></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
</section>