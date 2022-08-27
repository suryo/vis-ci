<section class="content-header">
   <h1>
      Page <small><?= ucwords($page->title); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/page'); ?>">Page</a></li>
      <li class="active">Detail</li>
   </ol>
</section>

<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box-body ">
            <?= $content; ?>
         </div>
      </div>
   </div>
</section>


<script type="text/javascript">
   $(document).ready(function() {

      "use strict";

      $('.web-body').addClass('sidebar-collapse');
   })
</script>