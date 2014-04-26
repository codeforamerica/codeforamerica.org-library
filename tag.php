<!DOCTYPE html>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $tag_name = $context->path_info();
    
    if($tag_name) {
        $title = "Library Items Tagged “{$tag_name}”";
    
    } else {
        $title = "Library Tags";
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
	
    <? if($tag_name) { ?>
        <header>
            <h2>Items Tagged <q><?= html($tag_name) ?></q></h2>
        </header>

        <ul class="teasers">
            <? foreach(get_tag_items($context, $tag_name) as $item) { ?>
                <li class="layout-crotchet"><?= item_anchor($context, $item) ?></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>Tags</h2>
        </header>
        
        <?
            $tags = get_tags($context);

            // Render three columns.
            $c = count($tags) / 3;
            $tags_1 = array_slice($tags, 0, floor($c));
            $tags_2 = array_slice($tags, floor($c), floor(2*$c) - floor($c));
            $tags_3 = array_slice($tags, floor(2 * $c));
        ?>
        <div class="layout-crotchet">
          <ul>
            <? foreach($tags_1 as $tag) { ?>
              <li><?= tag_anchor($context, $tag) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($tags_2 as $tag) { ?>
              <li><?= tag_anchor($context, $tag) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($tags_3 as $tag) { ?>
              <li><?= tag_anchor($context, $tag) ?></li>
            <? } ?>
          </ul>
        </div>
    <? } ?>
    
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/1/script/global.js"></script>

</body>
</html>
