<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $location_name = $context->path_info();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<? if($location_name) { ?>
    <h1>Items In Location <q><?= htmlspecialchars($location_name) ?></q></h1>
    <ul>
        <? foreach(get_location_items($context, $location_name) as $item) { ?>
            <li><a href="<?= $context->base() ?>/item/<?= urlencode($item['id']) ?>"><?= htmlspecialchars($item['title']) ?></a></li>
        <? } ?>
    </ul>
<? } else { ?>
    <h1>Locations</h1>
    <ul>
        <? foreach(get_locations($context) as $location) { ?>
            <li><a href="<?= $context->base() ?>/location/<?= urlencode($location) ?>"><?= htmlspecialchars($location) ?></a></li>
        <? } ?>
    </ul>
<? } ?>
</body>
</html>
