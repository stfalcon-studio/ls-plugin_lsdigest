<?php

/* ---------------------------------------------------------------------------
 * @Plugin Name: LsDigest
 * @Plugin Id: lsdigest
 * @Plugin URI:
 * @Description:
 * @Author: stfalcon-studio
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 0.4.2
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * ----------------------------------------------------------------------------
 */

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attemp!!');
}

class PluginLsdigest extends Plugin {

    /**
     * Plugin Activation
     *
     * @return boolean
     */
    public function Activate() {
        $this->Cache_Clean();
        return true;
    }

    /**
     * Plugin Deactivation
     *
     * @return boolean
     */
    public function Deactivate() {
        return true;
    }

    /**
     * Plugin Initialization
     *
     * @return void
     */
    public function Init() {

    }

}