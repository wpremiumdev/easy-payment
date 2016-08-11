<?php

/**
 * @class       GMEX_Easy_Payment_General_Setting
 * @version	1.0.0
 * @package	easy-payment
 * @category	Class
 * @author      mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class GMEX_Easy_Payment_PayPal_listner {

    /**
     * Constructor for the Paypal_Helper.
     */
    public function __construct() {

        $this->liveurl = 'https://ipnpb.paypal.com/cgi-bin/webscr';
        $this->testurl = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
    }

    /**
     * check_ipn_request helper function use for check ipn request is valid or not
     * @since    1.0.0
     * @access   public
     * return boolean
     */
    public function check_ipn_request() {
        /**
         * Check for PayPal IPN Response
         */
        @ob_clean();

        $ipn_response = !empty($_POST) ? $_POST : false;

        if ($ipn_response && $this->check_ipn_request_is_valid($ipn_response)) {

            header('HTTP/1.1 200 OK');

            return true;
        } else {

            return false;
        }
    }

    public function check_ipn_request_is_valid($ipn_response) {

        $is_sandbox = (isset($ipn_response['test_ipn'])) ? 'yes' : 'no';

        if ('yes' == $is_sandbox) {
            $paypal_adr = $this->testurl;
        } else {
            $paypal_adr = $this->liveurl;
        }

        // Get received values from post data
        $validate_ipn = array('cmd' => '_notify-validate');
        $validate_ipn += stripslashes_deep($ipn_response);

        // Send back post vars to paypal
        $params = array(
            'body' => $validate_ipn,
            'sslverify' => false,
            'timeout' => 60,
            'httpversion' => '1.1',
            'compress' => false,
            'decompress' => false,
            'user-agent' => 'easy-payment/'
        );

        // Post back to get a response
        $response = wp_remote_post($paypal_adr, $params);

        // check to see if the request was valid
        if (!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 && strstr($response['body'], 'VERIFIED')) {

            return true;
        }

        return false;
    }

    /**
     * successful_request helper function use for parse data 
     * @since    1.0.0
     * @param array $posted
     * return boolean
     */
    public function successful_request($IPN_status) {

        $ipn_response = !empty($_POST) ? $_POST : false;
        $ipn_response['IPN_status'] = ( $IPN_status == true ) ? 'Verified' : 'Invalid';
        $posted = stripslashes_deep($ipn_response);
        do_action('easy_payment_send_notification_mail', $posted);
        $this->ipn_response_data_handler($posted);
    }

    /**
     * ipn_response_data_handler helper function use for further process 
     * @since    1.0.0
     * return boolean
     */
    public function ipn_response_data_handler($posted = null) {
        /**
         * Create array for store data to post table.
         */
        global $wp;

        $debug = (get_option('easy_payment_debug_log') == 'yes') ? 'yes' : 'no';
        if ('yes' == $debug) {
            $log = new Easy_Payment_Logger();
            $log->add('easy_payment_ipn_response_callback', print_r($posted, true));
        }

        if (isset($posted) && !empty($posted)) {

            if (isset($posted['txn_id'])) {
                $paypal_txn_id = $posted['txn_id'];
            }

            if ($this->easy_payment_exist_post_by_title($paypal_txn_id) == false) {


                $insert_ipn_array = array(
                    'ID' => '',
                    'post_type' => 'easy_payment_list', // Custom Post Type Slug
                    'post_status' => 'publish',
                    'post_title' => $paypal_txn_id,
                );

                $post_id = wp_insert_post($insert_ipn_array);

                /**
                 *  development hook paypal_ipn_for_wordpress_mailchimp_handler 
                 */
                if ('yes' == get_option('enable_mailchimp')) {
                    do_action('easy_payment_mailchimp_handler', $posted);
                }


                $this->ipn_response_postmeta_handler($post_id, $posted);
            } else {

                $post_id = $this->easy_payment_exist_post_by_title($paypal_txn_id);

                wp_update_post(array('ID' => $post_id, 'post_status' => 'publish'));

                $this->ipn_response_postmeta_handler($post_id, $posted);
            }
        }
    }

    /**
     * ipn_response_postmeta_handler helper function used for store ipn response data to post meta field
     * @since    1.0.0
     * @access   public
     */
    public function ipn_response_postmeta_handler($post_id, $posted) {
        foreach ($posted as $metakey => $metavalue)
            update_post_meta($post_id, $metakey, $metavalue);
    }

    /**
     * easy_payment_exist_post_by_title helper function used for check txn_id as post_title is exist or not
     * @since    1.0.0
     * @access   public
     */
    function easy_payment_exist_post_by_title($ipn_txn_id) {

        global $wpdb;

        $post_data = $wpdb->get_col($wpdb->prepare("SELECT ID FROM wp_posts WHERE post_title = %s AND post_type = %s ", $ipn_txn_id, 'easy_payment_list'));

        if (empty($post_data)) {

            return false;
        } else {

            return $post_data[0];
        }
    }

}