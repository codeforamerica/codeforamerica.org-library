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
<ul>
    <? foreach(get_categories($context) as $category) { ?>
        <li><a href="<?= $context->base() ?>/category/<?= urlencode($category) ?>"><?= htmlspecialchars($category) ?></a></li>
    <? } ?>
</ul>
</body>
</html>
