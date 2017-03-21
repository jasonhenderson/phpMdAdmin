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

class FileControllerBase extends ControllerBase
{
    protected $pageTitle = 'phpMdAdmin';
    protected $view = NULL;
    protected $fileExt = NULL;
    protected $fileName = NULL;
    protected $docType = NULL;
    protected $codeLang = NULL;

    /**
     *
     *
     * @param string  $fileName
     */
    protected function init($fileName)
    {
        if (empty($fileName)) return;

        $parts = pathinfo($fileName);
        $this->fileExt = $parts['extension'];
        $this->fileName = $parts['filename'];

        $this->master = '/plain.php';
    }


}
