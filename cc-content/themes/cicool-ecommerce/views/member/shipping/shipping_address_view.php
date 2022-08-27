

<script type="text/javascript">

function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+e', function assets() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_back').trigger('click');
       return false;
   });
    
}


jQuery(document).ready(domo);
</script>

<section class="content-header">
   <h1>
      Shipping Address      <small><?= cclang('detail', ['Shipping Address']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li ><a  href="<?= site_url('administrator/shipping_address'); ?>">Shipping Address</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<section class="content">
   <div class="row" >
     
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               
               <div class="box box-widget widget-user-2">
                  
                  <div class="widget-user-header ">
                    
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/view.png" alt="User Avatar">
                     </div>
                     
                     <h3 class="widget-user-username">Shipping Address</h3>
                     <h5 class="widget-user-desc">Detail Shipping Address</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal form-step" name="form_shipping_address" id="form_shipping_address" >
                  
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->id); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Label </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->label); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Phone </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->phone); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Country </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->countries_name); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">State </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->states_name); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">City </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->cities_name); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Main </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->main); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Address Detail </label>

                        <div class="col-sm-8">
                           <?= _ent($shipping_address->address_detail); ?>
                        </div>
                    </div>
                                        
                    <br>
                    <br>


                     
                         
                    <div class="view-nav">
                        <?php is_allowed('shipping_address_update', function() use ($shipping_address){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit shipping_address (Ctrl+e)" href="<?= site_url('administrator/shipping_address/edit/'.$shipping_address->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Shipping Address']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/shipping_address/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Shipping Address']); ?></a>
                     </div>
                    
                  </div>
               </div>
            </div>
            
         </div>
         

      </div>
   </div>
</section>

<script>
$(document).ready(function(){

   });
</script>