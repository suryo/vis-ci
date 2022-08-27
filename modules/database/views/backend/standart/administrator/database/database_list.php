<section class="content-header">
   <h1>
      <?= cclang('database') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('database') ?></li>
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
                        <?php is_allowed('database_add', function () { ?>
                           <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('database')]); ?>  (Ctrl+a)" href="<?= site_url('administrator/database/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', [cclang('database')]); ?></a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> <?= cclang('database') ?> " href="<?= site_url('administrator/database/backup/') ?>"><i class="fa fa-database"></i> <?= cclang('backup'); ?> ZIP</a>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>

                     <h3 class="widget-user-username"><?= cclang('database') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('table')]); ?> <i class="label bg-yellow"><?= $database_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_database" id="form_database" action="<?= base_url('administrator/database/index'); ?>">


                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr>
                                 <th data-field=" table_name" data-sort="1" data-primary-key="0"> <?= cclang('table_name') ?></th>
                                 <th width="300px">Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_database">
                              <?php foreach ($databases as $table_name) : ?>
                                 <tr>
                                    <td>
                                       <div class="tree-table" data-name="<?= ($table_name) ?>" data-name-crypt="<?= ccencrypt($table_name) ?>">

                                       </div>
                                    </td>
                                    <td width="200">
                                       <a href="<?= site_url('administrator/database/view/' . ccencrypt($table_name)); ?>" class="label-default"><i class="fa fa-bars "></i> <?= cclang('structure'); ?></a>
                                       <a href="javascript:void(0);" data-href="<?= site_url('administrator/database/drop_table/' . ccencrypt($table_name)); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('drop_table'); ?></a>
                                       <a href="javascript:void(0);" data-href="<?= site_url('administrator/database/truncate/' . ccencrypt($table_name)); ?>" class="label-default remove-data"><i class="fa fa-refresh"></i> <?= cclang('empty'); ?></a>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
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
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  ">
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>

                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                           Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/database'); ?>" title="<?= cclang('reset_filter'); ?>">
                           <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>
                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<link rel="stylesheet" href="<?= BASE_ASSET ?>treejs/tree.css">
<script src="<?= BASE_ASSET ?>treejs/tree.js"></script>
<script src="<?= BASE_ASSET ?>js/page/database/database-list.js"></script>