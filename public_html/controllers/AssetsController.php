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


require_once CONTROLLERS_PATH . '/FileControllerBase.php';

class AssetsController extends FileControllerBase {

    /**
     *
     *
     * @param string  $group
     */
    public function index($group)
    {
        // Save data if passed up
        // Always show image again
        $this->pageTitle = "edit $group";
        $this->view = '/assets/upload.php';
        $this->master = '/threePanel.php';
        $this->group = $group;
        $this->render();
    }



    /**
     *
     *
     * @param string  $group
     */
    public function upload($group)
    {
        // Save data if passed up
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_FILES);

            // Get the number of files passed up
            $count = count($_FILES["fileInput"]["error"]);

            // Process each file
            for ($i = 0; $i < $count; $i++) {
                if ($_FILES["fileInput"]["error"][i] > 0) {
                    echo "Error: " . $_FILES["fileInput"]["error"][$i] . "<br>";
                }
                else {
                    $fileName = $_FILES["fileInput"]["name"][$i];
                    $tempPath = $_FILES["fileInput"]["tmp_name"][$i];
                }

                $error = Config::storage($group)->saveAsset($tempPath, $fileName);
            }


            if (!empty($error)) {
                // Return JSON error
            }
            else {
                // Return JSON success
            }
        }
        else {
            // Always show image again
            $this->pageTitle = "edit $group";
            $this->view = '/assets/upload.php';
            $this->master = '/threePanel.php';
            $this->group = $group;
            $this->render();
        }

    }


}
