<!DOCTYPE html>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $program_name = $context->path_info();
    
    if($program_name) {
        $title = "Library Items In {$program_name} Program";
    
    } else {
        $title = "Library Programs";
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
	
    <? if($program_name) { ?>
        <header>
            <h2>Items In <?= html($program_name) ?> Program</h2>
        </header>

        <ul class="teasers">
            <? foreach(get_program_items($context, $program_name) as $item) { ?>
                <li class="layout-crotchet"><?= item_anchor($context, $item) ?></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>Programs</h2>
        </header>

        <ul>
            <? foreach(get_programs($context) as $program) { ?>
                <li><?= program_anchor($context, $program) ?></li>
            <? } ?>
        </ul>
    <? } ?>
    
</div>
    
<? include 'includes/footer.php' ?>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/1/script/global.js"></script>

</body>
</html>
