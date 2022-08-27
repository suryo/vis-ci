<link rel="stylesheet" href="<?= BASE_ASSET ?>css/rest.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>json-view/jquery.jsonview.css" />
<link rel="stylesheet" href="<?= BASE_ASSET ?>json-editor/dist/jsoneditor.css" />
<script src="<?= BASE_ASSET ?>json-view/jquery.jsonview.js"></script>

<script src="<?= BASE_ASSET ?>ace-master/build/src/ace.js"></script>
<script src="<?= BASE_ASSET ?>ace-master/build/src/ext-language_tools.js"></script>
<script src="<?= BASE_ASSET ?>ace-master/build/src/ext-beautify.js"></script>
<script src="<?= BASE_ASSET ?>json-editor/dist/jsoneditor.min.js"></script>

<section class="content-header">
  <h1>
    Rest <small><?= cclang('tool', ['Rest']); ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li ><a href="<?= site_url('administrator/rest'); ?>">Rest</a></li>
    <li class="active"><?= cclang('tool'); ?></li>
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
                <a class="btn btn-flat btn-success " title="Api Keys" href="<?= site_url('administrator/keys'); ?>"><i class="fa fa-key"></i> <?= cclang('api_key'); ?></a>
                <a class="btn btn-flat btn-success " title="Api Documentation" href="<?= site_url('administrator/doc/api'); ?>"><i class="fa fa-book"></i> <?= cclang('api_documentation'); ?></a>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="<?= BASE_ASSET ?>img/view.png" alt="User Avatar">
              </div>

              <h3 class="widget-user-username">Rest</h3>
              <h5 class="widget-user-desc"><?= cclang('tool', ['Rest']); ?></h5>
              <hr>
            </div>


            <div class="form-horizontal" name="form_rest" id="form_rest">
              <div class="row">
                <div class="col-md-10">
                  <div class="input-group input-group-lg">
                    <div class="input-group-btn ">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="method-selected">POST</span>
                        <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu">
                        <?php foreach ($methods as $met) : ?>
                          <li><a href="#" class="switch-method" data-value="<?= strtoupper($met); ?>"><?= strtoupper($met); ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <!-- /btn-group -->
                    <input class="form-control" id="url" placeholder="<?= cclang('enter_request_url'); ?>" type="text">
                    <a href="#" class="btn btn-lg btn-block btn-primary input-group-addon btn-toggle-param">Params</a>
                  </div>
                </div>

                <div class="col-md-2">
                  <a href="" class="btn btn-lg btn-block btn-primary btn-flat btn-send"><?= cclang('send_button'); ?></a>
                </div>
              </div>
              <br>
              <div class="col-md-12 padding-left-0 padding-right-0">
                <!-- Custom Tabs -->
                <table class="table-request display-none" id="table-param" width="100%">
                  <tbody>
                    <tr>
                      <td>
                        <div class="col-md-12">
                          <div class="form-group ">
                            <input type="text" name="key" placeholder="Key" class='form-control key'>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="col-md-12">
                          <div class="form-group ">
                            <input type="text" name="value" placeholder="Value" class='form-control value'>
                          </div>
                        </div>
                      </td>
                      <td>
                        <a class="btn btn-default  btn-remove btn-sm"><i class="fa fa-times"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li><a href="#tab_1" data-toggle="tab">Headers </a></li>
                    <li class="active"><a href="#tab_2" data-toggle="tab" class="active">Body </a></li>
                  </ul>
                  <div class="tab-content">

                    <div class="tab-pane rest-page-test" id="tab_1">
                      <table class="table-request" id="table-headers" width="100%">
                        <tbody>

                          <tr>
                            <td>
                              <div class="col-md-12">
                                <div class="form-group ">
                                  <input type="text" name="key" placeholder="Key" class='form-control key'>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="col-md-12">
                                <div class="form-group ">
                                  <input type="text" name="value" placeholder="Value" class='form-control value'>
                                </div>
                              </div>
                            </td>
                            <td>
                              <a class="btn btn-default  btn-remove btn-sm"><i class="fa fa-times"></i></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- end tab -->

                    <div class="tab-pane active" id="tab_2">
                      <form>

                        <table class="table-request" id="table-body" width="100%">
                          <tbody>

                            <tr>
                              <td width="40%">
                                <div class="col-md-12">
                                  <div class="form-group ">
                                    <input type="text" name="key" placeholder="Key" class='form-control key'>
                                  </div>
                                </div>
                              </td>
                              <td width="40%">
                                <div class="col-md-12">
                                  <div class="form-group container-input-type container-text ">
                                    <input type="text" name="value" placeholder="Value" class='form-control value'>
                                  </div>
                                  <label class="file-styling container-input-type container-file display-none">
                                    <div class="btn btn-flat btn-default col-md-4">Select file </div><span class="info-file"> No File Chosen</span>
                                    <input type="file" name="file" class="file">
                                  </label>
                                </div>
                              </td>
                              <td width="20px">
                                <select class="switch-input-type form-control type rubah">
                                  <option value="text">Text</option>
                                  <option value="file">File</option>
                                </select>
                              </td>
                              <td>
                                <a class="btn btn-default  btn-remove btn-sm"><i class="fa fa-times"></i></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
              </div>
              <!-- /.col -->
            </div>
          </div>

          <div class="row">

          </div>
          <div class="row container-mode margin-top-10">
            <div class="col-md-7">
              <div class="btn-group">
                <a href="#result-pretty" data-toggle="tab" type="button" class="btn btn-mode btn-default btn-mode-pretty ">Pretty</a>
                <a href="#result-raw" data-toggle="tab" type="button" class="btn btn-mode btn-default btn-mode-raw">Raw</a>
                <a href="#result-preview " data-toggle="tab" type="button" class="btn btn-mode btn-default btn-mode-preview active">Preview</a>
              </div>
              <div class="btn-group margin-left-10">
                <button type="button" class="btn btn-default btn-flat"><span class="mode-preview-type-selected">JSON</span></button>
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#" class="btn-mode-preview-type" data-value="html">HTML</a></li>
                  <li><a href="#" class="btn-mode-preview-type" data-value="json">JSON</a></li>
                </ul>
              </div>
            </div>

            <div class="col-md-3">
              <div class="col-xs-12"><b><?= cclang('status'); ?> : </b><span class="status text-blue"></span></div>
            </div>
            <div class="col-md-2">
              <div class="col-xs-12"><b><?= cclang('time'); ?> : </b><span class="time-requested text-blue"></span></div>
            </div>

          </div>
          </form>

          <div class="tab-content rest-tab-c">
            <pre class="result-pretty tab-pane " id="result-pretty">
                </pre>
            <pre class="result-raw tab-pane" id="result-raw">
                </pre>
            <div class="result-preview tab-pane active" id="result-preview">
            </div>
            <textarea class="source-fresh display-none"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
  "use strict";

  var segment = '<?= $this->uri->segment(4); ?>';
</script>
<script src="<?= BASE_ASSET ?>js/rest-tool.js"></script>
<script src="<?= BASE_ASSET ?>js/page/rest/rest-tool.js"></script>