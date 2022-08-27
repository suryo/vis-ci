<section>
  <iframe scrolling="no" src="<?= base_url('apidoc/index.html'); ?>" width="100%" class="web-doc-iframe" onload="resizeIframe(this)"></iframe>
</section>
<script type="text/javascript">
  $(document).ready(function() {
    "use strict";
    $('.web-body').addClass('sidebar-collapse');
    $('.web-doc-iframe').height('200000px')

  })
</script>