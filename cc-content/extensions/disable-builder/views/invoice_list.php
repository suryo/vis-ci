


<script type="text/javascript">

function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Keys/add';
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
      Invoice<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Invoice</li>
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
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>
                     
                     <h3 class="widget-user-username">Invoice</h3>
                     <h5 class="widget-user-desc"<?= cclang('list_all', 'Invoice'); ?><i class="label bg-yellow">items</i></h5>
                  </div>

                  <form name="form_keys" id="form_keys" action="<?= base_url('administrator/keys/index'); ?>">
                  
                  <div class="table-responsive">
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr >
                           <th>
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                           </th>
                           <th>Customers</th>
                           <th>Totals</th>
                           <th>Status</th>
                           <th>Date Created</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_keys">
                    
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
                           <option value="delete"><?= cclang('delete'); ?></option>
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
                            <option <?= $this->input->get('f') == 'key' ? 'selected' :''; ?> value="key">Key</option>
                           <option <?= $this->input->get('f') == 'level' ? 'selected' :''; ?> value="level">Level</option>
                           <option <?= $this->input->get('f') == 'ignore_limits' ? 'selected' :''; ?> value="ignore_limits">Ignore Limits</option>
                           <option <?= $this->input->get('f') == 'is_private_key' ? 'selected' :''; ?> value="is_private_key">Is Private Key</option>
                           <option <?= $this->input->get('f') == 'ip_addresses' ? 'selected' :''; ?> value="ip_addresses">Ip Addresses</option>
                           <option <?= $this->input->get('f') == 'date_created' ? 'selected' :''; ?> value="date_created">Date Created</option>
                          </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="<?= cclang('apply_button'); ?>" title="<?= cclang('filter_search'); ?>">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/keys');?>" title="<?= cclang('reset_filter'); ?>">
                        <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>            
                  </div>
               </div>
            </div>
            
         </div>
         
      </div>
   </div>
</section>


<!-- Page script -->
<script type="text/javascript" src="<?= BASE_ASSET ?>jquery-clipboard"></script>
<script>
  $(document).ready(function() {
    $('.remove-data').on('click', function() {

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
            function(isConfirm) {
                if (isConfirm) {
                    document.location.href = url;
                }
            });

        return false;
    });


    $('#apply').on('click', function() {

        var bulk = $('#bulk');
        var serialize_bulk = $('#form_keys').serialize();

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
                function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = BASE_URL + '/administrator/keys/delete?' + serialize_bulk;
                    }
                });

            return false;

        } else if (bulk.val() == '') {
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

    }); /*end appliy click*/


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

    checkboxes.on('ifChanged', function(event) {
        if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

}); /*end doc ready*/
</script>