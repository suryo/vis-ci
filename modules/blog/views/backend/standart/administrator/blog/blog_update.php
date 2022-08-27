<link href="<?= BASE_ASSET ?>fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET ?>fine-upload/jquery.fine-uploader.js"></script>


<?php $this->load->view('core_template/fine_upload'); ?>

<section class="content-header">
  <h1>
    Blog <small>Edit Blog</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li ><a href="<?= site_url('administrator/blog'); ?>">Blog</a></li>
    <li class="active">Edit</li>
  </ol>
</section>
<?= form_open(base_url('administrator/blog/edit_save/' . $this->uri->segment(4)), [
  'name'    => 'form_blog',
  'class'   => 'form-horizontal',
  'id'      => 'form_blog',
  'method'  => 'POST'
]); ?>



<section class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="box box-warning">
        <div class="box-body ">
          
          <div class="box box-widget widget-user-2">
            
            <div class="widget-user-header ">
              <div class="widget-user-image">
                <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="User Avatar">
              </div>
              
              <h3 class="widget-user-username">Blog</h3>
              <h5 class="widget-user-desc">Edit Blog</h5>
              <hr>
            </div>
            <div class="form-group ">
              <label for="title" class="col-sm-2 control-label">Title
                <i class="required">*</i>
              </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title', $blog->title); ?>">
                <span class="info help-block"><?= site_url('blog/') ?>
                  <span contenteditable="true" class="blog-slug"><?= $blog->slug ?></span> <i class="fa fa-pencil" title="Custom URL"></i></span>
              </div>
            </div>

            <div class="form-group ">
              <label for="content" class="col-sm-2 control-label">Content
                <i class="required">*</i>
              </label>
              <div class="col-sm-9">
                <textarea id="content" name="content" rows="10" cols="80"> <?= set_value('content', $blog->content); ?></textarea>
                <small class="info help-block">
                </small>
              </div>
            </div>


            <div class="message"></div>
            <div class="row-fluid col-md-7">
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
          </div>
        </div>
        
      </div>
      
    </div>

    <div class="col-md-4">
      <div class="box box box-solid box-blog-right">
        <div class="box-header">
          <h3>Status</h3>
        </div>
        <div class="box-body ">

          <div class="clear"></div>
          <br>


          <div class="form-group ">
            <label for="status" class="col-sm-3 control-label">Status
            </label>
            <div class="col-sm-9">
              <select class="form-control chosen chosen-select" name="status" id="status" data-placeholder="Select Status">
                <option value=""></option>
                <option <?= $blog->status == "publish" ? 'selected' : ''; ?> value="publish">publish</option>
                <option <?= $blog->status == "draft" ? 'selected' : ''; ?> value="draft">draft</option>
                <option <?= $blog->status == "archive" ? 'selected' : ''; ?> value="archive">archive</option>
              </select>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="box box box-solid box-blog-right">
        <div class="box-header">
          <h3>Category</h3>
        </div>
        <div class="box-body ">

          <div class="clear"></div>
          <br>

          <div class="form-group ">
            <label for="category" class="col-sm-3 control-label">Category
            </label>
            <div class="col-sm-9">
              <select class="form-control chosen chosen-select-deselect" name="category" id="category" data-placeholder="Select Category">
                <option value=""></option>
                <?php foreach (db_get_all_data('blog_category') as $row) : ?>
                  <option <?= $row->category_id ==  $blog->category ? 'selected' : ''; ?> value="<?= $row->category_id ?>"><?= $row->category_name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row"></div>
          <br>


          <div class="form-group ">
            <label for="tags" class="col-sm-3 control-label">Tags
            </label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="tags" id="tags" placeholder="Tags" value="<?= set_value('tags', $blog->tags); ?>">
              <small class="info help-block">
              </small>
            </div>
          </div>


        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="box box box-solid box-blog-right">
        <div class="box-header">
          <h3>Media</h3>
        </div>
        <div class="box-body ">

          <div class="clear"></div>


          <div class="form-group ">
            <div class="col-sm-12">
              <div id="blog_image_galery"></div>
              <div id="blog_image_galery_listed">
                <?php foreach ((array) explode(',', $blog->image) as $idx => $filename) : ?>
                  <input type="hidden" class="listed_file_uuid" name="blog_image_uuid[<?= $idx ?>]" value="" /><input type="hidden" class="listed_file_name" name="blog_image_name[<?= $idx ?>]" value="<?= $filename; ?>" />
                <?php endforeach; ?>
              </div>
              <small class="info help-block">
                <b>Extension file must</b> JPG,JPEG,PNG.</small>
            </div>
          </div>

        </div>
      </div>


    </div>
</section>
<?= form_close(); ?>

<script src="<?= BASE_ASSET ?>ckeditor/ckeditor.js"></script>
<script src="<?= BASE_ASSET ?>js/page/blog/blog-update.js"></script>