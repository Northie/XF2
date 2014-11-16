<?php

$t1 = microtime(true);
include('../app/bootstrap.php');
include('bootstrap.php');
$req = new \flow\controllers\web\FrontController();
$req->Init();
$req->Execute();
$t2 = microtime(true);
$t = $t2 - $t1;
var_dump(memory_get_peak_usage(true) / (1024 * 1024));
var_dump(($t * 1000) . ' ms');
