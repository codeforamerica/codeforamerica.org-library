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

    <? include 'includes/header-breadcrumbs.php' ?>
	
    <h2>Library <i>(Alpha)</i></h2>
    
    <h4>Find videos, how-to guides, and other resources about digital government and civic innovation.</h4>
    <p>Over the years, Code for America has produced a lot of content about using data, design, and technology to solve civic problems and provide better government services to citizens. In this library, you can browse these resources by category or by civic issues.</p>
    <p>Have something to add? <a href="https://codeforamerica.wufoo.com/forms/library-submission-form/">Submit</a> your own slide decks, videos, documentation, and other useful materials to be included in the Code for America Library.</p>
    
    <div class="layout-minim">
        <h3>Categories</h3>
        <ul>
            <? foreach(get_categories($context) as $category) { ?>
                <li><?= category_anchor($context, $category) ?></li>
            <? } ?>
        </ul>
    </div>

    <div class="layout-minim">
        <h3>Civic Issue Tags</h3>
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
<? include 'includes/footer-scripts.php' ?>
</body>
</html>
