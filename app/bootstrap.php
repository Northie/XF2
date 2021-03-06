<?php

define('XENECO_PATH',dirname(__FILE__));

include 'utils/traits/singleton.trait.php';
include 'settings/settings.trait.php';
include 'settings/filelist.settings.php';
include 'settings/general.trait.php';
include 'settings/general.settings.php';
include 'utils/autoload/fileFinder.class.php';
include 'utils/autoload/autoload.function.php';

 \settings\general::Load()->set(['XENECO','CONTEXT'], 'DEV');

\Plugins\Plugins::Load()->registerPlugins();