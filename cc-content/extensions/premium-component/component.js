function dumyText() {
  return "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
}
CcPageElement.addComponentItem({
  'item_name': 'inner_section',
  'item_preview': '<i class="fa fa-puzzle-piece "></i> inner section',
  'item_content': `
    <div class="container">
    <div class="col-md-6 column"></div>
    <div class="col-md-6 column"></div>
    </div>
    `
  ,
  'component_group': 'pro'
});


CcPageElement.addComponentItem({
  'item_name': 'pricing_table',
  'item_preview': '<i class="fa fa-credit-card "></i> pricing',
  'item_content': `
    <style>
* {
  box-sizing: border-box;
}

.columns {
  float: left;
  width: 33.3%;
  padding: 8px;
}

.price {
  list-style-type: none;
  border: 1px solid #eee;
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.price .header {
  background-color: #111;
  color: white;
  font-size: 25px;
}

.price li {
  border-bottom: 1px solid #eee;
  padding: 20px;
  text-align: center;
}

.price .grey {
  background-color: #eee;
  font-size: 20px;
}

.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
}

@media only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
</style>
<h2 style="text-align:center">Pricing Tables</h2>
<div class="columns">
  <ul class="price">
    <li class="header">Basic</li>
    <li class="grey">RP. 9.99 / year</li>
    <li>10GB Storage</li>
    <li>10 Emails</li>
    <li>10 Domains</li>
    <li>1GB Bandwidth</li>
    <li class="grey"><a href="#" class="button">Sign Up</a></li>
  </ul>
</div>

<div class="columns">
  <ul class="price">
    <li class="header" style="background-color:#4CAF50">Pro</li>
    <li class="grey">RP. 24.99 / year</li>
    <li>25GB Storage</li>
    <li>25 Emails</li>
    <li>25 Domains</li>
    <li>2GB Bandwidth</li>
    <li class="grey"><a href="#" class="button">Sign Up</a></li>
  </ul>
</div>

<div class="columns">
  <ul class="price">
    <li class="header">Premium</li>
    <li class="grey">RP. 49.99 / year</li>
    <li>50GB Storage</li>
    <li>50 Emails</li>
    <li>50 Domains</li>
    <li>5GB Bandwidth</li>
    <li class="grey"><a href="#" class="button">Sign Up</a></li>
  </ul>
</div>
    `
  ,
  'component_group': 'pro'
});


CcPageElement.addComponentItem({
  'item_name': 'tables',
  'item_preview': '<i class="fa fa-table "></i> tables',
  'item_content': `<table class="table">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
    `
  ,
  'component_group': 'pro'
});




CcPageElement.addComponentItem({
  'item_name': 'list_group',
  'item_preview': '<i class="fa fa-list-alt "></i> list group',
  'item_content': `
    <ul class="list-group">
  <li class="list-group-item">First item</li>
  <li class="list-group-item">Second item</li>
  <li class="list-group-item">Third item</li>
</ul> 
    `
  ,
  'component_group': 'pro'
});



CcPageElement.addComponentItem({
  'item_name': 'panels',
  'item_preview': '<i class="fa fa-align-justify "></i> panels',
  'item_content': `
    <div class="panel panel-default">
  <div class="panel-body">A Basic Panel</div>
</div>
    `
  ,
  'component_group': 'pro'
});

CcPageElement.addComponentItem({
  'item_name': 'nav_bar',
  'item_preview': '<i class="fa fa-puzzle-piece "></i> nav bar',
  'item_content': `
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>
    `
  ,
  'component_group': 'pro'
});

CcPageElement.addComponentItem({
  'item_name': 'carousel',
  'item_preview': '<i class="fa fa-file-image-o "></i> carousel',
  'item_content': `
     <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="https://www.w3schools.com/bootstrap/la.jpg" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="https://www.w3schools.com/bootstrap/chicago.jpg" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="https://www.w3schools.com/bootstrap/ny.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
    `
  ,
  'component_group': 'pro'
});



CcPageElement.addComponentItem({
  'item_name': 'divider',
  'item_preview': '<i class="fa fa-arrows-h "></i> divider',
  'item_content': `
     <div style="padding:20px;height:50px"></div>
    `
  ,
  'component_group': 'pro'
});

CcPageElement.addComponentItem({
  'item_name': 'map',
  'item_preview': '<i class="fa fa-map-o "></i> map',
  'item_content': `
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d32658807.74081098!2d99.45163012035025!3d-2.2759844414009986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4c07d7496404b7%3A0xe37b4de71badf485!2sIndonesia!5e0!3m2!1sen!2sid!4v1589807515222!5m2!1sen!2sid" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    `,
  'component_group': 'pro'
});
CcPageElement.addComponentItem({
  'item_name': 'accordion',
  'item_preview': '<i class="fa  fa-server "></i> accordion',
  'item_content': `
         
<h2>Accordion Example</h2>
  <p><strong>Note:</strong> The <strong>data-parent</strong> attribute makes sure that all collapsible elements under the specified parent will be closed when one of the collapsible item is shown.</p>
  <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Collapsible Group 1</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Collapsible Group 2</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Collapsible Group 3</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
  </div> 
</div>
    `,
  'component_group': 'pro'
});




CcPageElement.addComponentItem({
  'item_name': 'galery',
  'item_preview': '<i class="fa   fa-puzzle-piece "></i> galery',
  'item_content': `
            
  <style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 180px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}
</style>
</head>
<body>

<div class="gallery">
  <a target="_blank" href="img_5terre.jpg">
    <img src="https://www.w3schools.com/css/img_5terre.jpg" alt="Cinque Terre" width="600" height="400">
  </a>
  <div class="desc">Add a description of the image here</div>
</div>

<div class="gallery">
  <a target="_blank" href="img_forest.jpg">
    <img src="https://www.w3schools.com/css/img_forest.jpg" alt="Forest" width="600" height="400">
  </a>
  <div class="desc">Add a description of the image here</div>
</div>

<div class="gallery">
  <a target="_blank" href="img_lights.jpg">
    <img src="https://www.w3schools.com/css/img_lights.jpg" alt="Northern Lights" width="600" height="400">
  </a>
  <div class="desc">Add a description of the image here</div>
</div>

<div class="gallery">
  <a target="_blank" href="img_mountains.jpg">
    <img src="https://www.w3schools.com/css/img_mountains.jpg" alt="Mountains" width="600" height="400">
  </a>
  <div class="desc">Add a description of the image here</div>
</div>
    `,
  'component_group': 'pro'
});



CcPageElement.addTab({
  'li_class': '',
  'a_class': 'active btn-form-preview btn_show_tab_attribute ',
  'a_href': '#tab_map',
  'i_class': 'fa fa-tag text-black',
  'tab_label': 'Attribute',
});


CcPageElement.addField({
  'field_name': 'map_src',
  'field_content': '<div class="col-md-12 padding-left-0 padding-right-0 style-type">' +
    'Source :' +
    '<input type="text" class="pull-right" name="map_src" id="map_src">' +
    '</div>',
  'tab_group': 'tab_map',
  'selector_accepted': 'iframe',
  'onTargetClick': function (field, target) {
    field.val(target.attr('src'));
  },
  'onSave': function (field, target) {
    target.css('src', field.val());
  }
});