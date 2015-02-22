<?php

/* ========================================================================
 * Open eClass 
 * E-learning and Course Management System
 * ========================================================================
 * Copyright 2003-2014  Greek Universities Network - GUnet
 * A full copyright notice can be read in "/info/copyright.txt".
 * For a full list of contributors, see "credits.txt".
 *
 * Open eClass is an open platform distributed in the hope that it will
 * be useful (without any warranty), under the terms of the GNU (General
 * Public License) as published by the Free Software Foundation.
 * The full license can be read in "/info/license/license_gpl.txt".
 *
 * Contact address: GUnet Asynchronous eLearning Group,
 *                  Network Operations Center, University of Athens,
 *                  Panepistimiopolis Ilissia, 15784, Athens, Greece
 *                  e-mail: info@openeclass.org
 * ======================================================================== 
 */

foreach (ExtAppManager::$AppNames as $appName)
    require_once strtolower($appName) . '.php';

class ExtAppManager {

    public static $AppNames = array("GoogleDriveApp", "OneDriveApp", "DropBoxApp");
    private static $APPS = null;

    /**
     * @return ExtApp[]
     */
    public static function getApps() {
        if (ExtAppManager::$APPS == null) {
            $apps = array();
            foreach (ExtAppManager::$AppNames as $appName) {
                $app = new $appName();
                $apps[$app->getName()] = $app;
            }
            ExtAppManager::$APPS = $apps;
        }
        return ExtAppManager::$APPS;
    }

    /**
     * 
     * @param string $appname
     * @return ExtApp
     */
    public static function getApp($appname) {
        $apps = ExtAppManager::getApps();
        return $apps[$appname];
    }

}

abstract class ExtApp {

    private $params = array();

    /**
     * @param ExtParam $param
     */
    protected function registerParam($param) {
        $this->params[$param->name()] = $param;
    }

    /**
     * @return ExtParam[]
     */
    public function getParams() {
        return $this->params;
    }

    public function getParam($paramName) {
        return $this->params[$paramName];
    }

    /**
     * 
     * @return string
     */
    public function getName() {
        return strtolower(str_replace(' ', '', $this->getDisplayName()));
    }

    public function storeParams() {
        $response = null;
        foreach ($this->getParams() as $param) {
            $name = $param->name();
            $val = isset($_POST[$name]) ? $_POST[$name] : "";
            $param->set_value($val);
        }
        if (($response = $this->validateApp()))
            return $response;
        foreach ($this->getParams() as $param) {
            if (($response = $param->validateParam()))
                return $response;
        }
        foreach ($this->getParams() as $param) {
            $param->persistValue();
        }
        return null;
    }

    public function validateApp() {
        return null;
    }

    public abstract function getDisplayName();
}

abstract class ExtParam {

    private static $UNSET = "[[[[ <<<<<<< ----- unset ----- >>>>>>> ]]]]";
    private $display;
    private $name;
    private $value;

    const TYPE_STRING = 0;
    const TYPE_BOOLEAN = 1;

    function __construct($display, $name) {
        $this->display = $display;
        $this->name = $name;
        $this->value = ExtParam::$UNSET;
    }

    function display() {
        return $this->display;
    }

    function name() {
        return $this->name;
    }

    function value() {
        if ($this->value === ExtParam::$UNSET)
            $this->set_value($this->retrieveValue());
        return $this->value;
    }

    function set_value($value) {
        $this->value = $value;
    }

    public function validateParam() {
        return null;
    }

    abstract protected function retrieveValue();

    public abstract function persistValue();
}
