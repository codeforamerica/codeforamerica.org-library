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

        <ul class="teasers">
            <? foreach(get_category_items($context, $cat_name) as $item) { ?>
                <li class="layout-crotchet"><?= item_anchor($context, $item) ?></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>Categories</h2>
        </header>
        
        <?
            $categories = get_categories($context);

            // Render three columns.
            $c = count($categories) / 3;
            $categories_1 = array_slice($categories, 0, floor($c));
            $categories_2 = array_slice($categories, floor($c), floor(2*$c) - floor($c));
            $categories_3 = array_slice($categories, floor(2 * $c));
        ?>
        <div class="layout-crotchet">
          <ul>
            <? foreach($categories_1 as $category) { ?>
              <li><?= category_anchor($context, $category) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($categories_2 as $category) { ?>
              <li><?= category_anchor($context, $category) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($categories_3 as $category) { ?>
              <li><?= category_anchor($context, $category) ?></li>
            <? } ?>
          </ul>
        </div>
    <? } ?>
    
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/script/global.js"></script>

</body>
</html>
