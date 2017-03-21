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

class EditController extends FileControllerBase {

    /**
     *
     *
     * @param string  $group
     * @param string  $file  (optional)
     */
    public function index($group, $file)
    {
        // Save data if passed up
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = $_POST['content'];
            $error = Config::storage($group)->saveFile($file, $content);

            if (!empty($error)) {
                $this->view = '/admin/error.php';
                $this->master = '/threePanel.php';
                $this->message = $error;
                $this->level = ErrorLevel::Error;
                $this->redirect = BASE_PATH . "/";
            }
            else {
                $this->view = '/api/redirect.php';
                $this->master = '/empty.php';
                //$this->redirect = BASE_PATH . "/files/$group";
                $this->redirect = $_SERVER["HTTP_REFERER"];
            }
        }
        else {
            // Always show data again
            $this->pageTitle = "edit $group: $file";
            $this->view = '/edit/md.php';
            $this->master = '/plain.php';
            $this->group = $group;
            $this->file = $file;

            // Get the text from the file
            $this->text = Config::storage($group)->text($file);

            // Get the list of files
            $this->assets = Config::storage($group)->assets($group);
        }

        $this->render();
    }


    /**
     *
     *
     * @param string  $group
     * @param string  $file
     */
    public function text($group, $file)
    {
        $this->pageTitle = "edit $group: $file";
        $this->view = '/edit/text.php';
        $this->master = '/plain.php';
        $this->group = $group;
        $this->file = $file;

        // Get the text from the file
        $this->text = Config::storage($group)->text($file);

        $this->render();
    }


}
