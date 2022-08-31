<?php
/**
* 2019-2021 gamiphy
*
* Gamiphy OF LICENSE
*
* Gamiphy License
*
* DISCLAIMER
*
* Do not edit or add to this file
*
*  @author    Gamiphy
*  @copyright 2019-2021 Gamiphy
*  @license   Gamiphy
*/

class GamiphyWebhooksModuleFrontController extends ModuleFrontController
{
    /*Update Configuration with webhooks data*/
    public function initContent()
    {
        if (!$this->module->verifyAccessToken()) {
            echo Tools::jsonEncode(array(
                'success' => false,
                'error' => $this->l($this->module->translateStrings['invalid_token'])
            ));
            die;
        }

        $json = Tools::file_get_contents('php://input');

        $webhooksData = Tools::jsonDecode($json, true);

        if (isset($webhooksData['action']) && $webhooksData['action']) {
            switch ($webhooksData['action']) {
                case 'getList':
                        $this->getWebhooksList();
                    break;
                case 'deleteWebhook':
                        $this->deleteWebhook($webhooksData['event']);
                    break;
                
                default:
                    break;
            }
        }

        $webhookUrls = $this->module->webhookUrls;

        if (!is_array($webhookUrls)) {
            $webhookUrls = array();
        }

        $webhookUrls[$webhooksData['event']]['url'] = $webhooksData['url'];
        $webhookUrls[$webhooksData['event']]['headers'] = $webhooksData['headers'];

        Configuration::updateValue('gamiphy_webhook_urls', Tools::jsonEncode($webhookUrls));

        echo Tools::jsonEncode(array(
            'success' => true,
            'message' => $this->l($this->module->translateStrings['webhook_updated'])
        ));
        die;
    }

    /*Provide list of all configured webhooks*/
    public function getWebhooksList()
    {
        $webhookUrls = $this->module->webhookUrls;

        echo Tools::jsonEncode(array('success' => true, 'webhooks' => $webhookUrls));
        die;
    }

    /*Delete any of the configured webhook*/
    public function deleteWebhook($event)
    {
        $webhookUrls = $this->module->webhookUrls;

        unset($webhookUrls[$event]);
        Configuration::updateValue('gamiphy_webhook_urls', Tools::jsonEncode($webhookUrls));

        echo Tools::jsonEncode(array(
            'success' => true,
            'message' => $event.' '.$this->l($this->module->translateStrings['webhook_deleted'])
        ));
        die;
    }
}
