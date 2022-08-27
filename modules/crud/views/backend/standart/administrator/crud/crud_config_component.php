<?php
if (!isset($display)) {
   $display = false;
}
?>

<div <?php if ($display == false) : ?> <?php endif ?> class="container-groups display-none">
   <div class="form-group ">
      <div class="col-sm-12">
         <select class="form-control strict-group <?= @$class ?>" name="group[]" id="group" multiple data-placeholder="Select groups">
            <?php foreach (db_get_all_data('aauth_groups') as $row) : ?>
               <option <?= array_search($row->id, []) !== false ? 'selected="selected"' : ''; ?> value="<?= $row->id; ?>"><?= ucwords($row->name); ?></option>
            <?php endforeach; ?>
         </select>
         <small>Only selected group can see this field</small>
      </div>
   </div>
</div>

<div class="modal modal-add-action" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Action</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <?= form_open('', [
               'name'    => 'form_action',
               'class'   => '',
               'id'      => 'form_action',
               'method'  => 'POST'
            ]); ?>
            <div class="row">

               <div class="col-sm-8">

                  <input name="crud_id" type="hidden" value="<?= $this->uri->segment(4) ?>">

                  <label>
                     <div class="layout-icon-wrapper">
                        <div class="layout-icon">
                           <i class="fa fa-file-pdf-o"></i>
                        </div>
                        <div class="layout-info">Report </div>
                        <input type="radio" name="action" value="report">
                     </div>
                  </label>


                  <label>
                     <div class="layout-icon-wrapper">
                        <div class="layout-icon">
                           <i class="fa fa-send-o "></i>
                        </div>
                        <div class="layout-info">Button </div>
                        <input type="radio" name="action" value="button">
                     </div>
                  </label>

               </div>
               <div class="row">
                  <div class="col-md-12">
                     <hr>
                  </div>
               </div>

               <div class="action-form-wrapper">

               </div>

               <?= form_close()  ?>

            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-save-action btn-primary">Save changes</button>
         </div>
      </div>
   </div>
</div>


<div class="modal  " tabindex="-1" role="dialog" id="modalIcon">
   <div class="modal-dialog full-width" role="document">
      <div class="modal-content">

         <div class="modal-body">
            <?php $this->load->view('menu/backend/standart/administrator/menu/partial_icon', ['cols' => 'col-md-3', 'max_height' => '350px']); ?>
         </div>
         <div class="modal-footer">
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script src="<?= BASE_ASSET ?>js/page/crud/crud-config-component.js"></script>