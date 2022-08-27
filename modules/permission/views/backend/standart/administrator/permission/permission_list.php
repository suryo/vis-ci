<section class="content-header">
   <h1>
      Permission
      <small><?= cclang('list_all', 'Permission'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Permission</li>
   </ol>
</section>

<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <div class="box box-widget widget-user-2">

                  <div class="widget-user-header ">
                     <div class="row pull-right">
                        <?php is_allowed('permission_add', function () { ?>
                           <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="add new permission (Ctrl+a)" href="<?= site_url('administrator/permission/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', 'Permission'); ?></a>
                        <?php }) ?>
                        <?php is_allowed('permission_export', function () { ?>
                           <a class="btn btn-flat btn-success" title="export permission" href="<?= site_url('administrator/permission/export'); ?>"><i class="fa fa-file-excel-o"></i> <?= cclang('export_button', 'Excel'); ?></a>
                        <?php }) ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>

                     <h3 class="widget-user-username">Permission</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', 'Permission'); ?> <i class="label bg-yellow"><?= $permission_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_permission" id="form_permission" action="<?= base_url('administrator/permission/index'); ?>">

                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr >
                                 <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th>
                                 <th data-field="id" data-sort="1" data-primary-key="1"><?= cclang('id') ?></th>
                                 <th data-field="name" data-sort="1"><?= cclang('name') ?></th>
                                 <th data-field="definition" data-sort="1"><?= cclang('definition') ?></th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_permission">
                              <?php foreach ($permissions as $permission) : ?>
                                 <tr>
                                    <td width="5">
                                       <input type="checkbox" class="flat-red check" name="id[]" value="<?= $permission->id; ?>">
                                    </td>
                                    <td><?= _ent($permission->id); ?></td>
                                    <td><?= _ent($permission->name); ?></td>
                                    <td><?= _ent($permission->definition); ?></td>
                                    <td width="200">
                                       <?php is_allowed('permission_view', function () use ($permission) { ?>
                                          <a href="<?= site_url('administrator/permission/view/' . $permission->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                                          <?php }) ?>
                                          <?php is_allowed('permission_update', function () use ($permission) { ?>
                                             <a href="<?= site_url('administrator/permission/edit/' . $permission->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                                          <?php }) ?>
                                          <?php is_allowed('permission_delete', function () use ($permission) { ?>
                                             <a href="javascript:void(0);" data-href="<?= site_url('administrator/permission/delete/' . $permission->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                                          <?php }) ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                              <?php if ($permission_counts == 0) : ?>
                                 <tr>
                                    <td colspan="100">
                                       <?= cclang('data_is_not_avaiable', 'Permission'); ?>
                                    </td>
                                 </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-8">
                     <div class="col-sm-2 padd-left-0 ">
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email">
                           <option value="">Bulk</option>
                           <option value="delete"><?= cclang('delete'); ?></option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="apply bulk actions"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  ">
                        <input type="text" class="form-control" name="q" id="filter" placeholder="Filter" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 ">
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field">
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'id' ? 'selected' : ''; ?> value="id">ID</option>
                           <option <?= $this->input->get('f') == 'name' ? 'selected' : ''; ?> value="name">Name</option>
                           <option <?= $this->input->get('f') == 'definition' ? 'selected' : ''; ?> value="definition">Definition</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="filter search">
                           <?= cclang('filter_button'); ?>
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/permission'); ?>" title="reset filters">
                           <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  <?= form_close(); ?>
                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</section>

<script src="<?= BASE_ASSET ?>js/page/permission/permission-list.js"></script>