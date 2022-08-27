<section class="content-header">
   <h1>
      Rest<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('home'); ?></a></li>
      <li class="active">Rest</li>
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
                        <?php is_allowed('rest_add', function () { ?>
                           <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', ['Rest']); ?> (Ctrl+a)" href="<?= site_url('administrator/rest/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', ['Rest']); ?></a>
                        <?php }) ?>
                        <?php is_allowed('rest_export', function () { ?>
                           <a class="btn btn-flat btn-success" title=" <?= cclang('export_button', ['Rest']); ?>" href="<?= site_url('administrator/rest/export'); ?>"><i class="fa fa-file-excel-o"></i> <?= cclang('export_button', ['Rest']); ?></a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-success btn_rest_tool" id="btn_add_new" title="<?= cclang('tool', ['Rest']); ?>" href="<?= site_url('administrator/rest/tool'); ?>"><i class="fa fa-chrome"></i> <?= cclang('tool', ['Rest']); ?></a>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>

                     <h3 class="widget-user-username">Rest</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['Rest']); ?> <i class="label bg-yellow"><?= $rest_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_rest" id="form_rest" action="<?= base_url('administrator/rest/index'); ?>">
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr>
                                 <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th>
                                 <th data-field="subject" data-sort="1"><?= cclang('subject'); ?></th>
                                 <th data-field="table_name" data-sort="1"><?= cclang('table_name'); ?></th>
                                 <th><?= cclang('action'); ?></th>
                              </tr>
                           </thead>
                           <tbody id="tbody_rest">
                              <?php foreach ($rests as $rest) : ?>
                                 <tr>
                                    <td width="5">
                                       <input type="checkbox" class="flat-red check" name="id[]" value="<?= $rest->id; ?>">
                                    </td>
                                    <td><?= _ent($rest->subject); ?></td>
                                    <td><?= _ent($rest->table_name); ?></td>
                                    <td width="200">
                                       <?php is_allowed('rest_view', function () use ($rest) { ?>
                                          <a href="<?= site_url('administrator/rest/view/' . $rest->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                                          <?php }) ?>
                                          <?php is_allowed('rest_update', function () use ($rest) { ?>
                                             <a href="<?= site_url('administrator/rest/edit/' . $rest->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                                          <?php }) ?>
                                          <?php is_allowed('rest_delete', function () use ($rest) { ?>
                                             <a href="javascript:void(0);" data-href="<?= site_url('administrator/rest/delete/' . $rest->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                                          <?php }) ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                              <?php if ($rest_counts == 0) : ?>
                                 <tr>
                                    <td colspan="100">
                                       <?= cclang('data_is_not_avaiable', ['Rest']); ?>
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
                           <option value=""><?= cclang('bulk'); ?></option>
                           <option value="delete"><?= cclang('delete'); ?></option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  ">
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 ">
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field">
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'subject' ? 'selected' : ''; ?> value="subject">Subject</option>
                           <option <?= $this->input->get('f') == 'table_name' ? 'selected' : ''; ?> value="table_name">Table Name</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="<?= cclang('apply_button'); ?>" title="<?= cclang('filter_search'); ?>">
                           Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/rest'); ?>" title="<?= cclang('reset_filter'); ?>">
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

<script src="<?= BASE_ASSET ?>js/page/rest/rest-list.js"></script>