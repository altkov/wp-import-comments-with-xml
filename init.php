<?php

use ICWX\Tools\Cookie;
use ICWX\Tools\Url;

Url::init();

Cookie::init();

add_action('admin_menu', function() {
    add_submenu_page(
        'tools.php',
        'Импорт записей с комментариями',
        'Импорт записей с комментариями',
        'edit_theme_options',
        'icwx_import',
        function() {
            $controller = new ICWX\Controller\ImportController();
            if (isset($_GET['result'])) {
                $controller->result();
            } else {
                $controller->show();
            }
        }
    );
});