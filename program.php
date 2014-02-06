<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $program_name = $context->path_info();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<? if($program_name) { ?>
    <h1>Items In Program <q><?= htmlspecialchars($program_name) ?></q></h1>
    <ul>
        <? foreach(get_program_items($context, $program_name) as $item) { ?>
            <li><a href="<?= $context->base() ?>/item/<?= urlencode($item['id']) ?>"><?= htmlspecialchars($item['title']) ?></a></li>
        <? } ?>
    </ul>
<? } else { ?>
    <h1>Programs</h1>
    <ul>
        <? foreach(get_programs($context) as $program) { ?>
            <li><a href="<?= $context->base() ?>/program/<?= urlencode($program) ?>"><?= htmlspecialchars($program) ?></a></li>
        <? } ?>
    </ul>
<? } ?>
</body>
</html>
