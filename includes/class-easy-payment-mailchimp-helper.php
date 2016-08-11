<?php

/**
 * @class       GMEX_Easy_Payment_MailChimp_Helper
 * @version	1.0.0
 * @package	easy-payment
 * @category	Class
 * @author      mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class GMEX_Easy_Payment_MailChimp_Helper {

    /**
     * init for the MailChimp.
     */
    public static function init() {
        $enable_mailchimp = get_option('enable_mailchimp');
        if (isset($enable_mailchimp) && $enable_mailchimp == 'yes') {
            add_action('easy_payment_mailchimp_handler', array(__CLASS__, 'easy_payment_mailchimp_handler'), 10, 1);
        }
    }

    /**
     * Subscribe User to MailChimp
     *
     * @since    1.0.0
     * @access   static
     */
    public static function easy_payment_mailchimp_handler($posted) {

        if (!isset($posted) || empty($posted)) {
            return;
        }

        $apikey = get_option('mailchimp_api_key');
        $listId = get_option('mailchimp_lists');

        $first_name = isset($posted['first_name']) ? $posted['first_name'] : '';
        $last_name = isset($posted['last_name']) ? $posted['last_name'] : '';
        $payer_email = isset($posted['payer_email']) ? $posted['payer_email'] : $posted['receiver_email'];

        $merge_vars = array('FNAME' => $first_name, 'LNAME' => $last_name);

        if (isset($apikey) && !empty($apikey)) {
            include_once 'class-easy-payment-mcapi.php';
            $api = new GMEX_Easy_Payment_MailChimp_MCAPI($apikey);

            $retval = $api->listSubscribe($listId, $payer_email, $merge_vars, $email_type = 'html');
        }
    }

}

GMEX_Easy_Payment_MailChimp_Helper::init();