<?php

    require_once 'lib.php';
    $context = new Context('data.db');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<h2>Categories</h2>
<ul>
    <? foreach(get_categories($context) as $category) { ?>
        <li><a href="<?= category_href($context, $category) ?>"><?= html($category) ?></a></li>
    <? } ?>
</ul>
<h2>Tags</h2>
<ul>
    <? foreach(get_tags($context) as $tag) { ?>
        <li><a href="<?= tag_href($context, $tag) ?>"><?= html($tag) ?></a></li>
    <? } ?>
</ul>
</body>
</html>
