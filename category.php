<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $cat_name = $context->path_info();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<? if($cat_name) { ?>
    <h1>Items In Category <q><?= html($cat_name) ?></q></h1>
    <ul>
        <? foreach(get_category_items($context, $cat_name) as $item) { ?>
            <li><a href="<?= $context->base() ?>/item/<?= enc($item['id']) ?>"><?= html($item['title']) ?></a></li>
        <? } ?>
    </ul>
<? } else { ?>
    <h1>Categories</h1>
    <ul>
        <? foreach(get_categories($context) as $category) { ?>
            <li><a href="<?= category_href($context, $category) ?>"><?= html($category) ?></a></li>
        <? } ?>
    </ul>
<? } ?>
</body>
</html>
