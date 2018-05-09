<?php
/**
* term.php
* Load the function to overwrite woocommerce
* @package redirect
* @version 1.0
*/
?>
<?php

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
  // $button_link = plugins_url("docusign-integration/abc.php"); // <== Set here the page ID or use home_url() function

  ?>
  <div class="container">
    <!-- Trigger the modal with a button -->
    <button type="button" class="checkout-button button alt wc-forward" data-toggle="modal" data-target="#myModal"><?php echo $button_name; ?></button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <form method="post">
        <div class="modal-content">
          <div class="modal-header">
          </br>
            <h4 class="modal-title">Signing ceremony:</h4>
          </div>
          <div class="modal-body">
            <input type="text" name="name" placeholder="Name" required/>
          </br>
            <input type="email" name="email" placeholder="Email" required/>
          </div>
          <div class="modal-footer">
          </br>
           <center><input type="submit" name="sub" id="sub" value="<?php echo $button_name; ?>" class="checkout-button button alt wc-forward" width=""/></center>
         </div>
      </div>
      </form>
      </div>
      </div>
      <script>
      $(document).ready(function(){
        $("#myModal").hide();
          $("button").click(function(){
              $("#myModal").toggle("slow");
              $("button").hide();
          });
      });
      </script>
<?php
}

if(array_key_exists('sub',$_POST)){
   signatureRequest();
}

function signatureRequest()
{

    $DocuSignCore = new DocuSignCore();
    $DocuSignCore->withinApp();
}
