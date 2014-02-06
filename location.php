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

        <ul>
            <? foreach(get_location_items($context, $location_name) as $item) { ?>
                <li><a href="<?= $context->base() ?>/item/<?= enc($item['id']) ?>"><?= html($item['title']) ?></a></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>Locations</h2>
        </header>

        <ul>
            <? foreach(get_locations($context) as $location) { ?>
                <li><a href="<?= location_href($context, $location) ?>"><?= html($location) ?></a></li>
            <? } ?>
        </ul>
    <? } ?>
    
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/script/global.js"></script>

</body>
</html>
