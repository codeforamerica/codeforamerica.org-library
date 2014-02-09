<!DOCTYPE html>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $title = 'Library';

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
	
    <h2>Library</h2>
    
    <div class="layout-minim">
        <h3>Categories</h3>
        <ul>
            <? foreach(get_categories($context) as $category) { ?>
                <li><a href="<?= category_href($context, $category) ?>"><?= html($category) ?></a></li>
            <? } ?>
        </ul>
    </div>

    <div class="layout-minim">
        <h3>Tags</h3>
        <ul>
            <? foreach(get_tags($context) as $tag) { ?>
                <li><a href="<?= tag_href($context, $tag) ?>"><?= html($tag) ?></a></li>
            <? } ?>
        </ul>
    </div>
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/script/global.js"></script>

</body>
</html>
