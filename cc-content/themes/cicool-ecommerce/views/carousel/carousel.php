<div id="home-carousel" class="carousel slide" data-ride="carousel">

  <?php
  $carousel = db_get_all_data('carousel');
  ?>
  <ol class="carousel-indicators">
    <?php for ($i = 0; $i < count($carousel); $i++) : ?>
      <li data-target="#home-carousel" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></li>
    <?php endfor ?>
  </ol>

  <div class="carousel-inner">
    <?php
    $i = 0;
    foreach ($carousel as $item) : $i++;
      if (filter_var($item->url, FILTER_VALIDATE_URL)) {
        $url = $item->url;
      } else {
        $url = base_url($item->url);
      }
    ?>
      <div class="item <?= $i == 1 ? 'active' : '' ?>">
        <a href="<?= $url ?>">
          <img src="<?= base_url('uploads/carousel/' . $item->image) ?>" alt="<?= _ent($item->title) ?>">
        </a>
      </div>
    <?php endforeach ?>
  </div>

  <a class="left carousel-control" href="#home-carousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#home-carousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>