<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $item_id = $context->path_info();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<? if($item = get_item($context, $item_id)) { ?>
    <h1><?= html($item['title']) ?></h1>
    <dl>
        <dt>ID</dt>
        <dd><?= html($item['id']) ?></dd>
        <dt>Category</dt>
        <dd><a href="<?= $context->base() ?>/category/<?= enc($item['category']) ?>"><?= html($item['category']) ?></a></dd>
        <dt>Date</dt>
        <dd><?= html($item['date']) ?></dd>
        <dt>Program</dt>
        <dd><a href="<?= $context->base() ?>/program/<?= enc($item['program']) ?>"><?= html($item['program']) ?></a></dd>
        <dt>Link</dt>
        <dd><a href="<?= html($item['link']) ?>"><?= html($item['link']) ?></a></dd>
        <dt>Format</dt>
        <dd><?= html($item['format']) ?></dd>
        <dt>Locations</dt>
        <dd>
            <ul>
            <? foreach($item['locations'] as $location) { ?>
                <li><a href="<?= $context->base() ?>/location/<?= enc($location) ?>"><?= html($location) ?></a></li>
            <? } ?>
            </ul>
        </dd>
        <dt>Tags</dt>
        <dd>
            <ul>
            <? foreach($item['tags'] as $tag) { ?>
                <li><a href="<?= $context->base() ?>/tag/<?= enc($tag) ?>"><?= html($tag) ?></a></li>
            <? } ?>
            </ul>
        </dd>
    </dl>
<? } ?>
</body>
</html>
