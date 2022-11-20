<?php

namespace ICWX\Tools;

class Url {
    private static self $instance;
    private array $pages;

    public function __construct() {
        $this->pages = [
            'import' => admin_url('tools.php?page=icwx_import'),
            'execute' => admin_url( 'admin-post.php' ),
            'result' => admin_url('tools.php?page=icwx_import&result')
        ];
    }

    public static function init() {
        self::$instance = new self();
    }

    public static function page(string $page, array $query = []) {
        $url = self::$instance->getPageUrl($page);

        if (!empty($query)) {
            $queryString = http_build_query($query);
            if (strpos($url, '?') === false) {
                $url .= '?';
            } else {
                $url .= '&';
            }

            $url .= $queryString;
        }

        return $url;
    }

    public function getPageUrl(string $page) {
        return $this->pages[$page];
    }
}