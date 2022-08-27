<?= get_header(); ?>

<body id="page-top">
  <?= get_navigation(); ?>
  <?= get_view_component('search-nav'); ?>
  <div class="container margin-top-140">
  </div>
  <?= cicool()->eventListen('coshop_home_top'); ?>

  <div class="container">
    <div class="col-md-12">
      <div class="breadcrumb-product">
        <span class="breadcrumb-item"><a href="<?= base_url('') ?>">Home</a></span>
        <span class="breadcrumb-chevron"><span class="fa fa-chevron-right"></span></span>
        <span class="breadcrumb-item"><a href="<?= base_url('') ?>">Category</a></span>
        <span class="breadcrumb-chevron"><span class="fa fa-chevron-right"></span></span>
        <span class="breadcrumb-item-current"><?= $category ? ucwords($category->category_name) : 'all' ?></span>
      </div>
    </div>

    <div class="col-md-12">
      <div class="search-query-wrapper">
        <span class="fal fa-info-circle"></span> <?= $this->input->get('q') ? 'Search result for "<span class="search-query">' . $this->input->get('q') . '</span>" ' : '' ?>found <?= $total ?> products
      </div>
    </div>
    <div class="col-md-12">
      <?php if ($total) : ?>
        <div class="search-box-filter">
          <div class="col-md-1">Sort</div>
          <div class="col-md-6">
            <?php
            $q = $this->input->get('q');
            $sortby = $this->input->get('sortby');
            $cat = $this->uri->segment(2);

            switch ($sortby) {
              case 'news':
                $active = 'news';
                break;
              case 'sales':
                $active = 'sales';
                break;

              default:
                $active = 'relevant';
                break;
            }

            ?>
            <a href="<?= base_url('product/' . $cat . '?q=' . $this->input->get('q') . '&sortby=relevant') ?>" class="filter-button <?= $active == 'relevant' ? 'active' : '' ?>">Relevant<a>
                <a href="<?= base_url('product/' . $cat . '?q=' . $this->input->get('q') . '&sortby=news') ?>" class="filter-button  <?= $active == 'news' ? 'active' : '' ?>">Newest<a>
                    <a href="<?= base_url('product/' . $cat . '?q=' . $this->input->get('q') . '&sortby=sales') ?>" class="filter-button  <?= $active == 'sales' ? 'active' : '' ?>">Best Seller<a>
          </div>
        </div>
      <?php endif ?>
    </div>



    <?php foreach ($products as $product) : ?>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <?= get_view_component('product-single-item', ['product' => $product]) ?>
      </div>
    <?php endforeach; ?>
    <div class="col-md-12"><?= $pagination ?></div>
    <?php if ($total == 0) : ?>

      <link rel="stylesheet" href="<?= theme_asset() ?>js/plugin/glidejs/dist/css/glide.core.min.css">
      <link rel="stylesheet" href="<?= theme_asset() ?>js/plugin/glidejs/dist/css/glide.theme.min.css">
      <script src="<?= theme_asset() ?>js/plugin/glidejs/dist/glide.min.js"></script>

      <div class="empty-search-product">
        <center>
          <img src="<?= theme_asset() ?>/img/logistic.svg" width="350px" alt="">
        </center>
      </div>

      <div class="container" style="margin-bottom: 20px">
        <?= get_view_component('category/slide-category'); ?>
      </div>
    <?php endif ?>
  </div>

  <?= get_footer(); ?>