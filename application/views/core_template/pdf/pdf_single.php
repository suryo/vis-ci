<style type="text/css">
	* {
		font-size: 10px; 
	}
	table tbody tr td, table thead tr th{
		border-collapse: collapse;
		padding: 5px;
	}
	table thead tr th {
		background: #858585;
		color: #fff;
	}
</style>
<page>

<p><h2><?= ucwords($title); ?></h2></p>

				<?php foreach ($fields as $field){ ?>
					<h3><?= cclang($field); ?></h3>
					<p><?= $data->{$field}; ?></p>
					<hr>
					
				<?php } ?>
	<code></code>

  <page_footer>
    [[page_cu]]/[[page_nb]]
  </page_footer>
</page>
