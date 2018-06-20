<?php

use Application\CliApplication;


require ('./app/CliApplication.php');


$runApp = new CliApplication();

$runApp->entryPoint();
