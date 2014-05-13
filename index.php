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
	
    <h2>Library <i>(Alpha)</i></h2>
    
    <p>Welcome to Code for America's resource library, version 0.5. You'll find many videos, how-to guides, and other documents, categorized by topic. </p>
    <p><strong>You can add to the library!</strong> We want to add your slide decks, videos, documentation, and other useful materials! To be included, a resource should be relevant to the Code for America community (e.g. related to topics of civic technology and innovation) and evergreen (e.g. it will still be useful in 2+ years). <a href="https://codeforamerica.wufoo.com/forms/library-submission-form/">Submit your resources here.</a></p>
    
    <div class="layout-minim">
        <h3>Categories</h3>
        <ul>
            <? foreach(get_categories($context) as $category) { ?>
                <li><?= category_anchor($context, $category) ?></li>
            <? } ?>
        </ul>
    </div>

    <div class="layout-minim">
        <h3>Tags</h3>
        <ul>
            <? foreach(get_tags($context) as $tag) { ?>
                <li><?= tag_anchor($context, $tag) ?></li>
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
