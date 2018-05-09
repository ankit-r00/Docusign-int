<?php

require_once('vendor/autoload.php');

class DocuSignCore
{
    /**
     * Actual code the redirects the user for E sign and then redirects back to the site
     * @param $fieldValues
     */
    public function withinApp()
    {
        $var = get_option('docuSign');
        $c_name =$_POST['name'];
        $c_email =$_POST['email'];
        $username = $var['username'];
        $password = $var['password'];
        $integrator_key = $var['intKey'];

        // change to production (www.docusign.net) before going live
        $host = $var['host'];

        // create configuration object and configure custom auth header
        $config = new DocuSign\eSign\Configuration();
        $config->setHost($host);
        $config->addDefaultHeader("X-DocuSign-Authentication", "{\"Username\":\"" . $username . "\",\"Password\":\"" . $password . "\",\"IntegratorKey\":\"" . $integrator_key . "\"}");

        // instantiate a new docusign api client
        $apiClient = new DocuSign\eSign\ApiClient($config);
        $accountId = null;

        try {
            //*** STEP 1 - Login API: get first Account ID and baseURL
            $authenticationApi = new DocuSign\eSign\Api\AuthenticationApi($apiClient);
            $options = new \DocuSign\eSign\Api\AuthenticationApi\LoginOptions();
            $loginInformation = $authenticationApi->login($options);
            if (isset($loginInformation) && count($loginInformation) > 0) {
                $loginAccount = $loginInformation->getLoginAccounts()[0];
                $host = $loginAccount->getBaseUrl();
                $host = explode("/v2", $host);
                $host = $host[0];

                // UPDATE configuration object
                $config->setHost($host);

                // instantiate a NEW docusign api client (that has the correct baseUrl/host)
                $apiClient = new DocuSign\eSign\ApiClient($config);

                if (isset($loginInformation)) {
                    $accountId = $loginAccount->getAccountId();
                    if (!empty($accountId)) {
                        //*** STEP 2 - Signature Request from a Template
                        // create envelope call is available in the EnvelopesApi
                        $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi($apiClient);
                        // assign recipient to template role by setting name, email, and role name.  Note that the
                        // template role name must match the placeholder role name saved in your account template.
                        $templateRole = new  DocuSign\eSign\Model\TemplateRole();
                        $templateRole->setEmail($c_email);
                        $templateRole->setName($c_name);
                        $templateRole->setRoutingOrder('1');
                        $templateRole->setRoleName("signer1");

                        // instantiate a new envelope object and configure settings
                        $envelop_definition = new DocuSign\eSign\Model\EnvelopeDefinition();
                        $envelop_definition->setEmailSubject($var['emailSub']);
                        $envelop_definition->setTemplateId($var['templateID']);
                        $envelop_definition->setTemplateRoles(array($templateRole));

                        // set envelope status to "sent" to immediately send the signature request
                        $envelop_definition->setStatus("sent");

                        // optional envelope parameters
                        $options = new \DocuSign\eSign\Api\EnvelopesApi\CreateEnvelopeOptions();
                        $options->setCdseMode(null);
                        $options->setMergeRolesOnDraft(null);

                        // create and send the envelope (aka signature request)
                        $envelop_summary = $envelopeApi->createEnvelope($accountId, $envelop_definition, $options);
                        if (!empty($envelop_summary)) {
                            $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi($apiClient);
                            $recipient_view_request = new \DocuSign\eSign\Model\RecipientViewRequest();
                            $recipient_view_request->setReturnUrl(home_url() . $var['returnURL']);
                            $recipient_view_request->setUserName($c_name);
                            $recipient_view_request->setEmail($c_email);
                            $recipient_view_request->setClientUserId();
                            $recipient_view_request->setAuthenticationMethod("email");
                            $signingView = $envelopeApi->createRecipientView($accountId, $envelop_summary->getEnvelopeId(), $recipient_view_request);
                            ?>
                            <script>location.href='<?php echo $signingView['url']; ?>';</script>";
                            <?php
                        }
                    }
                }
            }
        } catch (DocuSign\eSign\ApiException $ex) {
            echo "Exception: " . $ex->getMessage() . "\n";
        }
    }
}
