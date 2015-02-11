<?php

include('../app/bootstrap.php');

/**
 * Include the Realm Bootstrap
 */

include('bootstrap.php');

$req = new \flow\controllers\admin\FrontController();
$req->Init();
$req->Execute();
