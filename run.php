<?php

/*****************************************************
 * Load dependencies.
 */
$autoloadPath = __DIR__ . "/vendor/autoload.php";
if (!file_exists($autoloadPath)) {
    throw new Exception("Dependencies are not installed in '$autoloadPath'. Please run 'composer install' by executing 'bin/composer.sh'");
}

require_once($autoloadPath);

/*****************************************************
 * Delegate all the things to the application code.
 */

$parameters = array_slice($argv, 1);

$app = new Application\Application();
$app->run($parameters);
