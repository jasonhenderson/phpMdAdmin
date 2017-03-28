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


require_once LIBRARY_PATH . '/Interfaces.php';
require_once LIBRARY_PATH . '/Enums.php';

class FileStorageProvider implements iStorageProvider, iFileServer {

    public $dataRelDir;
    public $dataDir;
    public $groupName;

    /**
     *
     *
     * @param string  $group (optional)
     */
    public function __construct($group = null)
    {
        // Get the defaults from the environment
        $this->group($group);
    }


    /**
     *
     *
     * @param string  $group (optional)
     * @return
     */
    public function groups($group = NULL)
    {
        $groups = [];

        // Find the directories
        $directories = scandir($this->dataDir);

        // Loop through each directory and find the files
        foreach ($directories as $directory) {

            // If group has been specified, only process that group

            if (empty($group) || mb_strtolower($group) == mb_strtolower($directory)) {

                $groupDir = $this->dataDir . $directory;

                if (is_dir($groupDir) &&
                    !in_array($directory, array(".", ".."))) {

                    $groups[] = ["name" => $directory];
                }
            }
        }

        return $groups;
    }


    /**
     *
     *
     * @param string  $group (optional)
     * @return
     */
    public function files($group)
    {
        $files = [];

        // Group must be provided
        if (empty($group)) return $files;

        // Find the directories
        $directories = scandir($this->dataDir);

        // Loop through each directory and find the files
        foreach ($directories as $directory) {

            if (mb_strtolower($group) == mb_strtolower($directory)) {
                $groupDir = $this->dataDir . $directory;

                // If group has been specified, only process that group
                if (is_dir($groupDir) &&
                    !in_array($directory, array(".", ".."))) {

                    $items = scandir($groupDir);

                    // Only take files that are files not directories
                    foreach ($items as $item) {
                        $itemPath = $groupDir . "/" . $item;
                        if (is_file($itemPath) &&
                            !in_array($item, array(".", ".."))) {

                            $files[] = [
                            "group" => $directory,
                            "name" => $item];
                        }
                    }
                }
            }
        }

        return $files;
    }


    /**
     *
     *
     * @param string  $group
     * @return
     */
    public function assets($group)
    {
        $assets = [];

        // Group must be provided
        if (empty($group)) return $assets;

        // Find the directories
        $items = scandir($this->assetsDir());

        // Only take files that are files not directories
        foreach ($items as $item) {
            $itemPath = $this->assetsDir() . "/" . $item;
            if (is_file($itemPath) &&
                !in_array($item, array(".", ".."))) {

                $assets[] = [
                "group" => $group,
                "asset" => $item,
                "assetPath" => $this->assetsPath() . "/" . $item
                ];
            }
        }

        return $assets;
    }


    /**
     *
     *
     * @param string  $group
     * @return
     */
    public function createGroup($group)
    {
        // Set the group name and setup the paths
        $this->group = $group;
        // See if the folder exists, and if not, create it
        if (!file_exists($this->groupDir())) {
            error_log("making group directory: " . $this->group);
            mkdir($this->groupDir(), 0777, true);
        }
        else {
            return "Group already exists, so cannot create it";
        }
    }


    /**
     *
     *
     * @param string  $group
     * @return
     */
    public function removeGroup($group)
    {
        // Set the group name and setup the paths
        $this->group = $group;
        $groupDir = $this->groupDir();
        // See if the folder exists, and if not, create it
        if (!file_exists($groupDir)) {
            return "Group doesn't exist, so cannot remove it";
        }
        elseif (!$this->is_dir_empty($groupDir)) {
            return "There are files in the group. Remove the files first and try again";
        }
        else {
            // Do not remove recursively...if there are files, do not remove
            rmdir($groupDir);
            return NULL;
        }
    }


    /**
     *
     *
     * @param string  $dir
     * @return
     */
    function is_dir_empty($dir)
    {
        if (!is_readable($dir)) return NULL;
        return count(scandir($dir)) == 2;
    }


    /**
     *
     *
     * @param string  $target
     */
    function rmdir_r($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach ($files as $file) {
                rmdir_r($file);
            }

            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
    }


    /**
     *
     *
     * @param string  $file
     * @param string  $text
     * @return
     */
    public function saveFile($file, $text = "")
    {
        if (empty($file)) {
            return "You must provide a file name.";
        }

        $path = $this->filePath($file);
        $file = fopen($path, "w");
        fwrite($file, $text);
        fclose($file);

        return NULL;
    }


    /**
     *
     *
     * @param string  $tempPath
     * @param string  $fileName
     * @return
     */
    public function saveAsset($tempPath, $fileName)
    {
        if (empty($tempPath)) {
            return "You must provide the file data.";
        }
        elseif (empty($fileName)) {
            return "You must provide a file name.";
        }

        if (!file_exists($this->assetsDir())) {
            mkdir($this->assetsDir(), 0777, true);
        }

        $path = $this->assetFilePath($fileName);

        move_uploaded_file($tempPath, $path);

        return NULL;
    }



    /**
     *
     *
     * @param string  $file
     * @return
     */
    public function removeFile($file)
    {
        $path = $this->filePath($file);

        if (!file_exists($path)) {
            return "File doesn't exist, so cannot remove it";
        }
        else {
            unlink($path);
            return NULL;
        }
    }


    /**
     *
     *
     * @param string  $file
     * @return
     */
    public function text($file)
    {
        // Look for whatever was passed in
        $path = $this->filePath($file);

        // If it exists, open it
        if (!file_exists($path)) {
            $file = fopen($path, "w");
            fclose($file);
        }

        // Return anything, even null
        return file_get_contents($path);
    }


    /**
     *
     *
     * @return
     */
    private function groupDir()
    {
        return $this->dataDir . $this->group;
    }


    /**
     *
     *
     * @return
     */
    private function assetsDir()
    {
        return $this->dataDir . $this->group . "/assets";
    }


    /**
     *
     *
     * @return
     */
    private function assetsPath()
    {
        return $this->dataRelDir . $this->group . "/assets";
    }


    /**
     *
     *
     * @param string  $file
     * @return
     */
    public function filePath($file)
    {
        return $this->dataDir . $this->group . '/' . $file;
    }


    /**
     *
     *
     * @param string  $fileName
     * @return
     */
    public function assetFilePath($fileName)
    {
        return $this->dataDir . $this->group . '/assets/' . $fileName;
    }


    /**
     *
     *
     * @param string  $group
     * @param string  $file  (optional)
     * @return
     */
    public function viewerUrl($group, $file = DocType::Readme)
    {
        return 'view/' . $group . '/' . $file;
    }


    /**
     *
     *
     * @param string  $group
     * @param string  $file  (optional)
     * @return
     */
    public function editorUrl($group, $file = DocType::Readme)
    {
        return 'edit/' . $group . '/' . $file;
    }


    /**
     *
     *
     * @param string  $group (optional)
     * @return
     */
    public function group($group = null)
    {
        // Set the specific group
        if (!empty($group)) {
            $this->group = $group;
        }
        elseif (isset($_GET['id'])) {
            $this->group = $_GET['id'];
        }

        // If a title is provided, use it, otherwise default to file name
        if (!empty($this->group)) {
            $this->groupTitle = str_replace("-", " ", $this->group);
        }
        else {
            $this->groupTitle = 'View Markdown';
        }

        // Set the directories up
        $this->setDir();

        return $this;
    }


    /**
     *
     *
     * @param string  $dataRelDir (optional)
     */
    public function setDir($dataRelDir = '/data/')
    {
        // Set the base directory
        $this->dataRelDir = $dataRelDir;

        $dataDir = getenv("APP_DATAPATH");
        if (empty($dataDir)) {
            $dataDir = ROOT_PATH . $dataRelDir;
        }
        else {
            $dataDir = $dataDir . $dataRelDir;
        }

        $this->dataDir = $dataDir;

        error_log("data directory: $dataDir");
    }


}
