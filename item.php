<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $item_name = $context->path_info();
    $item = get_item($context, $item_name);
    $title = $item ? $item['title'] : '';
    
    // Redirect to the slug version if possible.
    if($item['slug'] && $item_name != $item['slug'])
    {
        header('HTTP/1.1 301');
        header('Location: '.item_href($context, $item));
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en-us">

<? include 'includes/head.php' ?>
    
<body>

<style type="text/css">

   /*
    * CSS for scalable video player from http://stackoverflow.com/a/17465040
    */
    .video-embed
    {
      max-width: 100%;
      margin: 0px auto;
    }

    .video-embed > div
    {
      position: relative;
      padding-bottom: 75%; /* - aspect ratio */
      height: 0px;
    }

    .video-embed iframe
    {
      position: absolute;
      top: 0px;
      left: 0px;
      width: 100%;
      height: 100%;
    }

</style>

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

            <? if(!empty($item['contributors'])) { ?>
              <h4 class="text-whisper layout-tight">Contributors</h4>
              <p>
                <? foreach($item['contributors'] as $contributor) { ?>
                    <a href="<?= person_href($context, $contributor) ?>"><?= html($contributor['name']) ?></a>,
                <? } ?>
              </p>
            <? } ?>
        
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
        
            <? if(!empty($item['contacts'])) { ?>
              <h4 class="text-whisper layout-tight">Contacts</h4>
              <p>
                <? foreach($item['contacts'] as $contact) { ?>
                    <a href="<?= person_href($context, $contact) ?>"><?= html($contact['name']) ?></a>,
                <? } ?>
              </p>
            <? } ?>
        
        </div>
    
        <div class="layout-major">
            <? if($item['format'] == 'Video') { ?>
                <?= embed_html($item) ?>
            <? } ?>
        
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
