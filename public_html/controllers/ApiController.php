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


require_once CONTROLLERS_PATH . '/ControllerBase.php';

class ApiController extends ControllerBase {

    /**
     *
     */
    public function createGroup()
    {
        $this->view = '/api/redirect.php';
        $this->master = '/empty.php';

        if (!empty($_POST["groupName"])) {

            $error = Config::storage()->createGroup($_POST["groupName"]);

            if (!empty($error)) {
                $this->view = '/admin/error.php';
                $this->master = '/threePanel.php';
                $this->message = $error;
                $this->level = ErrorLevel::Error;
            }

            $this->redirect = BASE_PATH . "/";
            $this->data = [
            'status' => '0',
            'message' => 'Group successfully added.'
            ];
        }
        else {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "You must provide a group name to add the group";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/";
        }

        $this->render();
    }


    /**
     *
     *
     * @param string  $group
     */
    public function removeGroup($group)
    {
        $this->view = '/api/redirect.php';
        $this->master = '/empty.php';

        if (!empty($group)) {

            $error = Config::storage()->removeGroup($group);

            if (!empty($error)) {
                $this->view = '/admin/error.php';
                $this->master = '/threePanel.php';
                $this->message = $error;
                $this->level = ErrorLevel::Error;
                $this->redirect = BASE_PATH . "/";
            }

            $this->data = [
            'status' => '0',
            'message' => 'Group successfully added.'
            ];
        }
        else {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "You must provide a group name to remove the group";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/";
        }

        $this->render();
    }


    /**
     *
     */
    public function createFile()
    {
        if (!empty($_POST["groupName"]) &&
            !empty($_POST["fileName"])) {

            $this->view = '/api/redirect.php';
            $this->master = '/empty.php';
            $this->redirect = BASE_PATH . '/files/' . $_POST["groupName"];

            $error = Config::storage($_POST["groupName"])->saveFile($_POST["fileName"]);

            if (!empty($error)) {
                $this->view = '/admin/error.php';
                $this->master = '/threePanel.php';
                $this->message = $error;
                $this->level = ErrorLevel::Error;
                $this->redirect = BASE_PATH . "/";
            }

            $this->data = [
            'status' => '0',
            'message' => 'File successfully added.'
            ];
        }
        else {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "You must provide a file name to add the file";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/files/" . $_POST["groupName"];
        }

        $this->render();
    }


    /**
     *
     *
     * @return
     * @param string  $group
     * @param string  $file
     */
    public function removeFile($group, $file)
    {
        if (empty($group)) {
            $error = "Group is required to remove the file";
        }
        elseif (empty($file)) {
            $error = "File name is required to remove the file";
        }
        else {
            $error = Config::storage($group)->removeFile($file);

            $this->data = [
            'status' => '0',
            'message' => 'File successfully removed.'
            ];
        }

        if (!empty($error)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = $error;
            $this->level = ErrorLevel::Error;
        }
        else {
            $this->view = '/api/redirect.php';
            $this->master = '/empty.php';
        }
        $this->redirect = BASE_PATH . "/files/" . $group;

        $this->render();
    }


}
