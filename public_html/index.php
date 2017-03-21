<?php
/**
 * /home/ubuntu/workspace/phpMdAdmin/public_html/index.php
 *
 * @package phpMdAdmin
 */


require_once '../resources/config.php';

require_once ROOT_PATH . '/vendor/autoload.php';

use PHPRouter\RouteCollection;
use PHPRouter\Config;
use PHPRouter\Router;
use PHPRouter\Route;

try {
    $config = Config::loadFromJsonFile(PUBLIC_PATH . '/routes.json');
    $router = Router::parseConfig($config);
    $router->matchCurrentRequest();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
