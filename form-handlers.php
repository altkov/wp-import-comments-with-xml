<?php

add_action('admin_post_icwx_import', function() {
    if (check_admin_referer('icwx_import')) {
        (new ICWX\Controller\ImportController())->execute();
    }
});