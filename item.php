<!DOCTYPE html>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $item_name = $context->path_info();
    $item = get_item($context, $item_name);
    $title = $item ? $item['title'] : '';

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
	
    <? if($item) { ?>
        <div class="heading">
            <h2><?= html($item['title']) ?></h2>
        </div>
    
        <div class="layout-minor">
            <p>
                <a href="<?= category_href($context, $item['category']) ?>"><?= html($item['category']) ?></a>
            </p>

            <? if(!empty($item['tags'])) { ?>
              <h4 class="text-whisper layout-tight">Tags</h4>
              <p>
                <? foreach($item['tags'] as $tag) { ?>
                    <a href="<?= tag_href($context, $tag) ?>"><?= html($tag) ?></a>,
                <? } ?>
              </p>
            <? } ?>
        
            <? if(!empty($item['programs'])) { ?>
              <h4 class="text-whisper layout-tight">Programs</h4>
              <p>
                <? foreach($item['programs'] as $program) { ?>
                    <a href="<?= program_href($context, $program) ?>"><?= html($program) ?></a>,
                <? } ?>
              </p>
            <? } ?>
        
            <? if(!empty($item['locations'])) { ?>
              <h4 class="text-whisper layout-tight">Locations</h4>
              <p>
                <? foreach($item['locations'] as $location) { ?>
                    <a href="<?= location_href($context, $location) ?>"><?= html($location) ?></a>,
                <? } ?>
              </p>
            <? } ?>
        
            <? if(!empty($item['date'])) { ?>
              <h4 class="text-whisper layout-tight">Date</h4>
              <ul class="list-no-bullets text-whisper link-invert">
                <li><?= html($item['date']) ?></li>
              </ul>
            <? } ?>
        
        </div>
    
        <div class="layout-major">
            <dl>
                <dt>ID</dt>
                <dd><?= html($item['id']) ?></dd>
                <dt>Link</dt>
                <dd><a href="<?= html($item['link']) ?>"><?= html($item['link']) ?></a></dd>
                <dt>Format</dt>
                <dd><?= html($item['format']) ?></dd>
            </dl>
        </div>
    <? } ?>
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/script/global.js"></script>

</body>
</html>
