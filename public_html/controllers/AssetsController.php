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
     * @param string  $file
     */
    public function index($group, $file = NULL)
    {
        // Save data if passed up
        // Always show image again
        if (!empty($file)) {
            $filePath = Config::storage($group)->assetFilePath($file);
            error_log("getting file path: $filePath");

            if (file_exists($filePath)) {
                //header('Content-Description: File Transfer');
                header('Content-Type: ' . mime_content_type($filePath));
                //header('Content-Disposition: attachment; filename="' . ltrim(basename($filePath), "_") . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));
                readfile($filePath);
                exit;
            }
        }

        // Just show the upload page
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
            // Get the number of files passed up
            $count = count($_FILES["fileInput"]["error"]);

            // Process each file
            for ($i = 0; $i < $count; $i++) {
                if ($_FILES["fileInput"]["error"][$i] > 0) {
                    $error = $this->fileErrorCodeToMessage($_FILES["fileInput"]["error"][$i]);
                }
                else {
                    $fileName = $_FILES["fileInput"]["name"][$i];
                    $tempPath = $_FILES["fileInput"]["tmp_name"][$i];

                    $error = Config::storage($group)->saveAsset($tempPath, $fileName);
                }
            }

            if (!empty($error)) {
                error_log("error saving asset: $error");
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


    /**
     *
     *
     * @param string  $code
     * @return
     */
    private function fileErrorCodeToMessage($code)
    {
        switch ($code) {
        case UPLOAD_ERR_INI_SIZE:
            $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            break;
        case UPLOAD_ERR_PARTIAL:
            $message = "The uploaded file was only partially uploaded";
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = "No file was uploaded";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $message = "Missing a temporary folder";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $message = "Failed to write file to disk";
            break;
        case UPLOAD_ERR_EXTENSION:
            $message = "File upload stopped by extension";
            break;

        default:
            $message = "Unknown upload error";
            break;
        }
        return $message;
    }


}
