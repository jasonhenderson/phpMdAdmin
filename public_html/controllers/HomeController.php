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

class HomeController extends ControllerBase {

    /**
     *
     *
     * @return
     */
    public function index()
    {
        return $this->groups();
    }


    /**
     *
     */
    public function groups()
    {
        $this->pageTitle = 'phpMdAdmin groups';
        $this->view = '/home/groups.php';
        $this->master = '/threePanel.php';
        $this->heading = 'Groups';

        $this->groups = Config::storage()->groups();

        $this->render();
    }


    /**
     *
     *
     * @return
     * @param string  $group (optional)
     */
    public function files($group = NULL)
    {
        $this->pageTitle = 'phpMdAdmin files';
        $this->master = '/threePanel.php';

        if (!empty($group)) {
            $this->view = '/home/files.php';
            $this->files = Config::storage()->files($group);
            $this->group = $group;
            $this->heading = $group;
        }
        else {
            $this->view = "/admin/error.php";
            $this->message = "You must provide a group to see files";
            $this->level = ErrorLevel::Warning;
        }

        $this->render();
    }


}
