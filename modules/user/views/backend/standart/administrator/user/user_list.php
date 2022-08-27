<link rel="stylesheet" href="<?= BASE_ASSET ?>jquery-switch-button/jquery.switchButton.css">

<section class="content-header">
   <h1>
      <?= cclang('user'); ?>
      <small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('home'); ?></a></li>
      <li class="active"><?= cclang('user'); ?></li>
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
                        <?php is_allowed('user_add', function () { ?>
                           <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', cclang('user')); ?> (Ctrl+a)" href="<?= site_url('administrator/user/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', cclang('user')); ?></a>
                        <?php }) ?>
                        <?php is_allowed('user_export', function () { ?>
                           <a class="btn btn-flat btn-success" title="<?= cclang('export', 'Excel ' . cclang('user')); ?>" href="<?= site_url('administrator/user/export'); ?>"><i class="fa fa-file-excel-o"></i> <?= cclang('export', 'Excel ' . cclang('user')); ?></a>
                        <?php }) ?>
                        <?php is_allowed('user_export', function () { ?>
                           <a class="btn btn-flat btn-success" title="<?= cclang('export', 'PDF User'); ?>" href="<?= site_url('administrator/user/export_pdf'); ?>"><i class="fa fa-file-pdf-o"></i> <?= cclang('export', 'PDF'); ?></a>
                        <?php }) ?>

                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>

                     <h3 class="widget-user-username"><?= cclang('user'); ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', cclang('user')); ?> <i class="label bg-yellow"><?= $user_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_user" id="form_user" action="<?= base_url('administrator/user/index'); ?>">

                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr >
                                 <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th>
                                 <th data-field="full_name" data-sort="1"><?= cclang('user') ?></th>
                                 <th data-field="username" data-sort="1"><?= cclang('username') ?></th>
                                 <th data-field="status" data-sort="1"><?= cclang('status') ?></th>
                                 <th><?= cclang('action') ?></th>
                              </tr>
                           </thead>
                           <tbody id="tbody_user">
                              <?php foreach ($users as $user) : ?>
                                 <tr>
                                    <td width="5">
                                       <input type="checkbox" class="flat-red check" name="id[]" value="<?= $user->id; ?>">
                                    </td>
                                    <td>

                                       <div class="chip">
                                          <?php if (is_file(FCPATH . 'uploads/user/' . $user->avatar)) : ?>
                                             <?php $img_url = BASE_URL . 'uploads/user/' . $user->avatar; ?>
                                          <?php else : ?>
                                             <?php $img_url = BASE_URL . 'uploads/user/default.png'; ?>
                                          <?php endif; ?>
                                          <a class="fancybox" rel="group" href="<?= $img_url; ?>">
                                             <img src="<?= $img_url; ?>" alt="Person" width="50" height="50">
                                          </a>
                                          <?= _ent($user->full_name); ?>
                                       </div>
                                    </td>
                                    <td><?= _ent($user->username); ?></td>
                                    <td>

                                       <input type="checkbox" name="status" data-user-id="<?= $user->id; ?>" class="user-switch-status" <?= $user->banned ?: 'checked'; ?>>
                                    </td>
                                    <td width="200">
                                       <?php is_allowed('user_view', function () use ($user) { ?>
                                          <a href="<?= site_url('administrator/user/view/' . $user->id); ?>" class="label-default"><i class="fa  fa-newspaper-o "></i> <?= cclang('view_button'); ?></a>
                                       <?php }) ?>
                                       <?php is_allowed('user_update', function () use ($user) { ?>
                                          <a href="<?= site_url('administrator/user/edit/' . $user->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                                       <?php }) ?>
                                       <?php is_allowed('user_delete', function () use ($user) { ?>
                                          <a href="javascript:void(0);" data-href="<?= site_url('administrator/user/delete/' . $user->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                                       <?php }) ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                              <?php if ($user_counts == 0) : ?>
                                 <tr>
                                    <td colspan="100">
                                       <?= cclang('data_is_not_avaiable', cclang('user')); ?>
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
                           <option value=""><?= cclang('bulk') ?></option>
                           <option value="delete"><?= cclang('delete'); ?></option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" value="Apply" title="<?= cclang('apply_bulk_action', 'User'); ?>"><?= cclang('apply_button', 'User'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  ">
                        <input type="text" class="form-control" name="q" id="filter" placeholder="Filter" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 ">
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field">
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'id' ? 'selected' : ''; ?> value="id">ID</option>
                           <option <?= $this->input->get('f') == 'username' ? 'selected' : ''; ?> value="username">Username</option>
                           <option <?= $this->input->get('f') == 'full_name' ? 'selected' : ''; ?> value="full_name">Full Name</option>
                           <option <?= $this->input->get('f') == 'email' ? 'selected' : ''; ?> value="email">Email</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                           <?= cclang('filter') ?>
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/user'); ?>" title="<?= cclang('reset_filter'); ?>">
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

<script src="<?= BASE_ASSET ?>js/page/user/user-list.js"></script>