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


class ControllerBase
{
    protected $pageTitle = 'phpMdAdmin';
    protected $view = "NULL";

    /**
     *
     */
    protected function render()
    {
        if (!empty($this->master)) {
            $this->renderMaster();
        }
        else {
            $this->renderView();
        }
    }


    /**
     *
     */
    protected function renderView()
    {
        $controller = $this;
        if (!empty($this->view)) {
            require_once VIEWS_PATH . $this->view;
        }
    }


    /**
     *
     */
    protected function renderMaster()
    {
        $controller = $this;
        require_once TEMPLATES_PATH . $this->master;
    }


}
