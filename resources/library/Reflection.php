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


class Reflection
{



    /**
     *
     *
     * @param string  $filepath
     * @return
     */
    public static function get_file_php_classes($filepath)
    {
        $php_code = file_get_contents($filepath);
        $classes  = self::get_php_classes($php_code);





        return $classes;
    }


    /**
     *
     *
     * @param string  $php_code
     * @param string  $interface (optional)
     * @return
     */
    private static function get_php_classes($php_code, $interface = NULL)
    {
        $classes = array();
        $tokens = token_get_all($php_code);
        var_dump($tokens);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $class_name = $tokens[$i][1];

                // Now check if one of the interfaces is the interface to check
                if ($interface != NULL && ($tokens[$i + 2][0] == T_IMPLEMENTS && $tokens[$i + 3][0] == T_WHITESPACE && $tokens[$i + 4][0] == T_STRING)) {
                    $interface_name = $tokens[$i + 4][1];
                    if ($interface_name == $interface) {
                        $classes[]  = $class_name;
                    }
                }
                else {
                    $classes[]  = $class_name;
                }
            }
        }
        return $classes;
    }


    /**
     *
     *
     * @param string  $php_code
     * @param string  $interface (optional)
     * @return
     */
    private static function get_php_interfaces($php_code, $interface = NULL)
    {
        $interfaces = array();
        $tokens = token_get_all($php_code);
        var_dump($tokens);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_IMPLEMENTS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $interface_name = $tokens[$i][1];
                $interfaces[]  = $interface_name;
            }
        }
        return $interfaces;
    }


}
