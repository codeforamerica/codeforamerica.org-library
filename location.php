<!DOCTYPE html>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $location_name = $context->path_info();
    
    if($location_name) {
        $title = "Library Items In {$location_name}";
    
    } else {
        $title = "Library Locations";
    }

?>
<html lang="en-us">

<? include 'includes/head.php' ?>
    
<body>

<div class="js-container">

<? include 'includes/header.php' ?>

<main role="main">
<div class="layout-semibreve">

    <nav class="nav-breadcrumbs" role="navigation">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="<?= $context->base() ?>/">Library</a></li>
        </ul>
    </nav>
	
    <? if($location_name) { ?>
        <header>
            <h2>Items In <?= html($location_name) ?></h2>
        </header>

        <ul class="teasers">
            <? foreach(get_location_items($context, $location_name) as $item) { ?>
                <li class="layout-crotchet"><?= item_anchor($context, $item) ?></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>Locations</h2>
        </header>
        
        <?
            $locations = get_locations($context);

            // Render three columns.
            $c = count($locations) / 3;
            $locations_1 = array_slice($locations, 0, floor($c));
            $locations_2 = array_slice($locations, floor($c), floor(2*$c) - floor($c));
            $locations_3 = array_slice($locations, floor(2 * $c));
        ?>
        <div class="layout-crotchet">
          <ul>
            <? foreach($locations_1 as $location) { ?>
              <li><?= location_anchor($context, $location) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($locations_2 as $location) { ?>
              <li><?= location_anchor($context, $location) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($locations_3 as $location) { ?>
              <li><?= location_anchor($context, $location) ?></li>
            <? } ?>
          </ul>
        </div>
    <? } ?>
    
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<? include 'includes/footer-scripts.php' ?>
</body>
</html>
