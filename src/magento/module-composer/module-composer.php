<?php
// application.php

require __DIR__ . '/vendor/autoload.php';

use ModuleComposer\Command\UpdateModuleCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new UpdateModuleCommand());

$application->run();
