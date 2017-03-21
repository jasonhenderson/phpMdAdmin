<?php
/**
 * This file is part of phpMdAdmin.
 *
 *  phpMdAdmin is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  phpMdAdmin is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package phpMdAdmin
 */


// load up your config file
require_once RESOURCES_PATH . "/config.php";

// This creates the $controller object we need throughout layout
//require_once PUBLIC_PATH . "/routes.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo $controller->pageTitle?>
        </title>
        <link rel="shortcut icon" href="<?php echo BASE_PATH?>/public_html/assets/markdown-favicon-clear.ico" type="image/ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH?>/public_html/css/phpmdadmin.css">
    </head>

    <body>
        <div class="header">
            <?php require_once TEMPLATES_PATH . "/header.php"; ?>
        </div>
        <div class="container-fluid body-content pull-left">
            <!-- content -->
            <?php $controller->renderView(); ?>
        </div>
        <div class="right clearfix">
            <?php require_once TEMPLATES_PATH . "/rightPanel.php"; ?>
        </div>
        <div class="footer navbar-fixed-bottom">
            <?php require_once TEMPLATES_PATH . "/footer.php"; ?>
        </div>
    <body>
<html>
