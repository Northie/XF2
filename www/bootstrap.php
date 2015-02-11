<?php

error_reporting(E_ALL & ~ E_NOTICE);
session_start();
session_regenerate_id();

define('PROJECT_PATH', dirname(__FILE__));

\settings\registry::Load()->set('CONF_DIR', realpath(PROJECT_PATH . "/conf/"));
\settings\registry::Load()->set('ENVIRONMENT', 'DEVELOPMENT');
