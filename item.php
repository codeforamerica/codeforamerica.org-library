<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $item_id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<? if($item = get_item($context, $item_id)) { ?>
    <dl>
        <? foreach($item as $k => $v) { ?>
            <dt><?= htmlspecialchars($k) ?></dt>
            <dd><?= htmlspecialchars($v) ?></dd>
        <? } ?>
    </dl>
<? } ?>
</body>
</html>
