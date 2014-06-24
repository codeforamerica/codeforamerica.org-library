<?php
    
    require_once 'lib.php';
    $context = new Context('data.db');
    $title = 'Sample Page';

?>
<!DOCTYPE html>
<html lang="en-us">
<? include 'includes/head.php' ?>
<body>
<div class="js-container">
<? include 'includes/header.php' ?>
<main role="main">
<div class="layout-semibreve">
    <? include 'includes/header-breadcrumbs.php' ?>
    <!--
    
    Start editing here...
    
    -->
	
    <header>
        <h2><?= html($title) ?></h2>
    </header>
    
    <p>
    Biodiesel fixie actually blog, cray authentic organic. Organic chia mustache gastropub street art. Biodiesel chillwave photo booth Intelligentsia art party meh. Semiotics forage Schlitz, you probably haven't heard of them organic vegan fingerstache meh locavore bicycle rights aesthetic DIY mlkshk craft beer. Paleo lo-fi salvia Godard. Tofu Shoreditch brunch, kitsch Austin pickled Etsy. Umami sustainable drinking vinegar, yr ugh Thundercats lo-fi DIY keffiyeh Odd Future Wes Anderson Austin roof party ethical.
    </p>

    <p>
    Quinoa Cosby sweater cray Tumblr, Pitchfork leggings PBR&B direct trade viral pickled sartorial raw denim chillwave. Vinyl ennui butcher small batch dreamcatcher church-key four loko, keytar banh mi mixtape street art tofu lomo. Master cleanse brunch photo booth Williamsburg, irony flexitarian biodiesel Austin. Pug 8-bit vegan squid polaroid Carles. Banh mi single-origin coffee polaroid Pitchfork four loko. Photo booth biodiesel chia DIY. Asymmetrical messenger bag DIY sriracha polaroid Godard vegan.
    </p>

    <p>
    Pinterest master cleanse Brooklyn actually +1. Banksy 3 wolf moon hashtag chia lo-fi vegan. Farm-to-table Marfa Intelligentsia artisan mustache, YOLO craft beer Echo Park letterpress retro. Trust fund 3 wolf moon PBR Neutra. Raw denim +1 post-ironic paleo ugh. Chambray cornhole bitters church-key farm-to-table. Meh blog Schlitz iPhone hella.
    </p>

    <p>
    Pop-up sriracha Thundercats, locavore try-hard hella Godard tattooed swag before they sold out Etsy mumblecore hoodie High Life small batch. Twee plaid trust fund, lo-fi tattooed try-hard sartorial food truck direct trade 90's. Food truck swag letterpress single-origin coffee banh mi. Farm-to-table typewriter salvia, ethnic chillwave Echo Park fashion axe skateboard polaroid +1 biodiesel forage Cosby sweater deep v dreamcatcher. Distillery squid +1, stumptown artisan Tumblr Bushwick. Pop-up before they sold out distillery, master cleanse mustache vegan Carles polaroid. Lomo meggings ennui mumblecore, ethical 90's pour-over narwhal.
    </p>

    <!--
    
    ...finish editing here.
    
    -->
</div>
<? include 'includes/footer.php' ?>
</main>
</div><!-- /.js-container -->
<? include 'includes/footer-scripts.php' ?>
</body>
</html>
