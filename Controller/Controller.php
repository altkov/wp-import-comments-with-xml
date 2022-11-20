<?php

namespace ICWX\Controller;

class Controller {
    public function __construct() {
    }

    protected function view(string $path, array $atts = []) {
        extract($atts);

        require ICWX_PLUGIN_DIR . '/View/' . $path . '.php';
    }

    protected function input(string $key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }
}