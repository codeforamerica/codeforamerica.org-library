<!DOCTYPE html>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $cat_name = $context->path_info();
    
    if($cat_name) {
        $title = "Library Items In Category “{$cat_name}”";
    
    } else {
        $title = "Library Categories";
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
	
    <? if($cat_name) { ?>
        <header>
            <h2>Items In Category <q><?= html($cat_name) ?></q></h2>
        </header>

        <ul>
            <? foreach(get_category_items($context, $cat_name) as $item) { ?>
                <li><a href="<?= $context->base() ?>/item/<?= enc($item['id']) ?>"><?= html($item['title']) ?></a></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>Categories</h2>
        </header>

        <ul>
            <? foreach(get_categories($context) as $category) { ?>
                <li><a href="<?= category_href($context, $category) ?>"><?= html($category) ?></a></li>
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
