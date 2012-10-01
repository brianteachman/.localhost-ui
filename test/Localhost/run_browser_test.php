<?php
require realpath(__DIR__.'/../../classes/Localhost/Manager.php');

$manager = new Localhost\Manager();
// $path = realpath('.');
// $path = realpath('/not/real/path');
$path = realpath(dirname(__DIR__)."/../");
$path = $manager->listDir($path);
// $path = $manager->readyResults($path);
if (!$path) {
    //die("Please, try again: {$path} is not real.");
}
?>
<html>
    <style>li { line-height: 140%; }</style>
<head>
</head>
<body>
    <h1>Today, we will be viewing: <small><?= $path ?></small></h1>
    <ol>
    <?php foreach ($path as $dir): ?>
        <!-- <li><?= $dir ?></li> -->
        <li><b><?= $dir["type"]  ?></b>: <em><?= $dir["name"] ?></em></li> 
    <?php endforeach; ?>
    </ol>
</body>
</html>
