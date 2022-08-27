


<script type="text/javascript">

function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Shipping_address/add';
       return false;
   });

   $('*').bind('keydown', 'Ctrl+f', function assets() {
       $('#sbtn').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
       $('#reset').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function assets() {

       $('#reset').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>

<section class="content-header">
   <h1>
      <?= cclang('shipping_address') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('shipping_address') ?></li>
   </ol>
</section>

<section class="content">
   <div class="row" >
      
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               
               <div class="box box-widget widget-user-2">
                  
                  <div class="widget-user-header ">
                     <div class="row pull-right">
                        <?php is_allowed('shipping_address_add', function(){?>
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('shipping_address')]); ?>  (Ctrl+a)" href="<?=  site_url('administrator/shipping_address/add'); ?>"><i class="fa fa-plus-square-o" ></i> <?= cclang('add_new_button', [cclang('shipping_address')]); ?></a>
                        <?php }) ?>
                        <?php is_allowed('shipping_address_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> <?= cclang('shipping_address') ?> " href="<?= site_url('administrator/shipping_address/export?q='.$this->input->get('q').'&f='.$this->input->get('d')); ?>"><i class="fa fa-file-excel-o" ></i> <?= cclang('export'); ?> XLS</a>
                        <?php }) ?>
                        <?php is_allowed('shipping_address_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> pdf <?= cclang('shipping_address') ?> " href="<?= site_url('administrator/shipping_address/export_pdf'); ?>"><i class="fa fa-file-pdf-o" ></i> <?= cclang('export'); ?> PDF</a>
                        <?php }) ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>
                     
                     <h3 class="widget-user-username"><?= cclang('shipping_address') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('shipping_address')]); ?>  <i class="label bg-yellow"><?= $shipping_address_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_shipping_address" id="form_shipping_address" action="<?= base_url('administrator/shipping_address/index'); ?>">
                  

                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr >
                                                     <th>
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                           </th>
                                                    <th data-field="label"data-sort="1" data-primary-key="0"> <?= cclang('label') ?></th>
                           <th data-field="phone"data-sort="1" data-primary-key="0"> <?= cclang('phone') ?></th>
                           <th data-field="country_id"data-sort="1" data-primary-key="0"> <?= cclang('country_id') ?></th>
                           <th data-field="state_id"data-sort="1" data-primary-key="0"> <?= cclang('state_id') ?></th>
                           <th data-field="city_id"data-sort="1" data-primary-key="0"> <?= cclang('city_id') ?></th>
                           <th data-field="user_id"data-sort="1" data-primary-key="0"> <?= cclang('user_id') ?></th>
                           <th data-field="main"data-sort="1" data-primary-key="0"> <?= cclang('main') ?></th>
                           <th data-field="address_detail"data-sort="1" data-primary-key="0"> <?= cclang('address_detail') ?></th>
                           <th data-field="created_at"data-sort="1" data-primary-key="0"> <?= cclang('created_at') ?></th>
                           <th>Action</th>                        </tr>
                     </thead>
                     <tbody id="tbody_shipping_address">
                     <?php foreach($shipping_addresss as $shipping_address): ?>
                        <tr>
                                                       <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $shipping_address->id; ?>">
                           </td>
                                                       
                           <td><?= _ent($shipping_address->label); ?></td> 
                           <td><?= _ent($shipping_address->phone); ?></td> 
                           <td><?php if  ($shipping_address->country_id) {

                              echo anchor('administrator/countries/view/'.$shipping_address->country_id.'?popup=show', $shipping_address->countries_name, ['class' => 'popup-view']); }?> </td>
                             
                           <td><?php if  ($shipping_address->state_id) {

                              echo anchor('administrator/states/view/'.$shipping_address->state_id.'?popup=show', $shipping_address->states_name, ['class' => 'popup-view']); }?> </td>
                             
                           <td><?php if  ($shipping_address->city_id) {

                              echo anchor('administrator/cities/view/'.$shipping_address->city_id.'?popup=show', $shipping_address->cities_name, ['class' => 'popup-view']); }?> </td>
                             
                           <td><?= _ent($shipping_address->user_id); ?></td> 
                           <td><?= _ent($shipping_address->main); ?></td> 
                           <td><?= _ent($shipping_address->address_detail); ?></td> 
                           <td><?= _ent($shipping_address->created_at); ?></td> 
                           <td width="200">
                            
                                                              <?php is_allowed('shipping_address_view', function() use ($shipping_address){?>
                                 <a href="<?= site_url('administrator/shipping_address/single_pdf/' .$shipping_address->id); ?>" class="label-default"><i class="fa fa-file-pdf-o"></i> <?= cclang('PDF') ?>
                              <a href="<?= site_url('administrator/shipping_address/view/' . $shipping_address->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                              <?php }) ?>
                              <?php is_allowed('shipping_address_update', function() use ($shipping_address){?>
                              <a href="<?= site_url('administrator/shipping_address/edit/' . $shipping_address->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                              <?php }) ?>
                              <?php is_allowed('shipping_address_delete', function() use ($shipping_address){?>
                              <a href="javascript:void(0);" data-href="<?= site_url('administrator/shipping_address/delete/' . $shipping_address->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                               <?php }) ?>

                           </td>                        </tr>
                      <?php endforeach; ?>
                      <?php if ($shipping_address_counts == 0) :?>
                         <tr>
                           <td colspan="100">
                           Shipping Address data is not available
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
                     <div class="col-sm-2 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email" >
                           <option value="">Bulk</option>
                                                     <option value="delete">Delete</option>
                                                  </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  " >
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                           <option value=""><?= cclang('all'); ?></option>
                            <option <?= $this->input->get('f') == 'label' ? 'selected' :''; ?> value="label">Label</option>
                           <option <?= $this->input->get('f') == 'phone' ? 'selected' :''; ?> value="phone">Phone</option>
                           <option <?= $this->input->get('f') == 'country_id' ? 'selected' :''; ?> value="country_id">Country</option>
                           <option <?= $this->input->get('f') == 'state_id' ? 'selected' :''; ?> value="state_id">State</option>
                           <option <?= $this->input->get('f') == 'city_id' ? 'selected' :''; ?> value="city_id">City</option>
                           <option <?= $this->input->get('f') == 'user_id' ? 'selected' :''; ?> value="user_id">User</option>
                           <option <?= $this->input->get('f') == 'main' ? 'selected' :''; ?> value="main">Main</option>
                           <option <?= $this->input->get('f') == 'address_detail' ? 'selected' :''; ?> value="address_detail">Address Detail</option>
                           <option <?= $this->input->get('f') == 'created_at' ? 'selected' :''; ?> value="created_at">Created At</option>
                          </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/shipping_address');?>" title="<?= cclang('reset_filter'); ?>">
                        <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate" >
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div>
            </div>
            
         </div>
         
      </div>
   </div>
</section>


<!-- Page script -->
<script>
  $(document).ready(function(){
   
    $('.remove-data').on('click', function(){

      var url = $(this).attr('data-href');

      swal({
          title: "<?= cclang('are_you_sure'); ?>",
          text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
          cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });

      return false;
    });


    $('#apply').on('click', function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_shipping_address').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/shipping_address/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Okay!",
            closeOnConfirm: true,
            closeOnCancel: true
          });

        return false;
      }

      return false;

    });/*end appliy click*/


    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });
    initSortable('shipping_address', $('table.dataTable'));
  }); /*end doc ready*/
</script>