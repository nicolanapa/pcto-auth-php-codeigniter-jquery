<?php
$stylesheets ??= [];
$scripts ??= [];

array_unshift($stylesheets, "navBar.css");
array_unshift($stylesheets, "styles.css");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <?php for ($i = 0; $i < count($stylesheets); $i++) { ?>
        <link rel="stylesheet" href="<?= base_url("./styles/" . $stylesheets[$i]) ?>" />
    <?php } ?>

    <?php for ($i = 0; $i < count($scripts); $i++) { ?>
        <script type="module" src="<?= base_url("./scripts/" . $scripts[$i]) ?>" defer>
        </script>
    <?php } ?>
</head>

<body>
    <?= view("partials/navBar") ?>
    <main>