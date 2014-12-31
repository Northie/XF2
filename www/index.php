<?php

$t1 = microtime(true);

/**
 * Include the application Bootstrap
 */

include('../app/bootstrap.php');

/**
 * Include the Realm Bootstrap
 */

include('bootstrap.php');

//Create a Request object...
$req = new \flow\controllers\web\FrontController();

//...and start it off
$req->Init();
$req->Execute();

//interesting stuff
$t2 = microtime(true);
$t = $t2 - $t1;
var_dump(memory_get_peak_usage(true) / (1024 * 1024));
var_dump(($t * 1000) . ' ms');
