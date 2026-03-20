<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<?php require_once "Template.php"; ?>

<?php ob_start(); ?>

<h1>Petit Dejeuner</h1>


<?php $content=ob_get_clean() ?>


<?php Template::render($content) ?>