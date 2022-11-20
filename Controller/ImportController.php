<?php

namespace ICWX\Controller;

use ICWX\Tools\Cookie;
use ICWX\Tools\Url;
use ICWX\Tools\Xml;

class ImportController extends Controller {
    public function show() {
        $this->view('import', [
            'fatalError' => Cookie::get('icwx_fatal_error'),
            'errors' => Cookie::get('icwx_errors', []),
        ]);
    }

    public function execute() {
        $errorReporting = error_reporting();
        error_reporting($errorReporting | ~E_WARNING );

        register_shutdown_function(function() {
            if ($e = error_get_last()) {
                $this->onExecuteError($e['message']);
            }
        });

        try {
            $this->doImport();
            wp_redirect(Url::page('result'));
        } catch (\Error $e) {
            $this->onExecuteError($e->getMessage());
        }
    }

    private function onExecuteError(string $error) {
        Cookie::flash('icwx_fatal_error', $error);
        wp_redirect(Url::page('import'));
    }

    private function doImport() {
        if ($this->input('disable_kses', false)) {
            kses_remove_filters();
        }
        $postStatus = $this->input('post_status', 'draft');

        if (empty($_FILES['xml']['tmp_name'])) {
            Cookie::flashPush('icwx_errors', 'Загрузите файл');
            wp_redirect(Url::page('import'));
            exit;
        }

        $xml = new Xml($_FILES['xml']['tmp_name']);
        $created = [];
        foreach ($xml->readElements('post') as $post) {
            $postID = wp_insert_post([
                'post_title' => $post['title'] ?: '',
                'post_content' => $post['content'] ?: '',
                'post_name' => $post['slug'] ?: '',
                'post_status' => $postStatus,
            ]);

            wp_set_post_categories($postID, [$post['catID']]);

            foreach ($post['comments']['comment'] ?? [] as $comment) {
                wp_new_comment([
                    'comment_post_ID' => $postID,
                    'comment_author' => $comment['name'] ?: '',
                    'comment_content' => $comment['text'] ?: '',
                    'comment_author_url' => '',
                    'comment_author_email' => '',
                ]);

                wp_insert_comment(wp_slash([
                    'comment_post_ID' => $postID,
                    'comment_author' => $comment['name'] ?: '',
                    'comment_content' => $comment['text'] ?: '',
                ]));
            }

            $created[] = $postID;
        }

        Cookie::set('icwx_created', $created);
    }

    public function result() {
        $this->view('result', [
            'count' => count(Cookie::get('icwx_created', []))
        ]);
    }
}