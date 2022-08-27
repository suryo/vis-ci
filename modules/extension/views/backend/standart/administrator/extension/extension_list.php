<section class="content-header">
   <h1>
      Extension<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Extension</li>
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
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', 'Extension'); ?> (Ctrl+a)" href="<?= site_url('administrator/extension/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', 'Extension'); ?></a>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>

                     <h3 class="widget-user-username">Extension</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['Extension']); ?> <i class="label bg-yellow"><?= count($extensions); ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_extension" id="form_extension" action="<?= base_url('administrator/extension/index'); ?>">


                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr >
                                 <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th>
                                 <th>Name</th>
                                 <th>Description</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_extension">
                              <?php foreach ($extensions as $extension) :  ?>

                                 <tr>
                                    <td width="5">
                                       <input type="checkbox" class="flat-red check" name="id[]" value="<?= $extension->item->dirname; ?>">
                                    </td>

                                    <td>
                                       <?= _ent($extension->item->name); ?><br>
                                       <span class="text-muted extension-creator">by : <?= _ent(isset($extension->item->author) ? $extension->item->author : '-'); ?></span>

                                    </td>
                                    <td><?= ($extension->item->description); ?></td>
                                    <td width="200">

                                       <?php debug($extension);
                                       if ($extension->actived()) : ?>

                                          <?php is_allowed('extension_activate', function () use ($extension) { ?>
                                             <a href="<?= site_url('administrator/extension/deactivation/?ex=' . base64_encode($extension->item->path)); ?>" class="label-default  "><i class="fa fa-minus-square  "></i> <?= cclang('btn_deactivation'); ?></a>
                                          <?php }) ?>
                                       <?php else : ?>
                                          <?php is_allowed('extension_deactivate', function () use ($extension) { ?>
                                             <a href="<?= site_url('administrator/extension/activation/?ex=' . base64_encode($extension->item->path)); ?>" class="label-default"><i class="fa  fa-plus-square-o "></i> <?= cclang('btn_activation'); ?></a>
                                          <?php }) ?>
                                       <?php endif ?>

                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="10"><?php $extension->getInformationFoot() ?></td>
                                 </tr>
                              <?php endforeach; ?>
                              <?php if (count($extensions) == 0) : ?>
                                 <tr>
                                    <td colspan="100">
                                       Extension data is not available
                                    </td>
                                 </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
               </div>
               <hr>
            </div>
         </div>
      </div>
   </div>
</section>

<script src="<?= BASE_ASSET ?>js/page/extension/extension-list.js"></script>