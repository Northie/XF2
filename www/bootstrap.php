<?php
error_reporting(E_ALL &~ E_NOTICE);
session_start();
session_regenerate_id();

define('PROJECT_PATH',dirname(__FILE__));

\settings\registry::Load()->set('CONFIG_PATH',  realpath(PROJECT_PATH."/conf/"));