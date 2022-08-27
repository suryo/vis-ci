

<section class="content-header">
   <h1>
      Blog<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Blog</li>
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
                        <?php is_allowed('blog_add', function () { ?>
                           <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', ['Blog']); ?>  (Ctrl+a)" href="<?= site_url('administrator/blog/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', ['Blog']); ?></a>
                        <?php }) ?>

                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                     </div>
                     
                     <h3 class="widget-user-username">Blog</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['Blog']); ?> <i class="label bg-yellow"><?= $blog_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_blog" id="form_blog" action="<?= base_url('administrator/blog/index'); ?>">


                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr >
                                 <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th>
                                 <th data-field="title" data-sort="1">Title</th>
                                 <th data-field="slug" data-sort="1">Slug</th>
                                 <th data-field="image" data-sort="1">Image</th>
                                 <th data-field="category" data-sort="1">Category</th>
                                 <th data-field="status" data-sort="1">Status</th>
                                 <th data-field="author" data-sort="1">Author</th>
                                 <th data-field="created_at" data-sort="1">Created At</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_blog">
                              <?php foreach ($blogs as $blog) : ?>
                                 <tr>
                                    <td width="5">
                                       <input type="checkbox" class="flat-red check" name="id[]" value="<?= $blog->id; ?>">
                                    </td>

                                    <td><?= _ent($blog->title); ?></td>
                                    <td><?= (anchor('blog/' . $blog->slug, $blog->slug, ['target' => 'blank'])); ?> <i class="fa fa-link"></i></td>
                                    <td>
                                       <?php foreach (explode(',', $blog->image) as $file) : ?>
                                          <?php if (!empty($file)) : ?>
                                             <?php if (is_image($file)) : ?>
                                                <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/blog/' . $file; ?>">
                                                   <img src="<?= BASE_URL . 'uploads/blog/' . $file; ?>" class="image-responsive" alt="image blog" title="image blog" width="40px">
                                                </a>
                                             <?php else : ?>
                                                <a href="<?= BASE_URL . 'administrator/file/download/blog/' . $file; ?>">
                                                   <img src="<?= get_icon_file($file); ?>" class="image-responsive image-icon" alt="image blog" title="image <?= $file; ?>" width="40px">
                                                </a>
                                             <?php endif; ?>
                                          <?php endif; ?>
                                       <?php endforeach; ?>
                                    </td>

                                    <td><?= _ent($blog->category_name); ?></td>

                                    <td><?= _ent($blog->status); ?></td>
                                    <td><?= _ent($blog->author); ?></td>
                                    <td><?= _ent($blog->created_at); ?></td>
                                    <td><?= _ent($blog->created_at); ?></td>

                                    <td width="200">
                                       <?php is_allowed('blog_view', function () use ($blog) { ?>
                                          <a href="<?= site_url('administrator/blog/view/' . $blog->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                                          <?php }) ?>
                                          <?php is_allowed('blog_update', function () use ($blog) { ?>
                                             <a href="<?= site_url('administrator/blog/edit/' . $blog->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                                          <?php }) ?>
                                          <?php is_allowed('blog_delete', function () use ($blog) { ?>
                                             <a href="javascript:void(0);" data-href="<?= site_url('administrator/blog/delete/' . $blog->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                                          <?php }) ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                              <?php if ($blog_counts == 0) : ?>
                                 <tr>
                                    <td colspan="100">
                                       Blog data is not available
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
                           <option value="delete">Delete</option>
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
                           <option <?= $this->input->get('f') == 'title' ? 'selected' : ''; ?> value="title">Title</option>
                           <option <?= $this->input->get('f') == 'slug' ? 'selected' : ''; ?> value="slug">Slug</option>
                           <option <?= $this->input->get('f') == 'image' ? 'selected' : ''; ?> value="image">Image</option>
                           <option <?= $this->input->get('f') == 'category' ? 'selected' : ''; ?> value="category">Category</option>
                           <option <?= $this->input->get('f') == 'status' ? 'selected' : ''; ?> value="status">Status</option>
                           <option <?= $this->input->get('f') == 'author' ? 'selected' : ''; ?> value="author">Author</option>
                           <option <?= $this->input->get('f') == 'created_at' ? 'selected' : ''; ?> value="created_at">Created At</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                           Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/blog'); ?>" title="<?= cclang('reset_filter'); ?>">
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
</section>


<script src="<?= BASE_ASSET ?>js/page/blog/blog-list.js"></script>