<?php

/**
 * @class       GMEX_Easy_Payment_Admin_Widget
 * @version	1.0.0
 * @package	easy-payment
 * @category	Class
 * @author      mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class GMEX_Easy_Payment_Admin_Widget extends WP_Widget {

    function GMEX_Easy_Payment_Admin_Widget() {
        parent::__construct(false, 'PayPal Payment');
    }

    function widget($args, $instance) {
        echo do_shortcode('[easy_payment]');
    }

    function update($new_instance, $old_instance) {
        
    }

    function form($instance) {
        $easy_payment_custom_button = get_option('easy_payment_custom_button');
        $easy_payment_button_image = get_option('easy_payment_button_image');
        if (isset($easy_payment_button_image) && !empty($easy_payment_button_image)) {
            switch ($easy_payment_button_image) {
                case 'button1':
                    $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/btn_buynow_LG.gif';
                    break;
                case 'button2':
                    $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/btn_paynow_LG.gif';
                    break;
                case 'button3':
                    $button_url = !empty($easy_payment_custom_button) ? $easy_payment_custom_button : 'https://www.paypalobjects.com/en_AU/i/btn/btn_buynow_LG.gif';
                    break;
            }
        } elseif (isset($easy_payment_custom_button) && !empty($easy_payment_custom_button)) {
            $button_url = $easy_payment_custom_button;
        } else {
            $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/btn_buynow_LG.gif';
        }


        $easy_payment_button_label = get_option('easy_payment_button_label');
        $output = '';
        if (isset($easy_payment_button_label) && !empty($easy_payment_button_label)) {
            $output .= '<p><label for=' . esc_attr($easy_payment_button_label) . '>' . esc_attr($easy_payment_button_label) . '</label></p>';
        }
        if (isset($button_url) && !empty($button_url)) {
            $output .= '<input type="image" name="submit" border="0" src="' . esc_url($button_url) . '" alt="PayPal - The safer, easier way to pay online">';
        }

        echo $output;
    }

    public function easy_payment_button_generator() {

        $easy_payment_custom_button = get_option('easy_payment_custom_button');
        $easy_payment_button_image = get_option('easy_payment_button_image');
        $easy_payment_item_name = get_option('easy_payment_item_name');
        $easy_payment_amount = get_option('easy_payment_amount');
        $easy_payment_notify_url = get_option('easy_payment_notify_url');
        $easy_payment_return_page = site_url('?GMEX_Easy_Payment&action=ipn_handler');
        $easy_payment_currency = get_option('easy_payment_currency');
        $easy_payment_bussiness_email = get_option('easy_payment_bussiness_email');
        $easy_payment_PayPal_sandbox = get_option('easy_payment_PayPal_sandbox');
        $easy_payment_button_label = get_option('easy_payment_button_label');


        if (isset($easy_payment_button_image) && !empty($easy_payment_button_image)) {
            switch ($easy_payment_button_image) {
                case 'button1':
                    $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/btn_buynow_LG.gif';
                    break;
                case 'button2':
                    $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/btn_paynow_LG.gif';
                    break;
                case 'button3':
                    $button_url = !empty($easy_payment_custom_button) ? $easy_payment_custom_button : 'https://www.paypalobjects.com/en_AU/i/btn/btn_buynow_LG.gif';
                    break;
            }
        } elseif (isset($easy_payment_custom_button) && !empty($easy_payment_custom_button)) {
            $button_url = $easy_payment_custom_button;
        } else {
            $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/btn_buynow_LG.gif';
        }


        if (isset($easy_payment_PayPal_sandbox) && $easy_payment_PayPal_sandbox == 'yes') {
            $paypal_url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
        } else {
            $paypal_url = 'https://ipnpb.paypal.com/cgi-bin/webscr';
        }


        $output = '';

        $output .= '<form action="' . esc_url($paypal_url) . '" method="post" target="_blank">';

        if (isset($easy_payment_button_label) && !empty($easy_payment_button_label)) {
            $output .= '<p><label for=' . esc_attr($easy_payment_button_label) . '>' . esc_attr($easy_payment_button_label) . '</label></p>';
        }

        $output .= '<input type="hidden" name="business" value="' . esc_attr($easy_payment_bussiness_email) . '">';

        $output .= '<input type="hidden" name="bn" value="mbjtechnolabs_SP">';

        $output .= '<input type="hidden" name="cmd" value="_xclick">';

        if (isset($easy_payment_item_name) && !empty($easy_payment_item_name)) {
            $output .= '<input type="hidden" name="item_name" value="' . esc_attr($easy_payment_item_name) . '">';
        } else {
            $output .= '<input type="hidden" name="item_name" value="cup of coffee">';
        }

        if (isset($easy_payment_amount) && !empty($easy_payment_amount)) {
            $output .= '<input type="hidden" name="amount" value="' . esc_attr($easy_payment_amount) . '">';
        }

        if (isset($easy_payment_currency) && !empty($easy_payment_currency)) {
            $output .= '<input type="hidden" name="currency_code" value="' . esc_attr($easy_payment_currency) . '">';
        }

        if (isset($easy_payment_notify_url) && !empty($easy_payment_notify_url)) {
            $output .= '<input type="hidden" name="notify_url" value="' . esc_url($easy_payment_notify_url) . '">';
        }

        if (isset($easy_payment_return_page) && !empty($easy_payment_return_page)) {
            $easy_payment_return_page = get_permalink($easy_payment_return_page);
            $output .= '<input type="hidden" name="return" value="' . esc_url($easy_payment_return_page) . '">';
        }

        $output .= '<input type="image" style="border: medium none;background: inherit;" name="submit" border="0" src="' . esc_url($button_url) . '" alt="PayPal - The safer, easier way to pay online">';
        $output .= '</form>';

        return $output;
    }

}

function easy_payment_register_widgets() {
    register_widget('GMEX_Easy_Payment_Admin_Widget');
}

add_action('widgets_init', 'easy_payment_register_widgets');