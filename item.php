<?php
    
    if(!file_exists('data.db'))
    {
        header('HTTP/1.1 500');
        exit(0);
    }
    
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

    <? include 'includes/header-breadcrumbs.php' ?>
	
    <? if($item) { ?>
        <div class="heading">
            <h2><?= html($item['title']) ?></h2>
        </div>
    
        <div class="layout-minor">
            <p>
                <?= category_anchor($context, $item) ?></a>
            </p>

            <? if(!empty($item['contributors'])) { ?>
              <h4 class="text-whisper layout-tight">Contributors</h4>
              <p>
                <?= anchor_list($context, 'person_anchor', $item['contributors']) ?>.
              </p>
            <? } ?>
        
            <? if(!empty($item['tags'])) { ?>
              <h4 class="text-whisper layout-tight">Tags</h4>
              <p>
                <?= anchor_list($context, 'tag_anchor', $item['tags']) ?>.
              </p>
            <? } ?>
        
            <? if(!empty($item['programs'])) { ?>
              <h4 class="text-whisper layout-tight">Programs</h4>
              <p>
                <?= anchor_list($context, 'program_anchor', $item['programs']) ?>.
              </p>
            <? } ?>
        
            <? if(!empty($item['locations'])) { ?>
              <h4 class="text-whisper layout-tight">Locations</h4>
              <p>
                <?= anchor_list($context, 'location_anchor', $item['locations']) ?>.
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
                <?= anchor_list($context, 'person_anchor', $item['contacts']) ?>.
              </p>
            <? } ?>
        
        </div>
    
        <div class="layout-major">
            <? if($item['format'] == 'Video') { ?>
                <?= embed_html($item) ?>
            <? } ?>
            
            <p>
                Link:
                <a href="<?= html($item['link']) ?>"><?= html($item['link']) ?></a>
            </p>
            
            <p><?= $item['content_htm'] ?></p>
        </div>
    <? } ?>
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<? include 'includes/footer-scripts.php' ?>
</body>
</html>
