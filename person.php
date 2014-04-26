<!DOCTYPE html>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $person_name = $context->path_info();
    
    if($person_name) {
        $title = "Library Items With {$person_name}";
    
    } else {
        $title = "Library People";
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
	
    <? if($person_name) { ?>
        <header>
            <h2>Items With <?= html($person_name) ?></h2>
        </header>

        <ul class="teasers">
            <? foreach(get_person_items($context, $person_name) as $item) { ?>
                <li class="layout-crotchet"><?= item_anchor($context, $item) ?></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <header>
            <h2>People</h2>
        </header>
        
        <?
            $people = get_people($context);

            // Render three columns.
            $c = count($people) / 3;
            $people_1 = array_slice($people, 0, floor($c));
            $people_2 = array_slice($people, floor($c), floor(2*$c) - floor($c));
            $people_3 = array_slice($people, floor(2 * $c));
        ?>
        <div class="layout-crotchet">
          <ul>
            <? foreach($people_1 as $person) { ?>
              <li><?= person_anchor($context, $person) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($people_2 as $person) { ?>
              <li><?= person_anchor($context, $person) ?></li>
            <? } ?>
          </ul>
        </div>
        <div class="layout-crotchet">
          <ul>
            <? foreach($people_3 as $person) { ?>
              <li><?= person_anchor($context, $person) ?></li>
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
