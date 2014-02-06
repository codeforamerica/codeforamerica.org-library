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
    <h1><?= htmlspecialchars($item['title']) ?></h1>
    <dl>
        <dt>ID</dt>
        <dd><?= htmlspecialchars($item['id']) ?></dd>
        <dt>Category</dt>
        <dd><a href="<?= $context->base() ?>/category/<?= urlencode($item['category']) ?>"><?= htmlspecialchars($item['category']) ?></a></dd>
        <dt>Date</dt>
        <dd><?= htmlspecialchars($item['date']) ?></dd>
        <dt>Program</dt>
        <dd><?= htmlspecialchars($item['program']) ?></dd>
        <dt>Location</dt>
        <dd><?= htmlspecialchars($item['location']) ?></dd>
        <dt>Link</dt>
        <dd><a href="<?= htmlspecialchars($item['link']) ?>"><?= htmlspecialchars($item['link']) ?></a></dd>
        <dt>Format</dt>
        <dd><?= htmlspecialchars($item['format']) ?></dd>
        <dt>Tags</dt>
        <dd>
            <ul>
            <? foreach($item['tags'] as $tag) { ?>
                <li><a href="<?= $context->base() ?>/tag/<?= urlencode($tag) ?>"><?= htmlspecialchars($tag) ?></a></li>
            <? } ?>
            </ul>
        </dd>
    </dl>
<? } ?>
</body>
</html>
