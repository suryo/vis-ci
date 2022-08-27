<script type="text/javascript">
function domo(){
 
   $('*').bind('keydown', 'Ctrl+a', function() {
       window.location.href = BASE_URL + '/administrator/<?= ucwords($table_name); ?>/add';
       return false;
   });

   $('*').bind('keydown', 'Ctrl+f', function() {
       $('#sbtn').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function() {
       $('#reset').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function() {

       $('#reset').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>
<section class="content-header">
   <h1>
      {php_open_tag_echo} cclang('{table_name}') {php_close_tag}<small>{php_open_tag_echo} cclang('list_all'); {php_close_tag}</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">{php_open_tag_echo} cclang('{table_name}') {php_close_tag}</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
      
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <div class="widget-user-header ">
                     <div class="row pull-right">
                        <?php if ($this->input->post('create')) { ?>{php_open_tag} is_allowed('<?= $table_name; ?>_add', function(){{php_close_tag}
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="{php_open_tag_echo} cclang('add_new_button', [cclang('{table_name}')]); {php_close_tag}  (Ctrl+a)" href="{php_open_tag_echo}  site_url('administrator/<?= $table_name; ?>/add'); {php_close_tag}"><i class="fa fa-plus-square-o" ></i> {php_open_tag_echo} cclang('add_new_button', [cclang('{table_name}')]); {php_close_tag}</a>
                        {php_open_tag} }) {php_close_tag}
                        <?php } ?>{php_open_tag} is_allowed('<?= $table_name; ?>_export', function(){{php_close_tag}
                        <a class="btn btn-flat btn-success" title="{php_open_tag_echo} cclang('export'); {php_close_tag} {php_open_tag_echo} cclang('{table_name}') {php_close_tag} " href="{php_open_tag_echo} site_url('administrator/<?= $table_name; ?>/export?q='.$this->input->get('q').'&f='.$this->input->get('f')); {php_close_tag}"><i class="fa fa-file-excel-o" ></i> {php_open_tag_echo} cclang('export'); {php_close_tag} XLS</a>
                        {php_open_tag} }) {php_close_tag}
                        <?php if (!DISABLE_PDF_EXPORT): ?>
                        {php_open_tag} is_allowed('<?= $table_name; ?>_export', function(){{php_close_tag}
                        <a class="btn btn-flat btn-success" title="{php_open_tag_echo} cclang('export'); {php_close_tag} pdf {php_open_tag_echo} cclang('{table_name}') {php_close_tag} " href="{php_open_tag_echo} site_url('administrator/<?= $table_name; ?>/export_pdf?q='.$this->input->get('q').'&f='.$this->input->get('f')); {php_close_tag}"><i class="fa fa-file-pdf-o" ></i> {php_open_tag_echo} cclang('export'); {php_close_tag} PDF</a>
                        {php_open_tag} }) {php_close_tag}
                        <?php endif ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="{php_open_tag_echo} BASE_ASSET; {php_close_tag}/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">{php_open_tag_echo} cclang('{table_name}') {php_close_tag}</h3>
                     <h5 class="widget-user-desc">{php_open_tag_echo} cclang('list_all', [cclang('{table_name}')]); {php_close_tag}  <i class="label bg-yellow">{php_open_tag_echo} $<?= $table_name; ?>_counts; {php_close_tag}  {php_open_tag_echo} cclang('items'); {php_close_tag}</i></h5>
                  </div>

                  <form name="form_<?= $table_name; ?>" id="form_<?= $table_name; ?>" action="{php_open_tag_echo} base_url('administrator/<?= $table_name; ?>/index'); {php_close_tag}">
                  


                     <!-- /.widget-user -->
                  <div class="row">
                     <div class="col-md-8">
                        <?php if (!DISABLE_BULK_ACTION): ?>
                        <div class="col-sm-2 padd-left-0 " >
                           <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email" >
                           <?php if ($primary_key): ?>
                              <option value="delete">Delete</option>
                           <?php endif ?>
                           </select>
                        </div>
                        <div class="col-sm-2 padd-left-0 ">
                           <button type="button" class="btn btn-flat" name="apply" id="apply" title="{php_open_tag_echo} cclang('apply_bulk_action'); {php_close_tag}">{php_open_tag_echo} cclang('apply_button'); {php_close_tag}</button>
                        </div>
                        <?php endif ?>
                        <div class="col-sm-3 padd-left-0  " >
                           <input type="text" class="form-control" name="q" id="filter" placeholder="{php_open_tag_echo} cclang('filter'); {php_close_tag}" value="{php_open_tag_echo} $this->input->get('q'); {php_close_tag}">
                        </div>
                        <div class="col-sm-3 padd-left-0 " >
                           <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                              <option value="">{php_open_tag_echo} cclang('all'); {php_close_tag}</option>
                              <?php foreach ($this->crud_builder->getFieldShowInColumn(true) as $field): 
                           ?> <option {php_open_tag_echo} $this->input->get('f') == '<?= $field['name']; ?>' ? 'selected' :''; {php_close_tag} value="<?= $field['name']; ?>"><?= ucwords(clean_snake_case($field['label'])); ?></option>
                           <?php endforeach;
                           ?></select>
                        </div>
                        <div class="col-sm-1 padd-left-0 ">
                           <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="{php_open_tag_echo} cclang('filter_search'); {php_close_tag}">
                           Filter
                           </button>
                        </div>
                        <div class="col-sm-1 padd-left-0 ">
                           <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="{php_open_tag_echo} base_url('administrator/<?= $table_name; ?>');{php_close_tag}" title="{php_open_tag_echo} cclang('reset_filter'); {php_close_tag}">
                           <i class="fa fa-undo"></i>
                           </a>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate" >
                           {php_open_tag_echo} $pagination; {php_close_tag}
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive"> 

                  <br>
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr class="">
                          <?php if ($primary_key): ?>
                           <th>
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                           </th>
                         <?php endif ?>
                           <?php foreach ($this->crud_builder->getFieldShowInColumn() as $input): ?><th data-field="<?= $input ?>"data-sort="<?= !$this->crud_builder->getFieldFile($input) ? '1' : '0' ?>" data-primary-key="<?= ($input == $primary_key ? 1 : 0) ?>"> {php_open_tag_echo} cclang('<?= $input ?>') {php_close_tag}</th>
                           <?php endforeach; ?><?php if ($primary_key): ?><th>Action</th><?php endif ?>
                        </tr>
                     </thead>
                     <tbody id="tbody_<?= $table_name; ?>">
                     {php_open_tag} foreach($<?= $table_name; ?>s as $<?= $table_name; ?>): {php_close_tag}
                        <tr>
                            <?php if ($primary_key): ?>
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="{php_open_tag_echo} $<?= $table_name; ?>->{primary_key}; ?>">
                           </td>
                            <?php endif ?>
                           
                           <?php foreach ($this->crud_builder->getFieldShowInColumn(true) as $field => $option): ?><?php 
                           $field = $option['name'];
                           $relation = $this->crud_builder->getFieldRelation($field);
                           $is_relation_multiple = $this->crud_builder->isMultipleInput($field);
                           if (!$this->crud_builder->getFieldFile($field) AND !$this->crud_builder->getFieldFileMultiple($field) AND !$relation){ 
                            ?><td><span class="list_<?= $option['wrapper_class'] ?>">{php_open_tag_echo} _ent($<?= $table_name; ?>-><?= $field; ?>); {php_close_tag}</span></td><?php } elseif ($is_relation_multiple){
                            ?><td>{php_open_tag_echo} join_multi_select($<?= $table_name; ?>-><?= $field; ?>, '<?= $relation['relation_table'] ?>', '<?= $relation['relation_value'] ?>', '<?= $relation['relation_label'] ?>'); {php_close_tag}</td><?php } elseif ($relation){
                            ?><td>{php_open_tag} if  ($<?= $table_name; ?>-><?= $field; ?>) {

                              echo anchor('administrator/<?= $relation['relation_table']; ?>/view/'.$<?= $table_name; ?>-><?= $field; ?>.'?popup=show', $<?= $table_name; ?>-><?= $relation['relation_table'].'_'.$relation['relation_label']; ?>, ['class' => 'popup-view']); }{php_close_tag} </td>
                            <?php } elseif($this->crud_builder->getFieldFileMultiple($field)) { 
                            ?><td>
                              {php_open_tag} foreach (explode(',', $<?= $table_name; ?>-><?= $field; ?>) as $file): {php_close_tag}
                              {php_open_tag} if (!empty($file)): {php_close_tag}
                                {php_open_tag} if (is_image($file)): {php_close_tag}
                                <a class="fancybox" rel="group" href="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $file; {php_close_tag}">
                                  <img src="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $file; {php_close_tag}" class="image-responsive" alt="image <?= $table_name; ?>" title="<?= $field; ?> <?= $table_name; ?>" width="40px">
                                </a>
                                {php_open_tag} else: {php_close_tag}
                                  <a href="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $file; {php_close_tag}" target="blank">
                                   <img src="{php_open_tag_echo} get_icon_file($file); {php_close_tag}" class="image-responsive image-icon" alt="image <?= $table_name; ?>" title="<?= $field; ?> {php_open_tag_echo} $file; {php_close_tag}" width="40px"> 
                                 </a>
                                {php_open_tag} endif; {php_close_tag}
                              {php_open_tag} endif; {php_close_tag}
                              {php_open_tag} endforeach; {php_close_tag}
                           </td>
                           <?php } else { 
                            ?><td>
                              {php_open_tag} if (!empty($<?= $table_name; ?>-><?= $field; ?>)): {php_close_tag}
                                {php_open_tag} if (is_image($<?= $table_name; ?>-><?= $field; ?>)): {php_close_tag}
                                <a class="fancybox" rel="group" href="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $<?= $table_name; ?>-><?= $field;?>; {php_close_tag}">
                                  <img src="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $<?= $table_name; ?>-><?= $field;?>; {php_close_tag}" class="image-responsive" alt="image <?= $table_name; ?>" title="<?= $field; ?> <?= $table_name; ?>" width="40px">
                                </a>
                                {php_open_tag} else: {php_close_tag}
                                  <a href="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $<?= $table_name; ?>-><?= $field;?>; {php_close_tag}" target="blank">
                                   <img src="{php_open_tag_echo} get_icon_file($<?= $table_name; ?>-><?= $field; ?>); {php_close_tag}" class="image-responsive image-icon" alt="image <?= $table_name; ?>" title="<?= $field; ?> {php_open_tag_echo} $<?= $table_name; ?>-><?= $field; ?>; {php_close_tag}" width="40px"> 
                                 </a>
                                {php_open_tag} endif; {php_close_tag}
                              {php_open_tag} endif; {php_close_tag}
                           </td>
                           <?php } ?> 
                           <?php endforeach; 
                           ?><?php if ($primary_key): ?><td width="200">
                            
                              <?php if ($this->input->post('read')) { ?>
                                {php_open_tag} is_allowed('<?= $table_name; ?>_view', function() use ($<?= $table_name; ?>){{php_close_tag}
                                <?php foreach($crud_actions as $action): ?>
                                 <?php 
                                $meta = json_decode($action->meta);

                                if ($action->action == 'report'){ ?>
                                 <a href="{php_open_tag_echo} report_builder(<?= $meta->report ?>, ${table_name}->{primary_key}); {php_close_tag}" target="blank" class="label-default"><i class="fa fa-file-pdf-o"></i> {php_open_tag_echo} cclang('PDF') {php_close_tag}
                                 <?php } 
                                 
                                 
                                if ($action->action == 'button'){ ?>
                                 <!-- <a href="{php_open_tag_echo} base_url("<?= str_replace('{id}', '${table_name}->{primary_key}', @$meta->link) ?>"); {php_close_tag}" target="blank" class="label-default"><i class="fa <?= $meta->icon ?>"></i> <?= $meta->label ?>  -->
                                 <?php } ?>
                                 
                                 <?php endforeach ?>
                              <a href="{php_open_tag_echo} site_url('administrator/<?= $table_name; ?>/view/' . ${table_name}->{primary_key}); {php_close_tag}" class="label-default"><i class="fa fa-newspaper-o"></i> {php_open_tag_echo} cclang('view_button'); {php_close_tag}
                              {php_open_tag} }) {php_close_tag}
                              <?php } ?><?php if ($this->input->post('update')) { ?>{php_open_tag} is_allowed('<?= $table_name; ?>_update', function() use ($<?= $table_name; ?>){{php_close_tag}
                              <a href="{php_open_tag_echo} site_url('administrator/<?= $table_name; ?>/edit/' . ${table_name}->{primary_key}); {php_close_tag}" class="label-default"><i class="fa fa-edit "></i> {php_open_tag_echo} cclang('update_button'); {php_close_tag}</a>
                              {php_open_tag} }) {php_close_tag}
                              <?php } ?>{php_open_tag} is_allowed('<?= $table_name; ?>_delete', function() use ($<?= $table_name; ?>){{php_close_tag}
                              <a href="javascript:void(0);" data-href="{php_open_tag_echo} site_url('administrator/<?= $table_name; ?>/delete/' . ${table_name}->{primary_key}); {php_close_tag}" class="label-default remove-data"><i class="fa fa-close"></i> {php_open_tag_echo} cclang('remove_button'); {php_close_tag}</a>
                               {php_open_tag} }) {php_close_tag}

                           </td><?php endif ?>
                        </tr>
                      {php_open_tag} endforeach; {php_close_tag}
                      {php_open_tag} if ($<?= $table_name; ?>_counts == 0) :{php_close_tag}
                         <tr>
                           <td colspan="100">
                           <?= ucwords($subject); ?> data is not available
                           </td>
                         </tr>
                      {php_open_tag} endif; {php_close_tag}

                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
             
            </div>
            <?= form_close(); ?>
            
         </div>
      </div>
   </div>
</section>

<?php $functions = $this->crud_builder->getFunctionBody('javascript_setting_list'); ?>

<script>
  $(document).ready(function(){

    "use strict";
   
    <?php if (isset($functions['onReady'])): 
      ?>(function()<?= $functions['onReady'] ?>)()
      <?php endif ?>

      <?php if (isset($functions['eachRows'])): ?>

      $('.table tbody tr').each(function(){
         var row = $(this);
         (function()<?= $functions['eachRows'] ?>)()
      })
      <?php endif ?>

    $('.remove-data').click(function(){

      var url = $(this).attr('data-href');

      swal({
          title: "{php_open_tag_echo} cclang('are_you_sure'); {php_close_tag}",
          text: "{php_open_tag_echo} cclang('data_to_be_deleted_can_not_be_restored'); {php_close_tag}",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "{php_open_tag_echo} cclang('yes_delete_it'); {php_close_tag}",
          cancelButtonText: "{php_open_tag_echo} cclang('no_cancel_plx'); {php_close_tag}",
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


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_<?= $table_name; ?>').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "{php_open_tag_echo} cclang('are_you_sure'); {php_close_tag}",
            text: "{php_open_tag_echo} cclang('data_to_be_deleted_can_not_be_restored'); {php_close_tag}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{php_open_tag_echo} cclang('yes_delete_it'); {php_close_tag}",
            cancelButtonText: "{php_open_tag_echo} cclang('no_cancel_plx'); {php_close_tag}",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/<?= $table_name; ?>/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "{php_open_tag_echo} cclang('please_choose_bulk_action_first'); {php_close_tag}",
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
    initSortable('{table_name}', $('table.dataTable'));
  }); /*end doc ready*/
</script>