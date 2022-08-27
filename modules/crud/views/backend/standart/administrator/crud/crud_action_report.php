<div class="col-md-12">
    <div class="form-group ">
        <label for="report"><?= cclang('report') ?> <i class="required">*</i></label>
        <div>
            <select class="form-control chosen chosen-select chosen-select-with-deselect" name="report" id="report" tabi-ndex="5" data-placeholder="Select Report">
                <option value=""></option>
                <?php foreach (db_get_all_data('report') as $row) : ?>
                    <option value="<?= $row->id; ?>"><?= $row->title; ?></option>
                <?php endforeach; ?>
            </select>
            <small class="info help-block">
                Choose report from report builder or <a href="<?= base_url('administrator/report/add') ?>" target="blank">create first </a>
            </small>

        </div>
    </div>
</div>