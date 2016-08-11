<?php

/**
 * @class       GMEX_Easy_Payment_Public
 * @version	1.0.0
 * @package	easy-payment
 * @category	Class
 * @author      mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class GMEX_Easy_Payment_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->easy_payment_add_shortcode();
        add_filter('widget_text', 'do_shortcode');
        add_filter('wp_nav_menu_items', 'do_shortcode');
    }

    public function easy_payment_add_shortcode() {
        add_shortcode('easy_payment', array($this, 'easy_payment_button_generator'));
    }

    public function easy_payment_button_generator($atts, $content = null) {

        $dropdown_string = "";
        $easy_payment_item_name = "";
        $easy_payment_amount = "";
        $form_alignment = "";
        $button_url = "";
        $easy_quantity = "";
        $output_lable = "";
        $easy_payment_table_border = 0;
        $easy_payment_item_name = (get_option('easy_payment_item_name')) ? get_option('easy_payment_item_name') : '';
        $output_tr_amount = '';
        $easy_payment_currency = '';
        if (isset($atts['border']) && !empty($atts['border'])) {
            $easy_payment_table_border = ($atts['border']) ? $atts['border'] : 0;
        }
        ?>
        <style>
            #easy_paypal_form_div td{
                border-top: <?php echo $easy_payment_table_border; ?>px solid #ddd;
            }
            #easy_paypal_form_div table{               
                border-bottom: <?php echo $easy_payment_table_border; ?>px solid #ddd;
                margin: auto;
                width: auto;
            }
        </style>
        <?php
        if (isset($atts['currency']) && !empty($atts['currency'])) {
            $easy_payment_currency = $atts['currency'];
        } else {
            $easy_payment_currency = get_option('easy_payment_currency');
        }

        if (isset($atts['item_name']) && !empty($atts['item_name'])) {
            $easy_payment_item_name = ($atts['item_name']) ? $atts['item_name'] : '';
        }

        if (isset($atts['align']) && !empty($atts['align'])) {
            $form_alignment = ($atts['align']) ? $atts['align'] : '';
        }

        if (isset($atts['quantity']) && !empty($atts['quantity'])) {
            $easy_quantity = '<tr><td><input type="text" name="quantity" value="" placeholder="Quantity"></td></tr>';
        }

        if (isset($atts) && !empty($atts) && isset($atts['lable_name'])) {
            if (is_array($atts)) {
                $dropdown_string = $this->create_dropdown_option_button($atts);
            }
        }

        if (isset($atts['amount']) && !empty($atts['amount'])) {
            $easy_payment_amount = ($atts['amount']) ? $atts['amount'] : '';
            $easy_payment_amount_input = '<input type="hidden" name="amount" value="' . esc_attr($easy_payment_amount) . '">';
        } elseif (isset($atts['lable_0']) && !empty($atts['lable_0'])) {
            $output_tr_amount = $this->create_dropdown_option_button_option_code($atts['lable_0'], $atts, $easy_payment_currency);
        } else {
            $easy_payment_amount = (get_option('easy_payment_amount')) ? get_option('easy_payment_amount') : '';
            $easy_payment_amount_input = '<input type="hidden" name="amount" value="' . esc_attr($easy_payment_amount) . '">';
        }

        $easy_payment_custom_button = get_option('easy_payment_custom_button');
        $easy_payment_button_image = get_option('easy_payment_button_image');
        $easy_payment_notify_url = site_url('?GMEX_Easy_Payment&action=ipn_handler');
        $easy_payment_return_page = get_option('easy_payment_return_page');
        $easy_payment_bussiness_email = get_option('easy_payment_bussiness_email');
        $easy_payment_PayPal_sandbox = get_option('easy_payment_PayPal_sandbox');
        $easy_payment_button_label = get_option('easy_payment_button_label');
        $easy_paypal_url = $this->get_button_url($easy_payment_button_image, $easy_payment_custom_button, $easy_payment_PayPal_sandbox);
        $button_url = $easy_paypal_url['button_url'];
        $paypal_url = $easy_paypal_url['paypal_url'];

        ob_start();

        $output = '';
        $output = '<div id="easy_paypal_form_div" class="page-sidebar widget" align="' . $form_alignment . '">';

        $output .= '<form action="' . esc_url($paypal_url) . '" method="post" target="_blank">';

        if (isset($easy_payment_button_label) && !empty($easy_payment_button_label)) {
            $output_lable = '<tr><td><p><label for=' . esc_attr($easy_payment_button_label) . '>' . esc_attr($easy_payment_button_label) . '</label></p></td></tr>';
        }

        $output .= '<input type="hidden" name="business" value="' . esc_attr($easy_payment_bussiness_email) . '">';

        $output .= '<input type="hidden" name="bn" value="mbjtechnolabs_SP">';

        $output .= '<input type="hidden" name="cmd" value="_xclick">';
        $output .= '<input type="hidden" name="custom" value="' . get_the_ID() . '">';


        if (isset($easy_payment_item_name) && !empty($easy_payment_item_name)) {
            $output .= '<input type="hidden" name="item_name" value="' . esc_attr($easy_payment_item_name) . '">';
        } else {
            $output .= '<input type="hidden" name="item_name" value="cup of coffee">';
        }

        if (isset($easy_payment_amount) && !empty($easy_payment_amount)) {
            $output .= $easy_payment_amount_input;
        }

        if (isset($dropdown_string) && !empty($dropdown_string)) {
            $output .= '<table align="' . $form_alignment . '"><tbody>' . $output_lable . $output_tr_amount . $dropdown_string . $easy_quantity . '<tr><td><input type="image" name="submit" style="border: medium none;background: inherit;" border="0" src="' . esc_url($button_url) . '" alt="PayPal - The safer, easier way to pay online"></td></tr></tbody></table>';
        } else {
            $output .= '<table align="' . $form_alignment . '"><tbody>' . $output_lable . $output_tr_amount . $easy_quantity . '<tr><td><input type="image" name="submit" style="border: medium none;background: inherit;" border="0" src="' . esc_url($button_url) . '" alt="PayPal - The safer, easier way to pay online"></td></tr></tbody></table>';
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
        $output .= '</form></div>';

        return $output;
        return ob_get_clean();
    }

    public function create_dropdown_option_button($atts) {
        $result = "";
        $loop_count = 0;
        $lable_name = $this->Get_Lable_name($atts['lable_name']);
        if (isset($atts['lable_0']) && !empty($atts['lable_0'])) {
            unset($lable_name[0]);
            $lable_name = array_values($lable_name);
        }
        foreach ($atts as $key => $value) {
            if ("currency" != $key && "amount" != $key && "align" != $key && "border" != $key && "lable_name" != $key && "item_name" != $key && "lable_0" != $key && "quantity" != $key) {
                $result .= $this->array_value_replace_hear($lable_name[$loop_count], $value, $loop_count);
                $loop_count++;
            }
        }
        return $result;
    }

    public function create_dropdown_option_button_option_code($atts, $lable_name, $easy_payment_currency) {
        $result = "";
        $currency_selected = $easy_payment_currency;
        $currency_symbol = self::easy_payment_get_currency_payment_symbol($currency_selected);
        $lable_name = $this->Get_Lable_name($lable_name['lable_name']);

        $result .= self::array_value_replace_hear_price($lable_name[0], $atts, $currency_symbol, $currency_selected);
        unset($lable_name[0]);
        $lable_name = array_values($lable_name);

        return $result;
    }

    public function array_value_replace_hear_price($lable, $data, $currency_symbol, $currency_selected) {
        $result = "<tr><td><input type='hidden' name='easy_option_price_hidden' value='" . $lable . "'>" . $lable . "</td></tr><tr><td><select name='amount'>";
        $string = "";
        $data = trim($data);
        $data = trim($data);
        $sub_option = explode(' | ', $data);
        foreach ($sub_option as $key => $value) {
            $array_export_data = array();
            $array_export_data = $this->value_expload_with_regex($value);
            $string .= "<option value=\"" . $array_export_data['key'] . "\">" . $array_export_data['value'] . ' - ' . $currency_symbol . $array_export_data['key'] . ' ' . $currency_selected . "</option>";
        }
        $result .= $string . "</select></td></tr>";
        return $result;
    }

    public function array_value_replace_hear($lable, $data, $i) {
        $result = "<tr><td><input type='hidden' name='on" . $i . "' value='" . $lable . "'>" . $lable . "</td></tr><tr><td><select name='os" . $i . "'>";
        $string = "";
        $data = trim($data);
        $data = trim($data);
        $sub_option = explode(' | ', $data);
        foreach ($sub_option as $key => $value) {
            $array_export_data = array();
            $array_export_data = $this->value_expload_with_regex($value);
            $string .= "<option value=\"" . $array_export_data['key'] . "\">" . $array_export_data['value'] . "</option>";
        }
        $result .= $string . "</select></td></tr>";
        return $result;
    }

    public function Get_Lable_name($atts) {
        $result = "";
        $result = explode(', ', $atts);
        return $result;
    }

    public function get_button_url($easy_payment_button_image, $easy_payment_custom_button, $easy_payment_PayPal_sandbox) {
        $result_array = array();
        $button_url = "";
        $paypal_url = "";
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

        $result_array['button_url'] = $button_url;
        $result_array['paypal_url'] = $paypal_url;

        return $result_array;
    }

    public function value_expload_with_regex($value) {
        $result_array = array();
        $value_regex = "/value=('|\")+[^*]+(price=)/";
        $price_regex = "/price=('|\")+[^*]+/";
        $value_name = preg_match($value_regex, $value, $matches_out_value);
        $price_name = preg_match($price_regex, $value, $matches_out_price);
        $matches_out_value[0] = str_replace(" price=", "", $matches_out_value[0]);
        $result_array['value'] = trim(str_replace("value='", "", $matches_out_value[0]), "'");
        $result_array['key'] = trim(str_replace("price='", "", $matches_out_price[0]), "'");
        return $result_array;
    }

    public static function easy_payment_get_currency_payment_symbol($currency) {

        $currency_symbol = '';

        switch ($currency) {
            case 'AED' :
                $currency_symbol = 'د.إ';
                break;
            case 'BDT':
                $currency_symbol = '&#2547;&nbsp;';
                break;
            case 'BRL' :
                $currency_symbol = '&#82;&#36;';
                break;
            case 'BGN' :
                $currency_symbol = '&#1083;&#1074;.';
                break;
            case 'AUD' :
            case 'CAD' :
            case 'CLP' :
            case 'COP' :
            case 'MXN' :
            case 'NZD' :
            case 'HKD' :
            case 'SGD' :
            case 'USD' :
                $currency_symbol = '&#36;';
                break;
            case 'EUR' :
                $currency_symbol = '&euro;';
                break;
            case 'CNY' :
            case 'RMB' :
            case 'JPY' :
                $currency_symbol = '&yen;';
                break;
            case 'RUB' :
                $currency_symbol = '&#1088;&#1091;&#1073;.';
                break;
            case 'KRW' : $currency_symbol = '&#8361;';
                break;
            case 'PYG' : $currency_symbol = '&#8370;';
                break;
            case 'TRY' : $currency_symbol = '&#8378;';
                break;
            case 'NOK' : $currency_symbol = '&#107;&#114;';
                break;
            case 'ZAR' : $currency_symbol = '&#82;';
                break;
            case 'CZK' : $currency_symbol = '&#75;&#269;';
                break;
            case 'MYR' : $currency_symbol = '&#82;&#77;';
                break;
            case 'DKK' : $currency_symbol = 'kr.';
                break;
            case 'HUF' : $currency_symbol = '&#70;&#116;';
                break;
            case 'IDR' : $currency_symbol = 'Rp';
                break;
            case 'INR' : $currency_symbol = 'Rs.';
                break;
            case 'NPR' : $currency_symbol = 'Rs.';
                break;
            case 'ISK' : $currency_symbol = 'Kr.';
                break;
            case 'ILS' : $currency_symbol = '&#8362;';
                break;
            case 'PHP' : $currency_symbol = '&#8369;';
                break;
            case 'PLN' : $currency_symbol = '&#122;&#322;';
                break;
            case 'SEK' : $currency_symbol = '&#107;&#114;';
                break;
            case 'CHF' : $currency_symbol = '&#67;&#72;&#70;';
                break;
            case 'TWD' : $currency_symbol = '&#78;&#84;&#36;';
                break;
            case 'THB' : $currency_symbol = '&#3647;';
                break;
            case 'GBP' : $currency_symbol = '&pound;';
                break;
            case 'RON' : $currency_symbol = 'lei';
                break;
            case 'VND' : $currency_symbol = '&#8363;';
                break;
            case 'NGN' : $currency_symbol = '&#8358;';
                break;
            case 'HRK' : $currency_symbol = 'Kn';
                break;
            case 'EGP' : $currency_symbol = 'EGP';
                break;
            case 'DOP' : $currency_symbol = 'RD&#36;';
                break;
            case 'KIP' : $currency_symbol = '&#8365;';
                break;
            default : $currency_symbol = '';
                break;
        }
        return $currency_symbol;
    }

}