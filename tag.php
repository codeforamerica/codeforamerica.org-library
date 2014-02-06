<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $tag_name = $context->path_info();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<? if($tag_name) { ?>
    <h1>Items Tagged <q><?= html($tag_name) ?></q></h1>
    <ul>
        <? foreach(get_tag_items($context, $tag_name) as $item) { ?>
            <li><a href="<?= $context->base() ?>/item/<?= enc($item['id']) ?>"><?= html($item['title']) ?></a></li>
        <? } ?>
    </ul>
<? } else { ?>
    <h1>Tags</h1>
    <ul>
        <? foreach(get_tags($context) as $tag) { ?>
            <li><a href="<?= $context->base() ?>/tag/<?= enc($tag) ?>"><?= html($tag) ?></a></li>
        <? } ?>
    </ul>
<? } ?>
</body>
</html>
