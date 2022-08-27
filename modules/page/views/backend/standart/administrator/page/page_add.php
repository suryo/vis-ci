<link rel="stylesheet" href="<?= BASE_ASSET ?>fine-upload/fine-uploader-gallery.min.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>editor/dist/css/medium-editor.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>editor/dist/css/themes/beagle.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>spectrum/spectrum.css">

<script src="<?= BASE_ASSET ?>fine-upload/jquery.fine-uploader.js"></script>

<script src="<?= BASE_ASSET ?>ace-master/build/src/ace.js"></script>
<script src="<?= BASE_ASSET ?>ace-master/build/src/ext-language_tools.js"></script>
<script src="<?= BASE_ASSET ?>ace-master/build/src/ext-beautify.js"></script>
<script src="<?= BASE_ASSET ?>iframe-auto/release/jquery.browser.js"></script>
<script src="<?= BASE_ASSET ?>iframe-auto/src/jquery-iframe-auto-height.js"></script>
<script src="<?= BASE_ASSET ?>spectrum/spectrum.js"></script>
<script src="<?= BASE_ASSET ?>js/page.js"></script>

<?php $this->load->view('core_template/fine_upload'); ?>



<section class="content-header">
  <h1>
    <?= cclang('page') ?> <small><?= cclang('new', cclang('page')); ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('home'); ?></a></li>
    <li><a href="<?= site_url('administrator/page'); ?>"><?= cclang('page') ?></a></li>
    <li class="active"><?= cclang('new'); ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-page">
        <div class="box-body  padding-left-0 padding-right-0">

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom padding-left-0 tab-page ">
            <ul class="nav nav-tabs">
              <li class="active"><a class=" active tab_animation" href="#tab_1" data-toggle="tab"><i class="fa fa-gear text-green"></i> <?= cclang('page_settings'); ?></a></li>
              <li><a class=" active btn-form-preview tab_animation" href="#tab_2" data-toggle="tab"><i class="fa fa-code text-green"></i> <?= cclang('page_designer'); ?></a></li>
              <li class="pull-right"><a href="#tab_preview" class="text-muted btn-danger btn-mode btn-mode-phone btn"><i class="fa fa-mobile-phone "></i></a></li>
              <li class="pull-right"><a href="#tab_preview" class="text-muted btn-danger btn-mode btn-mode-tablet btn"><i class="fa fa-tablet"></i></a></li>
              <li class="pull-right"><a href="#tab_preview" class="text-muted btn-danger active btn-mode btn-mode-desktop btn"><i class="fa fa-desktop"></i></a></li>
              <li class="pull-right"><a href="#tab_preview" data-toggle="tab" class="text-muted btn-danger btn-mode-preview btn text-green"><?= cclang('preview'); ?></a></li>
              <li class="pull-right">
                <span class="loading2 loading-hide">
                  <img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg">
                  <i><?= cclang('loading_generating_preview'); ?></i>
                  <input type="hidden" id="preview_page_name">
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane rest-page-test active margin-top-20" id="tab_1">
                <div class="box box-widget widget-user-2">

                  <?= form_open('', [
                    'name'    => 'form_page',
                    'class'   => 'form-horizontal',
                    'id'      => 'form_page',
                    'enctype' => 'multipart/form-data',
                    'method'  => 'POST'
                  ]); ?>

                  <div class="form-group ">
                    <label for="title" class="col-sm-2 control-label"><?= cclang('title'); ?>
                      <i class="required">*</i>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                      <small class="info help-block">
                        <b>Format Title must</b> Alpha Numeric Spaces.</small>
                    </div>
                  </div>

                  <div class="form-group  wrapper-options-crud">
                    <label for="type" class="col-sm-2 control-label"><?= cclang('type'); ?>
                      <i class="required">*</i>
                    </label>
                    <div class="col-sm-8">
                      <div class="col-sm-2 padding-left-0">
                        <label>
                          <input type="radio" class="flat-red" name="type" value="frontend" checked> <?= cclang('frontend'); ?>
                        </label>
                      </div>
                      <div class="col-sm-2 padding-left-0">
                        <label>
                          <input type="radio" class="flat-red" name="type" value="backend"> <?= cclang('backend'); ?>
                        </label>
                      </div>
                      </select>
                      <div class="row-fluid clear-both">
                        <small class="info help-block">
                        </small>
                      </div>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="link" class="col-sm-2 control-label"><?= cclang('link'); ?>
                      <i class="required">*</i>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="link" id="link" placeholder="Link" value="<?= set_value('link'); ?>">
                      <small class="info help-block page-url-help-block">
                        ex : about-me
                      </small>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="keyword" class="col-sm-2 control-label"><?= cclang('keyword'); ?>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword" value="<?= set_value('keyword'); ?>">
                      <small class="info help-block">
                        Keyword for meta data.
                      </small>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="description" class="col-sm-2 control-label"><?= cclang('description'); ?>
                    </label>
                    <div class="col-sm-8">
                      <textarea id="description" name="description" rows="5" class="textarea form-control"><?= set_value('description'); ?></textarea>
                      <small class="info help-block">
                        Description for meta data.
                      </small>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="template" class="col-sm-2 control-label"><?= cclang('template'); ?>
                      <i class="required">*</i>
                    </label>
                    <div class="col-sm-8">

                      <label>
                        <div class="layout-icon-wrapper">
                          <div class="layout-icon">

                          </div>
                          <div class="layout-info"><?= cclang('blank'); ?> </div>
                          <input type="radio" name="template" value="blank" checked>
                        </div>
                      </label>
                      <label>
                        <div class="layout-icon-wrapper">
                          <div class="layout-icon layout-icon-default">
                            <div class="square-vertical">
                            </div>
                            <div class="square-horizontal">
                            </div>
                          </div>
                          <div class="layout-info"><?= cclang('default'); ?> </div>
                          <input type="radio" name="template" value="default">
                        </div>
                      </label>
                      <small class="info help-block">
                      </small>
                    </div>
                  </div>


                  <div class="message"></div>
                  <div class="row-fluid col-md-7">
                    <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="save (Ctrl+s)"><i class="fa fa-save"></i> <?= cclang('save_button'); ?></button>
                    <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)"><i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?></a>
                    <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)"><i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?></a>
                    <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_saving_data'); ?></i></span>
                  </div>
                  <?= form_close(); ?>

                </div>
              </div><!-- end tab1 -->

              <div class="tab-pane" id="tab_preview">
                <div class="windows">
                  <div class="win-bar">
                    <div class="win-bar-responsive">
                      <div class="win-icon bg-red btn-close"></div>
                      <div class="win-icon bg-yellow btn-full-screen"></div>
                      <div class="win-icon bg-green btn-minimize"></div>
                    </div>
                  </div>
                </div>
                <iframe class="iframe-page-preview" scrolling="no" width="100%"></iframe>
              </div>

              <div class="tab-pane" id="tab_2">
                <div class=" page-content">
                  <div class="windows ">
                    <div class="win-bar">
                      <div class="win-icon bg-red btn-close"></div>
                      <div class="win-icon bg-yellow btn-full-screen"></div>
                      <div class="win-icon bg-green btn-minimize"></div>
                    </div>
                    <div class="win-content" id="content" name="content editable">
                      <div class="win-content-loading-container display-none ">
                        <div class="win-content-loading no-select" contenteditable="false">
                          <div id="fountainG">
                            <div id="fountainG_1" class="fountainG"></div>
                            <div id="fountainG_2" class="fountainG"></div>
                            <div id="fountainG_3" class="fountainG"></div>
                            <div id="fountainG_4" class="fountainG"></div>
                            <div id="fountainG_5" class="fountainG"></div>
                            <div id="fountainG_6" class="fountainG"></div>
                            <div id="fountainG_7" class="fountainG"></div>
                            <div id="fountainG_8" class="fountainG"></div>
                          </div>
                        </div>
                      </div>
                      <ul class="element-sortable " id="draggable">
                        <li class="block-item ui-draggable ui-draggable-handle block-item-loaded" data-src="portofolio\/column.php" data-block-name="portofolio\">
                          <div class="nav-content-wrapper noselect ui-sortable">
                            <i class="fa fa-gear"></i>
                            <div class="tool-nav delete ui-sortable">
                              <i class="fa fa-trash"></i> <span class="info-nav">Delete</span>
                            </div>
                            <div class="tool-nav source ui-sortable">
                              <i class="fa fa-code"></i> <span class="info-nav">Source</span>
                            </div>
                            <div class="tool-nav copy ui-sortable">
                              <i class="fa fa-copy"></i> <span class="info-nav">Copy</span>
                            </div>
                            <div class="tool-nav handle ui-sortable">
                              <i class="fa fa-arrows"></i> <span class="info-nav">Move</span>
                            </div>
                          </div>

                          <div class="block-content editable ui-sortable">
                            <cc-element cc-id="style">

                            </cc-element>

                            <cc-element cc-id="content">
                              <div class="container">
                                <div class="row">
                                  <div class="column col-md-12">
                                    <p>.</p>
                                  </div>
                                </div>
                              </div>
                            </cc-element>
                            <cc-element cc-id="script" cc-placement="top">
                            </cc-element>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <div class="btn-round-element noselect " title="<?= cclang('add_block_element'); ?>" data-toggle="control-sidebar">
                    <span>+</span>
                  </div>
                </div><!-- end content -->
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
  </div>
  </div>
</section>

<aside class="control-sidebar control-sidebar-dark toolbox-form height-100pr ">
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li class="active"><a href="#tab-element" data-toggle="tab" aria-expanded="true"><i class="fa fa-code text-green"></i> <?= cclang('element'); ?></a></li>
    <li><a href="#tab-component" data-toggle="tab" aria-expanded="false"><i class="fa  fa-puzzle-piece text-green"></i> <?= cclang('component'); ?></a></li>
  </ul>
  <div class="tab-content height-100pr">
    <div class="tab-pane padding-left-0 active" id="tab-element">
      <h4 class="control-sidebar-heading"><i class="fa fa-bars"></i> <?= cclang('block'); ?></h4>
      <div class="tool-wrapper">
        <ul class="block-list">
          <li><a href="#" id="btn-all-element"> <?= cclang('all_elements'); ?></a></li>
          <?= $this->cc_page_element->displayPageElement(); ?>
        </ul>
      </div>
    </div>
    <div class="tab-pane padding-left-0" id="tab-component">
      <h4 class="control-sidebar-heading"><i class="fa fa-bars"></i> <?= cclang('component'); ?></h4>
      <div class="component-wrapper">
      </div>
    </div>
  </div>
</aside>

<aside class=" toolbox-detail-element ">
  <div class="tab-content  tab-detail-element height-100prn">
    <h4 class="control-sidebar-heading"><i class="fa fa-cubes"></i> <?= cclang('detail_element'); ?> <a href="" class="badge bg-muted close-sidebar pull-right" title="close">+</a></h4>
    <div class="tool-wrapper">
      <div class="nav-tabs-custom-element padding-left-0">
      </div>
    </div>
    <div class="col-md-12 style-type">
      <br>
      <br>
      <br>
    </div>
    <div class="divider"></div>
    <a href="#" class="btn btn-success btn-flat btn-block btn-apply-element"> <?= cclang('apply_changes'); ?></a>
    <div class="row-fluid box-action">
      <a href="#" class="btn btn-success btn-flat btn-xs col-md-4 btn-clone-element"> <i class="fa fa-copy"> </i> <?= cclang('clone_button'); ?></a>
      <a href="#" class="btn btn-warning btn-flat btn-xs col-md-4 btn-reset-element"> <i class="fa fa-refresh"> </i> <?= cclang('reset_button'); ?></a>
      <a href="#" class="btn btn-danger btn-flat btn-xs col-md-4 btn-remove-element"> <i class="fa fa-trash"> </i> <?= cclang('remove_button'); ?></a>
    </div>
  </div>
  </div>
</aside>

<script src="<?= BASE_ASSET ?>js/page/page/page-add.js"></script>