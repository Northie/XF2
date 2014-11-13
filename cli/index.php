#!/usr/bin/php
<?php
include('../app/bootstrap.php');

$req = new \flow\controllers\cli\FrontController();

$req->Execute();
