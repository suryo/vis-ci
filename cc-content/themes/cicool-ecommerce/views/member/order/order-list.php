<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function assets() {
         window.location.href = BASE_URL + '/administrator/Transaction/add';
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
      Transaction <small><?= cclang('list', ['Transaction']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('member/order'); ?>">Transaction</a></li>
      <li class="active"><?= cclang('list'); ?></li>
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

                     <h3 class="widget-user-username"><?= cclang('transaction') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('transaction')]); ?> <i class="label bg-yellow"><?= $transaction_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_transaction" id="form_transaction" action="<?= base_url('member/order/index'); ?>">
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr>
                                 <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th>
                                 <th data-field="invoice_id" data-sort="1" data-primary-key="0"> <?= cclang('invoice_id') ?></th>
                                 <th data-field="status" data-sort="1" data-primary-key="0"> <?= cclang('status') ?></th>
                                 <th data-field="subtotal" data-sort="1" data-primary-key="0"> <?= cclang('subtotal') ?></th>
                                 <th data-field="fee" data-sort="1" data-primary-key="0"> <?= cclang('fee') ?></th>
                                 <th data-field="total" data-sort="1" data-primary-key="0"> <?= cclang('total') ?></th>
                                 <th data-field="datetime" data-sort="1" data-primary-key="0"> <?= cclang('datetime') ?></th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_transaction">
                              <?php foreach ($transactions as $transaction) : ?>
                                 <tr>
                                    <td width="5">
                                       <input type="checkbox" class="flat-red check" name="id[]" value="<?= $transaction->id; ?>">
                                    </td>

                                    <td><?= anchor('invoice/show/' . $transaction->invoice_id, $transaction->invoice_id); ?></td>
                                    <td><?php if ($transaction->status) {

                                             echo anchor('member/order_status/view/' . $transaction->status . '?popup=show', $transaction->transaction_status_status, ['class' => 'popup-view']);
                                          } ?> </td>

                                    <td><?= curency($transaction->subtotal); ?></td>
                                    <td><?= curency($transaction->fee); ?></td>
                                    <td><?= curency($transaction->total); ?></td>
                                    <td><?= _ent($transaction->datetime); ?></td>
                                    <td width="100">

                                       <?php is_allowed('transaction_view', function () use ($transaction) { ?>
                                          <a href="<?= site_url('member/order/view/' . $transaction->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                                          <?php }) ?>

                                          <?php is_allowed('transaction_view', function () use ($transaction) { ?>
                                             <a href="<?= site_url('member/order/confirm/' . $transaction->id); ?>" class="label-default"><i class="fa fa-info"></i> <?= cclang('confirm_order'); ?>
                                             <?php }) ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                              <?php if ($transaction_counts == 0) : ?>
                                 <tr>
                                    <td colspan="100">
                                       Transaction data is not available
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
                           <option <?= $this->input->get('f') == 'invoice_id' ? 'selected' : ''; ?> value="invoice_id">Invoice Id</option>
                           <option <?= $this->input->get('f') == 'status' ? 'selected' : ''; ?> value="status">Status</option>
                           <option <?= $this->input->get('f') == 'user_id' ? 'selected' : ''; ?> value="user_id">User Id</option>
                           <option <?= $this->input->get('f') == 'subtotal' ? 'selected' : ''; ?> value="subtotal">Subtotal</option>
                           <option <?= $this->input->get('f') == 'fee' ? 'selected' : ''; ?> value="fee">Fee</option>
                           <option <?= $this->input->get('f') == 'total' ? 'selected' : ''; ?> value="total">Total</option>
                           <option <?= $this->input->get('f') == 'datetime' ? 'selected' : ''; ?> value="datetime">Datetime</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                           Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('member/order'); ?>" title="<?= cclang('reset_filter'); ?>">
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
   </div>


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
            var serialize_bulk = $('#form_transaction').serialize();

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
                        document.location.href = BASE_URL + '/member/order/delete?' + serialize_bulk;
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
         initSortable('transaction', $('table.dataTable'));
      }); /*end doc ready*/
   </script>