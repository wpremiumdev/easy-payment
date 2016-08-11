=== Easy PayPal Payment ===
Contributors: mbj-webdevelopment
Tags: Accept payment for services or product, buy now, currency, payment, paypal, paypal donation, paypal for wordpress, paypal integration, PayPal payment, paypal plugin for wordpress, wordpress paypal
Requires at least: 3.0.1
Tested up to: 4.5
Stable tag: 1.1.6
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easy to use add a Paypal Payment Buttons as a Page, Post and Widget with a shortcode.
== Description ==
= Introduction =

This easy to use PayPal Payment allows you to place a PayPal payment button within your WordPress theme. Choose between 2 standard PayPal payment buttons or use your own custom button. Also PayPal Payment button used in Page, Post and Widget with a shortcode.

[youtube https://www.youtube.com/watch?v=m4lZPom-LYM]

* Provide shortcode

= Shortcode =


Insert the button in your pages or posts with this shortcode

`[easy_payment]`
`[easy_payment item_name="NAME" amount="PRICE"]`


For WordPress Template file

`<?php echo do_shortcode('[easy_payment]'); ?>`
`<?php echo do_shortcode('[easy_payment item_name="NAME" amount="PRICE"]'); ?>`

* Provide widget
* Provide custome button
* Provide PayPal IPN url ( paypal notify_url  ), instant payment notification
* Provide return url ( Thank you page)
* Provide provide multi currency support
* Provide credit cart payment system

= List of Payment with below field =
*	Transaction ID
*	Name / Company
*	Amount
*	Transaction Type
*	Payment status
*	Date
* 	All the field are available in detail view 

= Provide MultiLanguage support =

= Payment Confirmation Email =
* Admin ( store admin )
* Customer ( PayPal payer email)

= MailChimp API =
*	Automatically add email addresses to your MailChimp user list(s) when payment are processed on your PayPal account.



== Installation ==

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "Paypal Payment Button" and click Search Plugins. Once you've found our plugin you can view details about it such as the the rating and description. Most importantly, of course, you can install it by simply clicking Install Now.

= Manual Installation =

1. Unzip the files and upload the folder into your plugins folder (/wp-content/plugins/) overwriting previous versions if they exist
2. Activate the plugin in your WordPress admin area.


= configuration =



Easy steps to install the plugin:

*	Upload "Paypal Payment Button" folder/directory to the /wp-content/plugins/ directory
*	Activate the plugin through the 'Plugins' menu in WordPress.
*	Go to Settings => Paypal Payment

== Screenshots ==

1. PayPal Donation General Setting..
2. Send Email Setting.
3. MailChimp Setting.
4. Help.
5. Payment List.
6. Button For Create a Shortcode in Page Or Post.
7. Enable Table Border In Front-End.
8. Create Price Shortcode.
9. Create Price Shortcode With Options.
10. Create Custom Shortcode With Options
11. Display Paypal Button.

== Frequently Asked Questions ==
= Where can I get support? =
*	Please visit the [Support Forum] (http://wordpress.org/support/plugin/easy-payment) for questions, answers, support and feature requests.

= Does this plugin provide Payment list? =
*	Yes, this plugin provide payment list, without do any thing :)

= Does this plugin provide multi currency support? =
*	Yes, this plugin provide multi currency support.

= does this plugin provide widget support? =
*	Yes.

= does this plugin provide custom button option? =
*	Yes, this plugin provide custome button option, as well no. of button list.

= does this plugin provide monthly recurring option? =
*	Yes. 

== Changelog ==
= 1.1.6 =
*   Easy Payment working very well.
= 1.1.5 =
*   Add some functionality.
= 1.1.4 =
*   Email notification.
= 1.1.3 =
*   Tested up to 4.5
= 1.1.2 =
*   Payment insert into payment list.
= 1.1.1 =
*   Email functionlaity not working on paypal live mode.
= 1.1.0 =
*   add some functionality.
= 1.0.9 =
*   How to add this plugin to Menu bar.
= 1.0.8 =
*   PayPal button and multi currency display.
= 1.0.7 =
*   allow spacial character in shortcode.
= 1.0.6 =
*   add quantity box front-end.
= 1.0.5 =
*   Enqueue scripts and styles error (jzatt).
= 1.0.4 =
*   Update Version.
= 1.0.3 = 
*   Add Post Id In Payment list.
= 1.0.2 = 
*   create shortcode with set button align.
= 1.0.1 = 
*   add thickbox with create shortcode.
= 1.0.0 =
*	Release Date - 1/9/2015
*  	First Version


== Upgrade Notice ==
first commit