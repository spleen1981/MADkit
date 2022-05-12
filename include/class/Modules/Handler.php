<?php

/*
 * Copyright (C) 2022 Giovanni Cascione <ing.cascione@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace MADkit\Modules;

class Handler {

    public static $active_modules = array();

    //put your code here
    public static function load_modules() {
        $retval = array();
        foreach (scandir(MK_MODULES_PATH) as $key => $value) {
            if (!in_array($value, array(".", "..")) &&
                    is_dir(MK_MODULES_PATH . "/" . $value) &&
                    class_exists(MK_MODULES_NAMESPACE . $value)) {

                $class = MK_MODULES_NAMESPACE . $value;
                self::$active_modules[$value] = new \MADkit\Module\Timesheets;
                ;
            }
        }
    }

    public static function get_default_table_name($module_name) {
        return MK_TABLES_PREFIX . strtolower($module_name) . '_table';
    }

    public static function get_module_name($class_name) {
        if (!empty($class_name)) {
            $trimmed_classname = str_replace(MK_MODULES_NAMESPACE, '', $class_name);
            if ($trimmed_classname != $class_name) { //test namespace as per template
                $buffer = explode('\\', $trimmed_classname);
                return array_shift($buffer);
            }
        }
    }

    public static function get_module_path($module_name) {
        if (!empty($module_name)) {
            return MK_MODULES_PATH . DIRECTORY_SEPARATOR . $module_name;
        }
    }
}