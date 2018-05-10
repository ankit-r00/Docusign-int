<?php
$DocuSignObj = new DocuSign();
$fieldValues = $DocuSignObj->getOptionValues();
if (isset($_POST['submit'])) { //check if form was submitted
    $docuSign = array();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $intKey = $_POST['intKey'];
    $host = $_POST['host'];
    $emailSub = $_POST['emailSub'];
    $templateID = $_POST['templateID'];
    $recep_role = $_POST['role'];
    $returnURL = $_POST['returnURL'];
    $docuSign['username'] = $username;
    $docuSign['password'] = $password;
    $docuSign['intKey'] = $intKey;
    $docuSign['host'] = $host;
    $docuSign['emailSub'] = $emailSub;
    $docuSign['templateID'] = $templateID;
    $docuSign['role'] = $recep_role;
    $docuSign['returnURL'] = $returnURL;
    if (!$fieldValues)
        add_option('docuSign', $docuSign, '', 'yes');
    else
        update_option('docuSign', $docuSign);
    $message = "Details Saved Successfully";
    echo "<label>" . $message . "</label>";
}
?>
<div class="wrap">
    <h2>
        <?php esc_html_e('DocuSign Settings', 'docusign'); ?>
    </h2>
    <form method="post" action="#">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="username"><?php esc_html_e('User Name', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="username" type="text" id="username"
                           value="<?php print(isset($username) ? $username : $fieldValues['username']); ?>"
                           size="40" class="regular-text" required/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="password"><?php esc_html_e('Password', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="password" type="password" id="password"
                           value="<?php print(isset($password) ? $password : $fieldValues['password']); ?>"
                           size="40" class="regular-text" required/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="intKey"><?php esc_html_e('Integrator Key', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="intKey" type="text" id="intKey"
                           value="<?php print(isset($intKey) ? $intKey : $fieldValues['intKey']); ?>"
                           size="40" class="regular-text" required/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="host"><?php esc_html_e('Host', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="host" type="text" id="host"
                           value="<?php print(isset($host) ? $host : $fieldValues['host']); ?>"
                           size="40" class="regular-text" required/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="emailSub"><?php esc_html_e('Email Subject', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="emailSub" type="text" id="emailSub"
                           value="<?php print(isset($emailSub) ? $emailSub : $fieldValues['emailSub']); ?>"
                           size="40" class="regular-text" required/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="templateID"><?php esc_html_e('Template ID', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="templateID" type="text" id="templateID"
                           value="<?php print(isset($templateID) ? $templateID : $fieldValues['templateID']); ?>"
                           size="40" class="regular-text" required/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="recipientrole"><?php esc_html_e('Recipient Role', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="role" type="text" id="role"
                           value="<?php print(isset($role) ? $role : $fieldValues['role']); ?>"
                           size="40" class="regular-text"/>
                </td>
                <td>
                  <h6>*Recipient role would be same as recipient role of selected template in your DocuSign account.</h6>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="returnURL"><?php esc_html_e('Return URL', 'docusign'); ?></label>
                </th>
                <td>
                    <input name="returnURL" type="text" id="returnURL"
                           value="<?php print(isset($returnURL) ? $returnURL : $fieldValues['returnURL']); ?>"
                           size="40" class="regular-text" required/>
                </td>
            </tr>
        </table>
        <p class="wp-docusign-submit">
            <input type="submit" name="submit" id="submit" class="button button-primary button-large">
        </p>
    </form>
</div>
