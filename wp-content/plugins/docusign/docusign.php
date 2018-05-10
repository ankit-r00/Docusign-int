<?php
    /*
        Plugin Name: DocuSign Integration
        Description: Integrate DocuSign with your site. Gives the capability so that you can call the DocuSign template and show it on your site and accept/reject it.
        Author: ITHands
        Version: 1.0.0
        Author URI: https://www.ithands.com
    */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
require_once('docuSignCore.php');

class DocuSign
{
    /**
     * DocuSign constructor.
     */
    function __construct()
    {
        add_action('admin_menu', array($this, 'docusign_menu_page'), 30);
    }

    /**
     * Register a DocuSign menu page
     */
    function docusign_menu_page()
    {
        add_menu_page(
            __('DocuSign', 'docusign'),
            'DocuSign',
            'manage_options',
            'docusign/docusign-admin.php',
            '',
            plugins_url('docusign/images/icon.png')
        );
        // $this->signatureRequest();
    }

    /**
     * Main functions that redirect the user to e-Sign
     */
    // function signatureRequest()
    // {
    //     $fieldValues = $this->getOptionValues();
    //     $DocuSignCore = new DocuSignCore();
    //     $DocuSignCore->withinApp($fieldValues);
    // }
    //
    // /**
    //  * Retrieves all the form field values
    //  * @return mixed|void
    //  */
    function getOptionValues()
    {
        $docuSignValues = get_option('docuSign');
        return $docuSignValues;
    }
}

new DocuSign();
$docuSignValues = get_option('docuSign');
if (!empty($docuSignValues)) {

include( plugin_basename( '/terms.php' ) );
}

function docusign_scripts() {
    wp_deregister_script( 'jquery-core' );
    wp_register_script( 'jquery-core', "https://code.jquery.com/jquery-3.1.1.min.js", array(), '3.1.1' );
//
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
  }

  add_action( 'wp_enqueue_scripts', 'docusign_scripts' );
