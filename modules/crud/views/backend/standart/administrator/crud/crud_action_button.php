<div class="col-md-12">

    <br>
    <br>

    <div class="form-group menu-only">

        <div class="row">
            <div class="col-md-12">


                <input type="hidden" name="icon" id="icon">

                <div class="icon-preview">
                    <span class="icon-preview-item"><i class="fa fa-rss fa-lg"></i></span>
                </div>
                <br>
                <br>

                <a class="btn btn-default btn-select-icon btn-flat"><?= cclang('select_icon') ?></a>

            </div>
        </div>
    </div>

    <div class="row"></div>

    <div class="form-group ">
        <label for="report"><?= cclang('link') ?> <i class="required">*</i></label>
        <div>
            <input class="form-control " placeholder="/administrator/other_module/{id}" name="link" id="link" tabi-ndex="5">

        </div>
    </div>


    <div class="form-group ">
        <label for="report"><?= cclang('label') ?> <i class="required">*</i></label>
        <div>
            <input class="form-control " placeholder="" name="label" id="label" tabi-ndex="5">

        </div>
    </div>
</div>

<script src="<?= BASE_ASSET ?>js/page/crud/crud-action-button.js"></script>