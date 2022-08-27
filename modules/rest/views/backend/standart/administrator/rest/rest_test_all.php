<link rel="stylesheet" href="<?= BASE_ASSET ?>json-view/jquery.jsonview.css" />
<script type="text/javascript" src="<?= BASE_ASSET ?>json-view/jquery.jsonview.js"></script>

<div class="hide filter-item-template">
   <div class="col-md-12 filters-item">

      <div class="form-group ">
         <label for="status" class="col-sm-5 control-label">filters[0][co][{idx}}][fl]
         </label>
         <div class="col-sm-7">
            <select name="filters[0][co][{idx}][fl]" id="rest_field" class="form-control">
               <option value=""></option>

            </select>
            <smalll class="help-block">field</small>
         </div>
      </div>

      <div class="form-group ">
         <label for="status" class="col-sm-5 control-label">filters[0][co][{idx}][op]
         </label>
         <div class="col-sm-7">
            <select name="filters[0][co][{idx}][op]" id="" class="form-control">
               <option value="equal">equal (=)</option>
               <option value="not_equal">not_equal (!=)
               </option>
               <option value="greather">greather (>)
               </option>
               <option value="greather_equal">greather_equal (>=)
               </option>
               <option value="smaller_equal">smaller_equal (<=) </option>
               <option value="smaller">smaller (<) </option>
               <option value="is_null">is_null
               </option>
               <option value="not_null">not_null
               </option>
               <option value="where_in">where_in
               <option value="where_not_in">where_not_in
               </option>
               <option value="like">like
               </option>
            </select>

            <smalll class="help-block">operator</small>
         </div>
      </div>
      <div class="form-group ">
         <label for="status" class="col-sm-5 control-label">filters[0][co][{idx}][vl]
         </label>
         <div class="col-sm-7">
            <input type="text" name="filters[0][co][{idx}][vl]" class='form-control'>
            <smalll class="help-block">value</small>
         </div>
      </div>


      <div class="form-group ">
         <label for="status" class="col-sm-5 control-label">filters[0][co][{idx}][lg]
         </label>
         <div class="col-sm-7">
            <select name="filters[0][co][{idx}][lg]" id="" class="form-control">
               <option value="and">and
               </option>
               <option value="or">or
               </option>
            </select>
            <smalll class="help-block">logic</small>
         </div>
      </div>

      <a href="" class="btn-remove-filter btn btn-sm btn-danger pull-right m-t-20"><i class="fa fa-trash"></i></a>

      <hr>
   </div>
</div>
<form class="form-horizontal form-add" name="form_rest" id="form_rest" enctype="multipart/form-data" action="<?= base_url('api/' . $rest->table_name . '/all'); ?>" method="GET">

   <table class="table table-responsive table table-bordered table-striped" id="diagnosis_list">
      <thead>
         <tr>
            <th width="25%" rowspan="2" valign="midle">HEADER</th>
            <th width="120" rowspan="2" valign="midle">Value</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td>X-Api-Key</td>
            <td>
               <div class="col-md-6 padding-left-0">
                  <input type="text" id="x_api_key" name="X-Api-Key" class='form-control'>
               </div>
            </td>
         </tr>
         <?php if ($rest->x_token == 'yes') : ?>
            <tr>
               <td>X-Token</td>
               <td>
                  <div class="col-md-6 padding-left-0">
                     <input type="text" id="x_token" name="X-Token" class='form-control'>
                  </div>
               </td>
            </tr>
         <?php endif; ?>
      </tbody>

      <table class="table table-responsive table table-bordered table-striped" id="diagnosis_list">
         <thead>
            <tr>
               <th width="5%" rowspan="2" valign="midle">No</th>
               <th width="20%" rowspan="2" valign="midle">Field</th>
               <th width="200" rowspan="2" valign="midle">Value</th>
               <th width="200" rowspan="2" valign="midle">Validation</th>
            </tr>
         </thead>
         <tbody>

            <tr>
               <td>
                  1
               </td>
               <td>
                  Filter
               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <input type="text" name="filter" class='form-control'>
                     </div>
                  </div>
               </td>
               <td></td>
            </tr>
            <tr>
               <td>
                  2
               </td>
               <td>
                  Field
               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <input type="text" name="field" class='form-control'>
                     </div>
                  </div>
               </td>
               <td></td>
            </tr>
            <tr>
               <td>
                  3
               </td>
               <td>
                  Start

               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <input type="text" name="start" class='form-control'>
                     </div>
                  </div>
               </td>
               <td></td>
            </tr>
            <tr>
               <td>
                  4
               </td>
               <td>
                  Limit
               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <input type="text" name="limit" class='form-control'>
                     </div>
                  </div>
               </td>
               <td></td>
            </tr>
            <tr>
               <td>
                  5
               </td>
               <td>
                  Filters
               </td>
               <td>

                  <div class="filters-item-wrapper">

                  </div>

                  <a href="" class="btn-add-filter btn btn-primary">Add Filter</a>


               </td>
               <td></td>
            </tr>

            <tr>
               <td>
                  6
               </td>
               <td>
                  Sort Field
               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <select type="text" name="sort_field" class='form-control' id="sort_field">
                           <option value=""></option>
                        </select>
                     </div>
                  </div>
               </td>
               <td></td>
            </tr>


            <tr>
               <td>
                  7
               </td>
               <td>
                  Sort Order
               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <select type="text" name="sort_order" class='form-control'>
                           <option value="ASC">ASC</option>
                           <option value="DESC">DESC</option>
                        </select>
                     </div>
                  </div>
               </td>
               <td></td>
            </tr>

            <tr>
               <td>
                  8
               </td>
               <td>
                  Onlycount
               </td>
               <td>
                  <div class="col-md-12">
                     <div class="form-group ">
                        <input type="checkbox" name="onlycount">
                     </div>
                  </div>
               </td>
               <td></td>
            </tr>


         </tbody>
      </table>
      </div>

      <div class="row">
         <div class="col-md-3"><b>URL :</b> </div>
         <div class="col-md-8">
            <div class=" url-api">
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="col-xs-3 padding-left-0"><b>Response</b></div>
            <div class="col-xs-4"><b>Status : </b><span class="status text-blue"></span></div>
            <div class="col-xs-5 padding-right-0">
               <input type="submit" value="Send" class="btn btn-lg btn-primary btn-flat pull-right">
               <span class="loading loading-hide pull-right padding-10"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i>Loading, Submitting Data</i></span>
            </div>
         </div>
      </div>
</form>

<div class="result-json">
</div>


<script src="<?= BASE_ASSET ?>ace-master/build/src/ace.js"></script>
<script src="<?= BASE_ASSET ?>ace-master/build/src/ext-language_tools.js"></script>
<script src="<?= BASE_ASSET ?>ace-master/build/src/ext-beautify.js"></script>
<script src="<?= BASE_ASSET ?>js/page/rest/rest-test-all.js"></script>