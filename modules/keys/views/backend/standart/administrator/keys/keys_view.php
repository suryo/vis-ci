<section class="content-header">
   <h1>
      API Keys <small><?= cclang('detail', 'API Keys'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li ><a href="<?= site_url('administrator/keys'); ?>">API Keys</a></li>
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
                     <h3 class="widget-user-username">API Keys</h3>
                     <h5 class="widget-user-desc"><?= cclang('edit', 'API Keys'); ?></h5>
                     <hr>
                  </div>
                  <div class="form-horizontal" name="form_keys" id="form_keys">
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($keys->id); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Key </label>

                        <div class="col-sm-8">
                           <?= _ent($keys->key); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Level </label>

                        <div class="col-sm-8">
                           <?= _ent($keys->level); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Ignore Limits </label>

                        <div class="col-sm-8">
                           <?= _ent($keys->ignore_limits) ? 'yes' : 'no'; ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Is Private Key </label>

                        <div class="col-sm-8">
                           <?= _ent($keys->is_private_key) ? 'yes' : 'no'; ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Ip Addresses </label>

                        <div class="col-sm-8">
                           <?= _ent($keys->ip_addresses); ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Date Created </label>

                        <div class="col-sm-8">
                           <?= _ent($keys->date_created); ?>
                        </div>
                     </div>

                     <br>
                     <br>

                     <div class="view-nav">
                        <?php is_allowed('keys_update', function () use ($keys) { ?>
                           <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit keys (Ctrl+e)" href="<?= site_url('administrator/keys/edit/' . $keys->id); ?>"><i class="fa fa-edit"></i> <?= cclang('update_button', 'API Keys'); ?></a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/keys/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', 'API Keys'); ?></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>