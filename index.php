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
	
    <header>
        <h2>Library (Alpha)</h2>
    </header>
    <p>Welcome to Code for America's resource library, version 0.5. You'll find many videos, how-to guides, and other documents, categorized by topic. We'll be making everything prettier in late February and March.</p>

    <header>
        <h3>Categories</h3>
    </header>

    <ul>
        <? foreach(get_categories($context) as $category) { ?>
            <li><a href="<?= category_href($context, $category) ?>"><?= html($category) ?></a></li>
        <? } ?>
    </ul>

    <header>
        <h3>Tags</h3>
    </header>

    <ul>
        <? foreach(get_tags($context) as $tag) { ?>
            <li><a href="<?= tag_href($context, $tag) ?>"><?= html($tag) ?></a></li>
        <? } ?>
    </ul>
    
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/script/global.js"></script>

</body>
</html>
