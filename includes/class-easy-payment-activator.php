<?php

/**
 * @class       GMEX_Easy_Payment_Activator
 * @version	1.0.0
 * @package	easy-payment
 * @category	Class
 * @author      mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class GMEX_Easy_Payment_Activator {

    /**
     * @since    1.0.0
     */
    public static function activate() {
        self::create_files();
    }

    private static function create_files() {
        $upload_dir = wp_upload_dir();
        $files = array(
            array(
                'base' => EP_WORDPRESS_LOG_DIR,
                'file' => '.htaccess',
                'content' => 'deny from all'
            ),
            array(
                'base' => EP_WORDPRESS_LOG_DIR,
                'file' => 'index.html',
                'content' => ''
            )
        );
        foreach ($files as $file) {
            if (wp_mkdir_p($file['base']) && !file_exists(trailingslashit($file['base']) . $file['file'])) {
                if ($file_handle = @fopen(trailingslashit($file['base']) . $file['file'], 'w')) {
                    fwrite($file_handle, $file['content']);
                    fclose($file_handle);
                }
            }
        }
    }

}