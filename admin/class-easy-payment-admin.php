<?php

/**
 * @class       GMEX_Easy_Payment_Admin
 * @version	1.0.0
 * @package	easy-payment
 * @category	Class
 * @author      mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class GMEX_Easy_Payment_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
        $this->define_constants();
    }

    private function load_dependencies() {
        /**
         * The class responsible for defining all actions that occur in the Dashboard
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/easy-payment-admin-display.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/easy-payment-general-setting.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/easy-payment-html-output.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/easy-payment-admin-widget.php';
    }

    private function define_constants() {
        if (!defined('EP_WORDPRESS_LOG_DIR')) {
            define('EP_WORDPRESS_LOG_DIR', ABSPATH . 'easy-payment-logs/');
        }
    }

    public function enqueue_styles() {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/easy-payment.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/easy-payment-admin.js', array('jquery'), $this->version, false);
    }

    public function easy_payment_woocommerce_standard_parameters($paypal_args) {
        if (isset($paypal_args['BUTTONSOURCE'])) {
            $paypal_args['BUTTONSOURCE'] = 'mbjtechnolabs_SP';
        } else {
            $paypal_args['bn'] = 'mbjtechnolabs_SP';
        }
        return $paypal_args;
    }

    public function easy_add_my_media_button() {
        ?>

        <a href="javascript:;" class="button easy_popup_container_button" style="background-color: #0091cd; border: 1px solid #0091cd;box-shadow: inset 0px 1px 0px 0px #0091cd;color: #FFFFFF;">Easy Payment Button</a>		
        <?php
        add_thickbox();
        echo '<a style="display: none;" href="#TB_inline?height=&amp;width=470&amp;&inlineId=easy_popup_container" class="thickbox easy_popup_container">Easy Payment Button</a>';
        ?>
        <div id="easy_popup_container" style="display: none;" class="wrap">  
            <div class="easy-payment-form-style-9" id="easy-payment-accordion">
                <ul>
                    <li>
                        <a href="#easy_paypal_currency_thinkbox">Select Currency</a>
                        <div id="easy_paypal_currency_thinkbox" class="easy-payment-accordion">
                            <div class="wrap" style="margin:0px;">
                                <table class="widefat">
                                    <tr>
                                        <td>
                                            <select style="height: 38px;" name="easy_paypal_currency_think" id="easy_paypal_currency_think" class="easy-payment-field-style easy-payment-class-select">
                                                <?php
                                                $options = '<option value="none">Select Currency</option>';
                                                $selected_currency = get_option('easy_payment_currency');
                                                $currency_code = GMEX_Easy_Payment_General_Setting::get_easy_payment_currencies();
                                                foreach ($currency_code as $code => $name) {
                                                    $selected = "";
                                                    $currency = GMEX_Easy_Payment_General_Setting::get_easy_payment_symbol($code);
                                                    if ($selected_currency == $code) {
                                                        $selected = "selected";
                                                    }
                                                    $options .= '<option value="' . $code . '" ' . $selected . '>' . $name . ' (' . $currency . ')</option>';
                                                }
                                                echo $options;
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#enable_table_border">Optional Shortcode</a>
                        <div id="enable_table_border" class="easy-payment-accordion">
                            <div class="wrap" style="margin:0px;">
                                <table class="widefat">
                                    <tr>
                                        <td style="padding-top: 20px;font-size: 15px;">
                                            <input type="checkbox" id="easy_payment_enable_quantity" name="easy_payment_enable_quantity" value=""> Enable Quantity TaxtBox Front-End
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 20px;font-size: 15px;">
                                            <input type="checkbox" id="easy_payment_enable_border" name="easy_payment_enable_border" value=""> Enable Table Border Front-End
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select hidden style="height: 38px;" name="easy_payment_table_border" id="easy_payment_table_border" class="easy-payment-field-style easy-payment-class-select">
                                                <option value="0">Select Table Border</option>
                                                <option value="1">1px</option>
                                                <option value="2">2px</option>
                                                <option value="3">3px</option>
                                                <option value="4">4px</option>
                                                <option value="5">5px</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#easy_paypal_align">Set Button Align Front-End</a>
                        <div id="easy_paypal_align" class="easy-payment-accordion">
                            <div class="wrap" style="margin:0px;"><table class="widefat"><tr><td><select style="height: 38px;" name="easy_payment_align" id="easy_payment_align" class="easy-payment-field-style easy-payment-class-select"><option value="align">Set Align</option><option value="left">Left</option><option value="center">Center</option><option value="right">Right</option></select></td></tr></table></div>
                        </div>
                    </li>
                    <li>
                        <a href="#create_price_shortcode">Create Price Shortcode</a>
                        <div id="create_price_shortcode" class="easy-payment-accordion">
                            <div class="wrap" style="margin:0px;"><table class="widefat"><tr><td><select style="height: 38px;" name="easy_payment_tab_price_shortcode_price" id="easy_payment_tab_price_shortcode_price" class="easy-payment-field-style easy-payment-class-select"><option value="none">Select Price Shortcode</option><option value="1">Simple Price Shortcode</option><option value="2">Options Price Shortcode</option></select></td></tr></table></div>
                            <div class="easy-payment-div-option-create-price"></div>
                        </div>
                    </li>
                    <li>
                        <a href="#create_custom_shortcode">Create Custom Shortcode</a>
                        <div id="create_custom_shortcode" style=" height: 330px;overflow: auto;" class="easy-payment-accordion">
                            <div class="wrap" style="margin:0px;">                                

                                <table id="easy-payment-table-0" class="widefat" data-custom="0" style="box-shadow: inset 0 0 10px green;">
                                    <tr>
                                        <td colspan="2">
                                            <input class="easy_payment_add_new_custom_button" type="button" id="easy_payment_add_new_custom_button" value="Add New Custom Option">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input style="height: 38px;width: 100%;" type = "text" name ="easy_payment_custom_lable0" id = "easy_payment_custom_lable0" class = "easy-payment-field-style" placeholder = "Enter Custom Lable Name">
                                        </td>
                                    </tr>
                                    <tr id="easy-payment-table-option-0" data-tr="0">
                                        <td>
                                            <input style="height: 38px;width: 90%;" type = "text" name = "on00" id = "on00" class = "easy-payment-field-style" placeholder = "Key">
                                        </td>
                                        <td>
                                            <input style="height: 38px;width: 90%;" type = "text" name = "os00" id = "os00" class = "easy-payment-field-style" placeholder = "Value">
                                            <span id="easy-payment-add-row-0" class="easy-payment-custom-add add-remove-icon-paypal" data-custom-span="0">
                                                <img src="<?php echo plugin_dir_url(__FILE__); ?>images/add.png">
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </li>                                      
                </ul>                     
                <input class="easy-payment-background-color-table" type="button" id="easy_payment_insert" value="Create Easy Payment Button"> 
                <input type="hidden" class="EASY_PAYMENT_SITE_URL" name="EASY_PAYMENT_SITE_URL" value="<?php echo plugin_dir_url(__FILE__); ?>">
                <input type="hidden" class="EASY_PAYMENT_NUMBER_OF_TABLE" name="EASY_PAYMENT_NUMBER_OF_TABLE" value="0">
            </div>
        </div>
        <?php
    }

}