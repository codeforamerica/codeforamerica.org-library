<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $cat_name = $_GET['name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<ul>
    <? foreach(get_category_items($context, $cat_name) as $item) { ?>
        <li><a href="item.php?id=<?= urlencode($item['id']) ?>"><?= htmlspecialchars($item['title']) ?></a></li>
    <? } ?>
</ul>
</body>
</html>
