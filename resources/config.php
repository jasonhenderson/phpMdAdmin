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


defined("PUBLIC_PATH")
    or define("PUBLIC_PATH", realpath(dirname(__FILE__) . '/../public_html'));

defined("RESOURCES_PATH")
    or define("RESOURCES_PATH", realpath(dirname(__FILE__)));

defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("PLUGINS_PATH")
    or define("PLUGINS_PATH", realpath(dirname(__FILE__) . '/plugins'));

defined("CONTROLLERS_PATH")
    or define("CONTROLLERS_PATH", realpath(dirname(__FILE__) . '/../public_html/controllers'));

defined("VIEWS_PATH")
    or define("VIEWS_PATH", realpath(dirname(__FILE__) . '/../public_html/views'));

defined("ROOT_PATH")
    or define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

defined("BASE_PATH")
    or define("BASE_PATH", Config::getBasePath());

require_once PLUGINS_PATH . "/fileStorage/FileStorageProvider.php";

abstract class SecureConfigs
{
    const Password = "phpMdAdmin.pwd";
    const Salt = "phpMdAdmin.salt";
    const AuthToken = "phpMdAdmin.authToken";



    /**
     *
     *
     * @return
     */
    static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }


}


// Config singleton
class Config
{

    private static $iniFilePath = "phpMyAdmin.ini";
    private static $instance = NULL;
    private $storageProvider = NULL;
    public $configs = array();
    public $secureConfigs = array();

    /**
     * Inject dependencies
     */
    private function __construct()
    {
        $this->loadConfigs();
        $this->loadSecureConfigs();
        $this->storageProvider = new FileStorageProvider();
    }


    /**
     *
     */
    private function __clone()
        {}


    /**
     *
     *
     * @return
     */
    public static function shared()
    {
        if (!isset(self::$instance)) {
            // Do what we have to do to setup the config
            self::$instance = new Config();
        }
        return self::$instance;
    }


    /**
     *
     *
     * @param string  $groupName (optional)
     * @return
     */
    public static function storage($groupName = null)
    {
        return self::shared()->storageProvider->group($groupName);
    }


    /**
     *
     *
     * @param string  $storageProvider
     */
    public function setDefaultStorageProvider($storageProvider)
    {
        $this->storageProvider = $storageProvider;
    }


    /**
     *
     */
    function loadSecureConfigs()
    {
        // Do not store by section...name value pairs is fine
        foreach (SecureConfigs::getConstants() as $configKey) {
            $this->secureConfigs[$configKey] = getenv($configKey);
        }
    }


    /**
     *
     */
    public function writeSecureConfigs()
    {
        foreach (SecureConfigs::getConstants() as $configKey) {
            putenv("$configKey=" . $this->secureConfigs[$configKey]);
        }
    }


    /**
     *
     */
    function loadConfigs()
    {
        // Do not store by section...name value pairs is fine
        if (file_exists(self::$iniFilePath)) {
            $this->configs = parse_ini_file(self::$iniFilePath, false);
        }
        else {
            $this->configs = array();
        }
    }


    /**
     *
     */
    public function writeConfigs()
    {
        write_php_ini($this->configs, self::$iniFilePath);
    }


    /**
     *
     *
     * @param string  $array
     * @param string  $file
     */
    private function write_php_ini($array, $file)
    {
        $res = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $res[] = "[$key]";
                foreach ($val as $skey => $sval) $res[] = "$skey = " . (is_numeric($sval) ? $sval : '"' . $sval . '"');
            }
            else $res[] = "$key = " . (is_numeric($val) ? $val : '"' . $val . '"');
        }
        rewrite_file_safely($file, implode("\r\n", $res));
    }


    /**
     *
     *
     * @param string  $fileName
     * @param string  $dataToSave
     */
    private function rewrite_file_safely($fileName, $dataToSave)
    {
        if ($fp = fopen($fileName, 'w')) {
            $startTime = microtime(TRUE);
            do {
                $canWrite = flock($fp, LOCK_EX);
                // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
                if (!$canWrite) usleep(round(rand(0, 100) * 1000));
            }
            while ((!$canWrite) and ((microtime(TRUE) - $startTime) < 5));

            //file was locked so now we can store information
            if ($canWrite) {
                fwrite($fp, $dataToSave);
                flock($fp, LOCK_UN);
            }

            fclose($fp);
        }
    }



    /**
     *
     *
     * @return
     */
    public static function getBasePath()
    {
        $base = getenv("APP_BASEPATH");
        if (empty($base)) {
            $base = '/' . basename(realpath(dirname(__FILE__) . '/../'));
        }
        else {
            echo "this is base: $base";
        }

        return $base;
    }


}


//    Error reporting.
ini_set("error_reporting", "true");
error_reporting(E_ALL | E_STRCT);
