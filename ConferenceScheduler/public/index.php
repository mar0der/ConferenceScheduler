<?php
error_reporting(E_ALL ^ E_NOTICE);

require '../../MVC/App.php';
$app = \My\Mvc\App::getInstance();
$app->run();

