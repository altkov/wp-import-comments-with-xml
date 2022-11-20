<?php

namespace ICWX\Tools;

class Cookie {
    private static array $cookie;

    public static function init() {
        self::$cookie = $_COOKIE;

        if (isset($_COOKIE['icwx_flash'])) {
            $flashItems = json_decode($_COOKIE['icwx_flash']);
            foreach ($flashItems as $flash) {
                self::unset($flash);
            }

            self::unset('icwx_flash');
        }
    }

    public static function flash(string $key, $value) {
        setcookie($key, json_encode($value));

        if (isset($_COOKIE['icwx_flash'])) {
            $flash = json_decode($_COOKIE['icwx_flash']);
        } else {
            $flash = [];
        }

        $flash[] = $key;

        setcookie('icwx_flash', json_encode($flash));
    }

    public static function flashPush(string $key, $value) {
        if (isset(self::$cookie[$key])) {
            $array = json_decode(self::$cookie[$key]);
        } else {
            $array = [];
        }

        $array[] = $value;

        self::flash($key, $array);
    }

    public static function get(string $key, $default = null) {
        if (isset(self::$cookie[$key])) {
            return json_decode(self::$cookie[$key]);
        } else {
            return $default;
        }
    }

    public static function set(string $key, $value) {
        setcookie($key, json_encode($value));
    }

    public static function unset(string $key) {
        setcookie($key, '', time()-1);
    }
}