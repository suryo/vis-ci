<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+e', function() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function() {
      $('#btn_back').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>
<section class="content-header">
   <h1>
      <?= ucwords($subject); ?>
      <small>{php_open_tag_echo} cclang('detail', ['<?= ucwords($subject); ?>']); {php_close_tag} </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="{php_open_tag_echo} site_url('administrator/{table_name}'); {php_close_tag}"><?= ucwords($subject); ?></a></li>
      <li class="active">{php_open_tag_echo} cclang('detail'); {php_close_tag}</li>
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
                        <img class="img-circle" src="{php_open_tag_echo} BASE_ASSET; {php_close_tag}/img/view.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username"><?= ucwords($subject); ?></h3>
                     <h5 class="widget-user-desc">Detail <?= ucwords($subject); ?></h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal form-step" name="form_{table_name}" id="form_{table_name}" >
                  <?php 
                  $stepper = [];
                  foreach ($this->crud_builder->getFieldShowInDetailPage(true) as $input => $option): 
                    $relation = $this->crud_builder->getFieldRelation($input);
                    $is_relation_multiple = $this->crud_builder->isMultipleInput($input);

                  if (in_array($option['input_type'], $this->crud_builder->getFieldNotShowInAddForm())) continue; ?><?php 
                  if (isset($option['configs']['stepper'])): 
                      $step_title = $option['configs']['stepper']['title'];
                      if (count($stepper)) {
                          ?></section><?php
                      }
                      $stepper[$option['input_type']] = $step_title;
                  ?>

                  <h3><?= $step_title ?></h3>
                  <section>
                  <?php endif ?>

                  <?php if ($this->crud_builder->getFieldFile($input)) {?>  <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> <?= ucwords(clean_snake_case($option['label'])); ?> </label>
                        <div class="col-sm-8">
                             {php_open_tag} if (is_image($<?= $table_name; ?>-><?= $input; ?>)): {php_close_tag}
                              <a class="fancybox" rel="group" href="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $<?= $table_name; ?>-><?= $input;?>; {php_close_tag}">
                                <img src="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $<?= $table_name; ?>-><?= $input;?>; {php_close_tag}" class="image-responsive" alt="image <?= $table_name; ?>" title="<?= $input; ?> <?= $table_name; ?>" width="40px">
                              </a>
                              {php_open_tag} else: {php_close_tag}
                              <label>
                                <a href="{php_open_tag_echo} BASE_URL . 'administrator/file/download/<?= $table_name; ?>/' . $<?= $table_name; ?>-><?= $input;?>; {php_close_tag}">
                                 <img src="{php_open_tag_echo} get_icon_file($<?= $table_name; ?>-><?= $input; ?>); {php_close_tag}" class="image-responsive" alt="image <?= $table_name; ?>" title="<?= $input; ?> {php_open_tag_echo} $<?= $table_name; ?>-><?= $input; ?>; {php_close_tag}" width="40px"> 
                               {php_open_tag_echo} $<?= $table_name; ?>-><?= $input; ?> {php_close_tag}
                               </a>
                               </label>
                              {php_open_tag} endif; {php_close_tag}
                        </div>
                    </div>
                  <?php } elseif ($this->crud_builder->getFieldFileMultiple($input)) {?>  <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> <?= ucwords(clean_snake_case($option['label'])); ?> </label>
                        <div class="col-sm-8">
                             {php_open_tag} if (!empty($<?= $table_name; ?>-><?= $input; ?>)): {php_close_tag}
                             {php_open_tag} foreach (explode(',', $<?= $table_name; ?>-><?= $input; ?>) as $filename): {php_close_tag}
                               {php_open_tag} if (is_image($<?= $table_name; ?>-><?= $input; ?>)): {php_close_tag}
                                <a class="fancybox" rel="group" href="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $filename; {php_close_tag}">
                                  <img src="{php_open_tag_echo} BASE_URL . 'uploads/<?= $table_name; ?>/' . $filename; {php_close_tag}" class="image-responsive" alt="image <?= $table_name; ?>" title="<?= $input; ?> <?= $table_name; ?>" width="40px">
                                </a>
                                {php_open_tag} else: {php_close_tag}
                                <label>
                                  <a href="{php_open_tag_echo} BASE_URL . 'administrator/file/download/<?= $table_name; ?>/' . $filename; {php_close_tag}">
                                   <img src="{php_open_tag_echo} get_icon_file($filename); {php_close_tag}" class="image-responsive" alt="image <?= $table_name; ?>" title="<?= $input; ?> {php_open_tag_echo} $filename; {php_close_tag}" width="40px"> 
                                 {php_open_tag_echo} $filename {php_close_tag}
                               </a>
                               </label>
                              {php_open_tag} endif; {php_close_tag}
                            {php_open_tag} endforeach; {php_close_tag}
                          {php_open_tag} endif; {php_close_tag}
                        </div>
                    </div>
                  
                  <?php } elseif ($is_relation_multiple) {?>  <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"><?= ucwords(clean_snake_case($option['label'])); ?> </label>

                        <div class="col-sm-8">
                          {php_open_tag_echo} join_multi_select($<?= $table_name; ?>-><?= $input; ?>, '<?= $relation['relation_table'] ?>', '<?= $relation['relation_value'] ?>', '<?= $relation['relation_label'] ?>'); {php_close_tag}
                        </div>
                    </div>
                    <?php } elseif ($relation) {?>  <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"><?= ucwords(clean_snake_case($option['label'])); ?> </label>

                        <div class="col-sm-8">
                           {php_open_tag_echo} _ent(${table_name}-><?= $relation['relation_table'].'_'.$relation['relation_label']; ?>); {php_close_tag}
                        </div>
                    </div>
                    <?php }  else {?>  <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"><?= ucwords(clean_snake_case($option['label'])); ?> </label>

                        <div class="col-sm-8">
                        <span class="detail_<?= $option['wrapper_class'] ?>">{php_open_tag_echo} _ent(${table_name}-><?= $input; ?>); {php_close_tag}</span>
                        </div>
                    </div>
                    <?php } ?>
                    <?php endforeach; ?>

                    <br>
                    <br>


                     
                       <?php if (count($stepper)): ?>
                        </section>
                        <div class="message"></div>
                        <?php endif ?>
  
                    <div class="view-nav">
                        {php_open_tag} is_allowed('{table_name}_update', function() use (${table_name}){{php_close_tag}
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit {table_name} (Ctrl+e)" href="{php_open_tag_echo} site_url('administrator/{table_name}/edit/'.${table_name}->{primary_key}); {php_close_tag}"><i class="fa fa-edit" ></i> {php_open_tag_echo} cclang('update', ['<?= ucwords(clean_snake_case($table_name)); ?>']); {php_close_tag} </a>
                        {php_open_tag} }) {php_close_tag}
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="{php_open_tag_echo} site_url('administrator/{table_name}/'); {php_close_tag}"><i class="fa fa-undo" ></i> {php_open_tag_echo} cclang('go_list_button', ['<?= ucwords(clean_snake_case($table_name)); ?>']); {php_close_tag}</a>
                     </div>
                    
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php $functions = $this->crud_builder->getFunctionBody('javascript_setting_detail'); ?>

<script>
$(document).ready(function(){

    "use strict";
    
   <?php if (isset($functions['onReady'])): 
      ?>(function()<?= $functions['onReady'] ?>)()
      <?php endif ?>

   <?php if (count($stepper)): ?>$('.container-button-bottom').hide();
   $('.form-step').steps({
      headerTag: 'h3',
      bodyTag: 'section',
      autoFocus: true,
      enableAllSteps : true,
      onFinishing : function(){
        $('.btn_save_back').trigger('click')
      },
      labels : {
        finish : 'save'
      },
      enableFinishButton : false
  });
  <?php endif ?>
});
</script>