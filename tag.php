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

        <ul>
            <? foreach(get_tag_items($context, $tag_name) as $item) { ?>
                <li><a href="<?= item_href($context, $item) ?>"><?= html($item['title']) ?></a></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>Tags</h2>
        </header>

        <ul>
            <? foreach(get_tags($context) as $tag) { ?>
                <li><a href="<?= tag_href($context, $tag) ?>"><?= html($tag) ?></a></li>
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
