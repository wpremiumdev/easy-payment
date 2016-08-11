jQuery(function ($) {
    jQuery('#easy_payment_enable_border').val('0');
    jQuery('#easy_payment_enable_quantity').val('0');
    var radio_value = jQuery('input[name=easy_payment_button_image]:checked').val();
    set_custom_button_link(radio_value);
    jQuery("input:radio[name=easy_payment_button_image]").click(function () {
        jQuery(this).is(":checked");
        var value = jQuery(this).val();
        set_custom_button_link(value);
    });
    function set_custom_button_link(value) {
        if ("button3" == value) {
            jQuery('.class_easy_payment_custom_button').show();
        } else {
            jQuery('.class_easy_payment_custom_button').hide();
        }
    }
    jQuery("#easy_price").on("keypress keyup blur", function (evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    });
    jQuery('#wp-content-media-buttons').on('click', '.easy_popup_container_button', function () {
        jQuery('.easy_popup_container').trigger('click');
        m7_resize_thickbox();
    });
    jQuery(window).resize(function () {
        m7_resize_thickbox();
    });
    function m7_resize_thickbox() {
        var TB_HEIGHT = 'auto';
        var TB_WIDTH = jQuery('#TB_window').width();
        jQuery(document).find('#TB_window').width(TB_WIDTH).height(TB_HEIGHT).css('margin-left', -TB_WIDTH / 2);
        jQuery(document).find('#TB_ajaxContent').css({'width': '', 'height': ''});
    }

    //Add table tr First tab
    jQuery('#easy_payment_tab_price_shortcode_price').on('change', function () {
        var image_url = jQuery('.EASY_PAYMENT_SITE_URL').val();
        if ("1" == jQuery('#easy_payment_tab_price_shortcode_price').val()) {
            jQuery('.easy-payment-div-option-create-price').html('');
            var string = '<div class="wrap" style="margin:0px;"><table class="widefat" id="create_priceshortcode_1"><tr><td><input style="height: 38px;width: 100%;" type = "text" name = "os0" id = "os0" class = "easy-payment-field-style" placeholder = "Value"></td></tr></table></div>';
            jQuery('.easy-payment-div-option-create-price').append(string);
        } else if ("2" == jQuery('#easy_payment_tab_price_shortcode_price').val()) {
            jQuery('.easy-payment-div-option-create-price').html('');
            var string = '<div class="wrap" style="margin:0px;"><table style="box-shadow: inset 0 0 6px green;" id="easy_payment_option_table" class="widefat"><tr><td colspan="2"><input style="height: 38px;width: 100%;" type = "text" name ="easy_payment_lable" id = "easy_payment_lable" class = "easy-payment-field-style" placeholder = "Enter Lable Name"></td></tr><tr id="option_tr_0" data-tr="0"><td><input style="height: 38px;width: 90%;" type = "text" name = "on0" id = "on0" class = "easy-payment-field-style" placeholder = "Key"></td><td><input style="height: 38px;width: 90%;" type = "text" name = "os0" id = "os0" class = "easy-payment-field-style" placeholder = "Value"><span id="easy-payment-add-icon" class="easy-payment-add-remove-icon add-remove-icon-paypal"><img src="' + image_url + 'images/add.png"</span></td></tr></table></div>';
            jQuery('.easy-payment-div-option-create-price').append(string);
        } else {
            jQuery('.easy-payment-div-option-create-price').html('');
        }
    });
    jQuery('#create_price_shortcode').on('click', '#easy-payment-add-icon', function () {
        var image_url = jQuery('.EASY_PAYMENT_SITE_URL').val();
        var last_tr_id = jQuery('#easy_payment_option_table tr:last').attr('data-tr');
        if (last_tr_id < 4)
        {
            var id = parseInt(last_tr_id) + 1;
            var str_row = '<tr id="option_tr_' + id + '" data-tr="' + id + '"><td><input style="height: 38px;width: 90%;" type = "text" name = "on' + id + '" id = "on' + id + '" class = "easy-payment-field-style" placeholder = "Key"></td><td><input style="height: 38px;width: 90%;" type = "text" name = "os' + id + '" id = "os' + id + '" class = "easy-payment-field-style" placeholder = "Value"><span id="easy-payment-remove-icon' + id + '" class="easy-payment-add-remove-icon add-remove-icon-paypal" data-value="' + id + '"><img src="' + image_url + 'images/remove.png"</span></td></tr>';
            jQuery("#option_tr_" + last_tr_id).after(str_row);
        }
    });
    jQuery('#create_price_shortcode').on('click', '.easy-payment-add-remove-icon', function () {
        var id = jQuery(this).attr("data-value");
        jQuery('#option_tr_' + id).remove();
        reset_name_with_id(id);
    });

    //Add table tr second Tab    
    jQuery('#create_custom_shortcode').on('click', '.easy-payment-custom-add', function () {
        var image_url = jQuery('.EASY_PAYMENT_SITE_URL').val();
        var table_current_id = jQuery(this).closest('table').attr('id')
        var table_data_custom_id = jQuery(this).closest('table').attr('data-custom')
        var last_tr_id = jQuery('#' + table_current_id + ' tr:last').attr('data-tr');
        if (last_tr_id < 4)
        {
            var id = parseInt(last_tr_id) + 1;
            var str_row = '<tr id="easy-payment-table-option-' + id + '" data-tr="' + id + '"><td><input style="height: 38px;width: 90%;" type = "text" name = "on' + table_data_custom_id + id + '" id = "on' + table_data_custom_id + id + '" class = "easy-payment-field-style" placeholder = "Key"></td><td><input style="height: 38px;width: 90%;" type = "text" name = "os' + table_data_custom_id + id + '" id = "os' + table_data_custom_id + id + '" class = "easy-payment-field-style" placeholder = "Value"><span id="easy-payment-remove-tr-' + id + '" class="easy-payment-custom-remove add-remove-icon-paypal" data-value="' + id + '"><img src="' + image_url + 'images/remove.png"</span></td></tr>';
            jQuery("#" + table_current_id + " #easy-payment-table-option-" + last_tr_id).after(str_row);
        }
    });
    jQuery('#create_custom_shortcode').on('click', '.easy-payment-custom-remove', function () {
        var id = jQuery(this).attr("data-value");
        var table_current_id = jQuery(this).closest('table').attr('id');
        var table_value = jQuery(this).closest('table').attr('data-custom')
        jQuery("#" + table_current_id + " #easy-payment-table-option-" + id).remove();
        second_tab_reset_name_with_id(id, table_current_id, table_value);
    });

    //Add New Custom Table     
    jQuery('#create_custom_shortcode').on('click', '#easy_payment_add_new_custom_button', function () {
        var image_url = jQuery('.EASY_PAYMENT_SITE_URL').val();
        var number_of_table = jQuery('.EASY_PAYMENT_NUMBER_OF_TABLE').val();
        if (number_of_table < 4) {
            var id = parseInt(number_of_table) + 1;
            var str_row = '<table style="box-shadow: inset 0 0 6px red;" id="easy-payment-table-' + id + '" class="widefat" data-custom="' + id + '"><tr><td colspan="2"><input class="easy_payment_remove_new_custom_button" type="button" id="easy_payment_remove_new_custom_button" name="easy_payment_remove_new_custom_button" value="Remove Custom Option"></td></tr><tr><td colspan="2"><input style="height: 38px;width: 100%;" type = "text" name ="easy_payment_custom_lable' + id + '" id = "easy_payment_custom_lable' + id + '" class = "easy-payment-field-style" placeholder = "Enter Custom Lable Name"></td></tr><tr id="easy-payment-table-option-0" data-tr="0"><td><input style="height: 38px;width: 90%;" type = "text" name = "on' + id + '0" id = "on' + id + '0" class = "easy-payment-field-style" placeholder = "Key"></td><td><input style="height: 38px;width: 90%;" type = "text" name = "os' + id + '0" id = "os' + id + '0" class = "easy-payment-field-style" placeholder = "Value"><span class="easy-payment-custom-add add-remove-icon-paypal"><img src="' + image_url + 'images/add.png"></span></td></tr></table>';
            jQuery("#easy-payment-table-" + number_of_table).after(str_row);
            jQuery(".EASY_PAYMENT_NUMBER_OF_TABLE").val(id);
        }
    });

    //Remove Custom Table
    jQuery('#create_custom_shortcode').on('click', '#easy_payment_remove_new_custom_button', function () {
        var number_of_table = jQuery('.EASY_PAYMENT_NUMBER_OF_TABLE').val();
        var new_value = jQuery(this).closest('table').attr('data-custom');
        var new_id = parseInt(new_value) + 1;
        for (var i = new_id; i <= number_of_table; i++)
        {
            var cla_data = parseInt(i) - 1;
            var table_current_id = jQuery("#easy-payment-table-" + i).closest('table').attr('id');
            jQuery('#' + table_current_id).attr('data-custom', cla_data);
            var last_tr_id = jQuery("#" + table_current_id + " tr:last").attr('data-tr');
            for (var j = 0; j <= last_tr_id; j++)
            {
                jQuery('#' + table_current_id + ' #easy-payment-table-option-' + j).attr('data-tr', j);
                jQuery('#' + table_current_id + ' #easy-payment-table-option-' + j).attr('id', 'easy-payment-table-option-' + j);
                jQuery('#' + table_current_id + ' #on' + i + j).attr('name', 'on' + cla_data + j);
                jQuery('#' + table_current_id + ' #on' + i + j).attr('id', 'on' + cla_data + j);
                jQuery('#' + table_current_id + ' #os' + i + j).attr('name', 'os' + cla_data + j);
                jQuery('#' + table_current_id + ' #os' + i + j).attr('id', 'os' + cla_data + j);
                jQuery('#' + table_current_id + ' #easy-payment-remove-tr-' + j).attr('data-value', +j);
                jQuery('#' + table_current_id + ' #easy-payment-remove-tr-' + j).attr('id', 'easy-payment-remove-tr-' + j);
            }
            jQuery('#' + table_current_id + ' #easy_payment_custom_lable' + i).attr('id', 'easy_payment_custom_lable' + cla_data);
            jQuery('#easy-payment-table-' + i).attr('id', 'easy-payment-table-' + cla_data);
        }
        var table_current_id = jQuery(this).closest('table').attr('id');
        jQuery("#" + table_current_id).remove();
        var id = parseInt(number_of_table) - 1;
        jQuery(".EASY_PAYMENT_NUMBER_OF_TABLE").val(id);
    });

    // Insert ShortCode
    jQuery('#easy-payment-accordion').on('click', '#easy_payment_insert', function () {
        var easy_currency = easy_paypal_currency();
        var easy_align = easy_paypal_align_shortcode();
        var easy_quantity = easy_paypal_quantity_shortcode();
        var tab_0_string = enable_border_tab_0();
        var tab_1_string = create_price_shortcode_tab_1();
        var tab_2_string = create_price_shortcode_tab_2();
        var tab_lable_string = create_lable_shortcode();
        window.send_to_editor('[easy_payment' + easy_currency + easy_align + tab_0_string + easy_quantity + tab_1_string + tab_2_string + tab_lable_string + ']');
    });
    jQuery('#easy_payment_enable_border').on('change', function () {
        if (jQuery(this).is(':checked')) {
            jQuery('#easy_payment_enable_border').val('1');
            jQuery('#easy_payment_table_border').show();
        } else {
            jQuery('#easy_payment_enable_border').val('0');
            jQuery('#easy_payment_table_border').hide();
        }
    });

    jQuery('#easy_payment_enable_quantity').on('change', function () {
        if (jQuery(this).is(':checked')) {
            jQuery('#easy_payment_enable_quantity').val('1');
        } else {
            jQuery('#easy_payment_enable_quantity').val('0');
        }
    });

    function create_lable_shortcode() {
        var lable_string = "";
        var str = "";
        var lable_value = jQuery('#easy_payment_lable').val();
        var table_count = jQuery('.EASY_PAYMENT_NUMBER_OF_TABLE').val();
        if (typeof lable_value != 'undefined') {
            if (lable_value.toString().length > 0) {
                var get_madatory_option_tab_1 = easy_payment_set_lable_with_taxt_box_value_tab_1();
                if (get_madatory_option_tab_1 == true) {
                    if (table_count == '0') {
                        var table_enable_true_false = easy_enable_table_0();
                        if (table_enable_true_false == true) {
                            str += lable_value + ', ';
                        } else {
                            str += lable_value + ' ';
                        }
                    } else {
                        str += lable_value + ', ';
                    }
                }
            }
        }
        if (table_count >= '0') {
            for (var i = 0; i <= table_count; i++) {
                var lable = jQuery('#easy_payment_custom_lable' + i).val();
                var get_madatory_option = easy_payment_set_lable_with_taxt_box_value(i);
                if (get_madatory_option == true && lable.toString().length > 0) {
                    var join_str = ', ';
                    if (i == table_count) {
                        join_str = '';
                    }
                    str += lable + join_str;
                }
            }
        }
        if (str.toString().length > 2) {
            str = str.match(/[^*]+[^,{\s+}?]/g);
            lable_string = ' lable_name=" ' + str + ' "';
        }
        return lable_string;
    }
    function easy_enable_table_0() {
        var result = false;
        var first_lable = jQuery('#easy-payment-table-0 #easy_payment_custom_lable0').val();
        var pccg_last_tr = jQuery('#easy-payment-table-0 tr:last').attr('data-tr');
        if (first_lable.toString().length > 0) {
            for (var i = 0; i <= pccg_last_tr; i++) {
                var first_on = jQuery('#easy-payment-table-0 #on0' + i).val();
                var first_os = jQuery('#easy-payment-table-0 #os0' + i).val();
                if (first_on.toString().length > 0 && first_os.toString().length > 0) {
                    return true;
                }
            }
        }
        return result;
    }

    function easy_payment_set_lable_with_taxt_box_value_tab_1() {
        var return_str = false;
        var last_tr_id = jQuery("#easy_payment_option_table tr:last").attr('data-tr');
        for (var j = 0; j <= last_tr_id; j++) {
            var key = jQuery('#easy_payment_option_table #on' + j).val();
            var value = jQuery('#easy_payment_option_table #os' + j).val();
            if ((typeof key != 'undefined' && key.toString().length > 0) && (typeof value != 'undefined' && value.toString().length > 0)) {
                return_str = true;
                return true;
            }
        }
        return return_str;
    }

    function easy_payment_set_lable_with_taxt_box_value(i) {
        var return_str = false;
        var last_tr_id = jQuery("#easy-payment-table-" + i + " tr:last").attr('data-tr');
        for (var j = 0; j <= last_tr_id; j++) {
            var key = jQuery('#easy-payment-table-' + i + ' #on' + i + j).val();
            var value = jQuery('#easy-payment-table-' + i + ' #os' + i + j).val();
            if ((typeof key != 'undefined' && key.toString().length > 0) && (typeof value != 'undefined' && value.toString().length > 0)) {
                return_str = true;
                return true;
            }
        }
        return return_str;
    }

    function easy_paypal_quantity_shortcode() {
        var enable_string = "";
        var enable_check_box = jQuery('#easy_payment_enable_quantity').val();
        if (enable_check_box == '1') {
            enable_string = ' quantity="true"';
        }
        return enable_string;
    }
    function enable_border_tab_0() {
        var enable_string = "";
        var enable_check_box = jQuery('#easy_payment_enable_border').val();
        if (enable_check_box == '1') {
            var get_border = jQuery('#easy_payment_table_border').val();
            if (get_border != '0') {
                enable_string = ' border="' + get_border + '"';
            }
        }
        return enable_string;
    }
    function reset_name_with_id(id) {
        var new_id = parseInt(id) + 1;
        var last_tr_id = jQuery('#easy_payment_option_table tr:last').attr('data-tr');
        for (var i = new_id; i <= last_tr_id; i++) {
            var cla_data = parseInt(i) - 1;
            jQuery('#option_tr_' + i).attr('data-tr', cla_data);
            jQuery('#option_tr_' + i).attr('id', 'option_tr_' + cla_data);
            jQuery('#on' + i).attr('name', 'on' + cla_data);
            jQuery('#on' + i).attr('id', 'on' + cla_data);
            jQuery('#os' + i).attr('name', 'os' + cla_data);
            jQuery('#os' + i).attr('id', 'os' + cla_data);
            jQuery('#easy-payment-remove-icon' + i).attr('data-value', +cla_data);
            jQuery('#easy-payment-remove-icon' + i).attr('id', 'easy-payment-remove-icon' + cla_data);
        }
    }
    function second_tab_reset_name_with_id(id, table_current_id, table_value) {

        var new_id = parseInt(id) + 1;
        var last_tr_id = jQuery("#" + table_current_id + " tr:last").attr('data-tr');
        for (var i = new_id; i <= last_tr_id; i++) {
            var cla_data = parseInt(i) - 1;
            jQuery('#' + table_current_id + ' #easy-payment-table-option-' + i).attr('data-tr', cla_data);
            jQuery('#' + table_current_id + ' #easy-payment-table-option-' + i).attr('id', 'easy-payment-table-option-' + cla_data);
            jQuery('#' + table_current_id + ' #on' + table_value + i).attr('name', 'on' + table_value + cla_data);
            jQuery('#' + table_current_id + ' #on' + table_value + i).attr('id', 'on' + table_value + cla_data);
            jQuery('#' + table_current_id + ' #os' + table_value + i).attr('name', 'os' + table_value + cla_data);
            jQuery('#' + table_current_id + ' #os' + table_value + i).attr('id', 'os' + table_value + cla_data);
            jQuery('#' + table_current_id + ' #easy-payment-remove-tr-' + i).attr('data-value', +cla_data);
            jQuery('#' + table_current_id + ' #easy-payment-remove-tr-' + i).attr('id', 'easy-payment-remove-tr-' + cla_data);
        }
    }
    function create_price_shortcode_tab_1() {
        var result_string = "";
        var str = "";
        var select_method = jQuery('#easy_payment_tab_price_shortcode_price').val();
        if ('1' == select_method) {
            str = jQuery('#create_priceshortcode_1 #os0').val();
            if (str.toString().length > 0) {
                result_string = ' amount="' + str + '"';
            }
        } else if ('2' == select_method) {
            var last_tr_id = jQuery('#easy_payment_option_table tr:last').attr('data-tr');
            result_string = loop_option_table(last_tr_id);
        }
        return result_string;
    }
    function loop_option_table(last_tr_id) {
        var string = "";
        var str = "";
        var count_loop = 0;
        var lable_value = jQuery('#easy_payment_lable').val();
        if (lable_value.toString().length > 0) {
            lable_value = "LABLE_0";
            for (var i = 0; i <= last_tr_id; i++) {
                var join_str = " | ";
                var key = "";
                var value = "";
                key = jQuery('#on' + i).val();
                value = jQuery('#os' + i).val();
                if (key.toString().length > 0 && value.toString().length > 0) {
                    if (count_loop == '0')
                    {
                        join_str = '';
                    }
                    str += join_str + "value='" + key + "' price='" + value + "'";
                    string = ' ' + lable_value + '=" ' + str + ' "';
                    count_loop = parseInt(count_loop) + 1;
                }
            }
        }
        return string;
    }
    function create_price_shortcode_tab_2() {
        var result_string = "";
        var table_count = jQuery('.EASY_PAYMENT_NUMBER_OF_TABLE').val();
        result_string = loop_option_table_tab_2(table_count);
        return result_string;
    }
    function loop_option_table_tab_2(table_count) {
        var string = "";
        var str = "";
        for (var i = 0; i <= table_count; i++) {
            var count_loop = 0;
            str = "";
            var last_tr_id = jQuery('#easy-payment-table-' + i + ' tr:last').attr('data-tr');
            if (last_tr_id.toString().length > 0) {
                for (var j = 0; j <= last_tr_id; j++) {
                    var join_str = " | ";
                    var key = "";
                    var value = "";
                    key = jQuery('#easy-payment-table-' + i + ' #on' + i + j).val();
                    value = jQuery('#easy-payment-table-' + i + ' #os' + i + j).val();
                    if (key.toString().length > 0 && value.toString().length > 0) {
                        if (count_loop == '0')
                        {
                            join_str = '';
                        }
                        str += join_str + "value='" + key + "' price='" + value + "'";
                        count_loop = parseInt(count_loop) + 1;
                    }
                }
                var lable_value = jQuery('#easy_payment_custom_lable' + i).val();
                if (str.toString().length == 0 || lable_value.toString().length == 0) {
                } else {
                    lable_value = "LABLE" + i;
                    if (lable_value.toString().length > 0) {
                        string += ' ' + lable_value + '=" ' + str + ' "';
                    }
                }
            }
        }
        return string;
    }

    function easy_paypal_align_shortcode() {
        var easy_align = "";
        var get_align = jQuery('#easy_payment_align').val();
        if (get_align != 'align') {
            easy_align = ' align="' + get_align + '"';
        }
        return easy_align;
    }
    function easy_paypal_currency() {
        var easy_currency = "";
        var get_currency = jQuery('#easy_paypal_currency_think').val();
        if (get_currency != 'none') {
            easy_currency = ' currency="' + get_currency + '"';
        }
        return easy_currency;
    }
});