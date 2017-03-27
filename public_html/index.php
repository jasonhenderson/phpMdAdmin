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
    $config["base_path"] = empty(BASE_PATH) ? "/" : BASE_PATH;
    echo  $config["base_path"];
    $router = Router::parseConfig($config);
    $router->matchCurrentRequest();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
