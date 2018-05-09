<?php
/**
* terms.php
* Load the function to overwrite woocommerce
* @package redirect
* @version 1.0
*/

/*===================
woocommerce term and condition page
=====================*/
// For cart page: replacing proceed to checkout button
add_action('woocommerce_proceed_to_checkout', 'change_proceed_to_checkout', 1);
function change_proceed_to_checkout()
{
  remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
  add_action('woocommerce_proceed_to_checkout', 'custom_button_proceed_to_custom_page', 20);
}

// Cart page: Displays the replacement custom button linked to your custom page
function custom_button_proceed_to_custom_page()
{
  $button_name = esc_html__('Proceed to checkout', 'woocommerce'); // <== button Name
  $button_link = plugins_url("docusign-integration/abc.php"); // <== Set here the page ID or use home_url() function

  ?>
  <a href="<?php echo $button_link; ?>" class="checkout-button button alt wc-forward">
    <?php echo $button_name; ?>
  </a>
  <?php
}
