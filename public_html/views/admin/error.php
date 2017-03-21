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


require_once LIBRARY_PATH . '/Enums.php';

$errorClass = "";
switch ($controller->level) {
case ErrorLevel::Info:
    $errorClass = "info";
    break;
case ErrorLevel::Warning:
    $errorClass = "warning";
    break;
case ErrorLevel::Error:
    $errorClass = "danger";
    break;
case ErrorLevel::Success:
    $errorClass = "success";
    break;
default:
    $errorClass = "info";
    break;
}

// Make sure back button is provided, and if not, go home
$backButtonUrl = $controller->redirect;
if (empty($backButtonUrl)) {
    $backButtonUrl = BASE_PATH . "/";
}
?>

<div>
    <div class="alert alert-<?php echo $errorClass ?>" role="alert">
        <?php echo $controller->message;?>
    </div>
    <div>
        <a class="btn btn-primary" href="<?php echo $backButtonUrl?>" role="button">Go Back</a>
    </div>
</div>
