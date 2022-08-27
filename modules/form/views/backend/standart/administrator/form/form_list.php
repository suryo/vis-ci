<section class="content-header">
   <h1>
      <?= cclang('form'); ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('home'); ?></a></li>
      <li class="active"><?= cclang('form'); ?></li>
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
                        <?php is_allowed('form_add', function () { ?>
                           <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', 'form'); ?> (Ctrl+a)" href="<?= site_url('administrator/form/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', cclang('form')); ?></a>
                        <?php }) ?>
                        <?php is_allowed('form_export', function () { ?>
                           <a class="btn btn-flat btn-success" title="<?= cclang('export', cclang('form')); ?>" href="<?= site_url('administrator/form/export'); ?>"><i class="fa fa-file-excel-o"></i> <?= cclang('export', cclang('form')); ?></a>
                        <?php }) ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>

                     <h3 class="widget-user-username"><?= cclang('form') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', cclang('form')); ?> <i class="label bg-yellow"><?= $form_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_form" id="form_form" action="<?= base_url('administrator/form/index'); ?>">

                     <table class="table table-bordered table-striped dataTable">
                        <thead>
                           <tr >
                              <th>
                                 <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                              </th>
                              <th data-field="subject" data-sort="1"><?= cclang('subject'); ?></th>
                              <th><?= cclang('short_code_page'); ?> <span class="badge tip cursor" title="<?= cclang('short_code_can_be_embed_in_page'); ?>"><i class="fa fa-info "></i></span></th>
                              <th><?= cclang('short_code_php'); ?> <span class="badge tip cursor" title="<?= cclang('short_code_can_be_embed_in_code'); ?>"><i class="fa fa-info "></i></span></th>
                              <th><?= cclang('action'); ?></th>
                           </tr>
                        </thead>
                        <tbody id="tbody_form">
                           <?php foreach ($forms as $form) : ?>
                              <tr>
                                 <td width="5">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $form->id; ?>">
                                 </td>
                                 <td><?= _ent($form->subject); ?></td>
                                 <td><code>{form_builder(<?= $form->id; ?>)}</code></td>
                                 <td><code> <?= _ent('<?= form_builder(' . $form->id . ') ?>'); ?></code></td>
                                 <td width="280">
                                    <?php is_allowed('form_manage', function () use ($form) { ?>
                                       <a href="<?= site_url('administrator/manage-form/form_' . str_replace('-', '_', url_title(strtolower($form->subject)))); ?>" class="label-default"><i class="fa fa-bars"></i> <?= cclang('manage_button'); ?></a>
                                    <?php }) ?>
                                    <?php is_allowed('form_view', function () use ($form) { ?>
                                       <a href="<?= site_url('administrator/form/view/' . $form->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                                       <?php }) ?>
                                       <?php is_allowed('form_update', function () use ($form) { ?>
                                          <a href="<?= site_url('administrator/form/edit/' . $form->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                                       <?php }) ?>
                                       <?php is_allowed('form_delete', function () use ($form) { ?>
                                          <a href="javascript:void(0);" data-href="<?= site_url('administrator/form/delete/' . $form->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                                       <?php }) ?>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                           <?php if ($form_counts == 0) : ?>
                              <tr>
                                 <td colspan="100">
                                    <?= cclang('data_is_not_avaiable'); ?>
                                 </td>
                              </tr>
                           <?php endif; ?>
                        </tbody>
                     </table>
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
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="apply bulk actions"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  ">
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 ">
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field">
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'title' ? 'selected' : ''; ?> value="title">Title</option>
                           <option <?= $this->input->get('f') == 'subject' ? 'selected' : ''; ?> value="subject">Subject</option>
                           <option <?= $this->input->get('f') == 'table_name' ? 'selected' : ''; ?> value="table_name">Table Name</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                           <?= cclang('filter_button'); ?>
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/form'); ?>" title="<?= cclang('reset_filter'); ?>">
                           <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>
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

<script src="<?= BASE_ASSET ?>js/page/form/form-list.js"></script>