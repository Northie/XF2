<?php

error_reporting(E_ALL &~ E_NOTICE);
session_start();
session_regenerate_id();

//set view path;
\settings\registry::Load()->set(['VIEW_PATH', 'WEB'], dirname(__FILE__) . "/views/");