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


interface iStorageProvider {

    /**
     *
     *
     * @param string  $name
     */
    public function group($name);


    /**
     *
     */
    public function groups();

    /**
     *
     *
     * @param string  $group
     */
    public function files($group);

    /**
     *
     *
     * @param string  $group
     */
    public function assets($group);

    /**
     *
     *
     * @param string  $name
     */
    public function createGroup($name);

    /**
     *
     *
     * @param string  $name
     */
    public function removeGroup($name);

    /**
     *
     *
     * @param string  $name
     * @param string  $text
     */
    public function saveFile($name, $text);

    /**
     *
     *
     * @param string  $tempPath
     * @param string  $fileName
     */
    public function saveAsset($tempPath, $fileName);

    /**
     *
     *
     * @param string  $name
     */
    public function removeFile($name);

    /**
     *
     *
     * @param string  $name
     */
    public function text($name);
}


interface iFileServer {

    /**
     *
     *
     * @param string  $name
     * @param string  $docType
     */
    public function viewerUrl($name, $docType);

    /**
     *
     *
     * @param string  $name
     * @param string  $docType
     */
    public function editorUrl($name, $docType);
}
