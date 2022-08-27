<script type="text/javascript">
  function domo() {

    $('*').bind('keydown', 'Ctrl+s', function assets() {
      $('#btn_save').trigger('click');
      return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_cancel').trigger('click');
      return false;
    });

    $('*').bind('keydown', 'Ctrl+d', function assets() {
      $('.btn_save_back').trigger('click');
      return false;
    });
  }

  jQuery(document).ready(domo);
</script>

<section class="content-header">
  <h1>
    Transaction <small>Edit Transaction</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?= site_url('administrator/transaction'); ?>">Transaction</a></li>
    <li class="active">Edit</li>
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
                <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="User Avatar">
              </div>

              <h3 class="widget-user-username">Transaction</h3>
              <h5 class="widget-user-desc">Edit Transaction</h5>
              <hr>
            </div>
            <?= form_open(base_url('administrator/transaction/edit_save/' . $this->uri->segment(4)), [
              'name'    => 'form_transaction',
              'class'   => 'form-horizontal form-step',
              'id'      => 'form_transaction',
              'method'  => 'POST'
            ]); ?>

            <div class="form-group ">
              <label for="invoice_id" class="col-sm-2 control-label">Invoice Id
                <i class="required">*</i>
              </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Invoice Id" value="<?= set_value('invoice_id', $transaction->invoice_id); ?>">
                <small class="info help-block">
                  <b>Input Invoice Id</b> Max Length : 100.</small>
              </div>
            </div>

            <div class="form-group ">
              <label for="status" class="col-sm-2 control-label">Status
                <i class="required">*</i>
              </label>
              <div class="col-sm-8">
                <select class="form-control chosen chosen-select-deselect" name="status" id="status" data-placeholder="Select Status">
                  <option value=""></option>
                  <?php foreach (db_get_all_data('transaction_status') as $row) : ?>
                    <option <?= $row->id ==  $transaction->status ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->status; ?></option>
                  <?php endforeach; ?>
                </select>
                <small class="info help-block">
                  <b>Input Status</b> Max Length : 50.</small>
              </div>
            </div>

            <div class="form-group ">
              <label for="subtotal" class="col-sm-2 control-label">Subtotal
                <i class="required">*</i>
              </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="subtotal" id="subtotal" placeholder="Subtotal" value="<?= set_value('subtotal', $transaction->subtotal); ?>">
                <small class="info help-block">
                </small>
              </div>
            </div>

            <div class="form-group ">
              <label for="fee" class="col-sm-2 control-label">Fee
                <i class="required">*</i>
              </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="fee" id="fee" placeholder="Fee" value="<?= set_value('fee', $transaction->fee); ?>">
                <small class="info help-block">
                </small>
              </div>
            </div>

            <div class="form-group ">
              <label for="total" class="col-sm-2 control-label">Total
                <i class="required">*</i>
              </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="total" id="total" placeholder="Total" value="<?= set_value('total', $transaction->total); ?>">
                <small class="info help-block">
                  <b>Input Total</b> Max Length : 10.</small>
              </div>
            </div>

            <div class="message"></div>
            <div class="row-fluid col-md-7 container-button-bottom">
              <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
              </button>
              <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                <i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?>
              </a>
              <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
              </a>
              <span class="loading loading-hide">
                <img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg">
                <i><?= cclang('loading_saving_data'); ?></i>
              </span>
            </div>
            <?= form_close(); ?>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<script>
  $(document).ready(function() {

    "use strict";

    $('#btn_cancel').on('click', function() {
      swal({
          title: "Are you sure?",
          text: "the data that you have created will be in the exhaust!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            window.location.href = BASE_URL + 'administrator/transaction';
          }
        });

      return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function() {
      $('.message').fadeOut();

      var form_transaction = $('#form_transaction');
      var data_post = form_transaction.serializeArray();
      var save_type = $(this).attr('data-stype');
      data_post.push({
        name: 'save_type',
        value: save_type
      });

      $('.loading').show();

      $.ajax({
          url: form_transaction.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          $('form').find('.form-group').removeClass('has-error');
          $('form').find('.error-input').remove();
          $('.steps li').removeClass('error');
          if (res.success) {
            var id = $('#transaction_image_galery').find('li').attr('qq-file-id');
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }

            $('.message').printMessage({
              message: res.message
            });
            $('.message').fadeIn();
            $('.data_file_uuid').val('');

          } else {
            if (res.errors) {
              parseErrorField(res.errors);
            }
            $('.message').printMessage({
              message: res.message,
              type: 'warning'
            });
          }

        })
        .fail(function() {
          $('.message').printMessage({
            message: 'Error save data',
            type: 'warning'
          });
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({
            scrollTop: $(document).height()
          }, 2000);
        });

      return false;
    }); /*end btn save*/





    async function chain() {}

    chain();




  }); /*end doc ready*/
</script>