<?php
/*
 * Plugin Name: Импорт записей с комментариями XML
 */

define('ICWX_PLUGIN_DIR', __DIR__);

require ICWX_PLUGIN_DIR . '/Tools/Url.php';
require ICWX_PLUGIN_DIR . '/Tools/Xml.php';
require ICWX_PLUGIN_DIR . '/Tools/Cookie.php';

require ICWX_PLUGIN_DIR . '/Controller/Controller.php';
require ICWX_PLUGIN_DIR . '/Controller/ImportController.php';

require ICWX_PLUGIN_DIR . '/init.php';
require ICWX_PLUGIN_DIR . '/form-handlers.php';