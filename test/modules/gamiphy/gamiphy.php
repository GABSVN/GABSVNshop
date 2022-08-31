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
 * @author    Gamiphy
 * @copyright 2019-2021 Gamiphy
 * @license   Gamiphy
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Gamiphy extends Module
{
    public $env = null;

    public $access_token = null;

    public $app_id = null;

    public $app_key = null;

    public $sdk_url = null;

    public $api_base_url;

    public $dashboard_url;

    public $short_live_code = null;

    public $short_live_code_expiry = null;

    public $webhookUrls = null;

    public $track_enable = false;

    public $translateStrings = array(
        'confirmUninstall' => 'Are you sure you want to uninstall?',
        'invalid_token' => 'Invalid Token',
        'webhook_updated' => 'Webhook updated successfully',
        'webhook_deleted' => 'webhook deleted successfully',
        'access_token_error' => 'Error creating access token, Please contact administrator',
        'webservice_key_desc' => 'Gamiphy generated token- do not delete',
    );

    public function __construct()
    {
        $DASHBOARD_URLS = array(
            'dev' => 'https://dashboard.dev.gamiphy.co/prestashop/authorize',
            'staging' => 'https://dashboard.staging.gamiphy.co/prestashop/authorize',
            'prod' => 'https://dashboard.gamiphy.co/prestashop/authorize'
        );

        $API_BASE_URLS = array(
            'dev' => 'https://api.dev.gamiphy.co',
            'staging' => 'https://api.staging.gamiphy.co',
            'prod' => 'https://api.gamiphy.co'
        );

        /**
         * This is added to support backward compatability for stores installed version  < 1.2.0
         * @deprecated
         */
        $SDK_URLS = array(
            'dev' => 'https://static-dev.gamiphy.co/sdk/loyalty-station/main.js',
            'staging' => 'https://static-staging.gamiphy.co/sdk/loyalty-station/main.js',
            'prod' => 'https://static.gamiphy.co/sdk/loyalty-station/main.js'
        );

        $this->name = 'gamiphy';
        $this->tab = 'front_office_features';

        $this->version = '1.2.1';
        $this->env = 'prod';

        $this->author = 'Gamiphy';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        $this->api_base_url = $API_BASE_URLS[$this->env];
        $this->dashboard_url = $DASHBOARD_URLS[$this->env];

        parent::__construct();

        $this->displayName = $this->l('- Loyalty Station -');
        $this->description = $this->l(
            'Empower your store with gamified Loyalty and social experiences that boost your sales and conversions'
        );
        $this->confirmUninstall = $this->l($this->translateStrings['confirmUninstall']);
        $this->initializeConfigValues();
        $this->module_key = 'ed8652b845e972c3fc9b25eb7f224853';
    }

    /*Register hooks for webhooks*/

    public function install()
    {
        return parent::install() &&
            $this->updateConfigValues() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('actionObjectProductAddAfter') &&
            $this->registerHook('actionProductUpdate') &&
            $this->registerHook('actionProductDelete') &&
            $this->registerHook('actionValidateOrder') &&
            $this->registerHook('actionObjectOrderUpdateAfter');
    }

    /*Add/Update Default config values*/

    public function updateConfigValues()
    {
        return Configuration::updateValue('GAMIPHY_APP_ID', '') &&
            Configuration::updateValue('GAMIPHY_APP_KEY', '') &&
            Configuration::updateValue('GAMIPHY_ENABLE', false);
    }

    /*Uninstall webhook call*/

    public function uninstall()
    {
        $this->updateGamiphy('uninstall');

        return parent::uninstall();
    }

    /*Initialize configuration values on page load*/

    public function initializeConfigValues()
    {
        $this->access_token = Configuration::get('GAMIPHY_ACCESS_TOKEN');
        $this->app_id = Configuration::get('GAMIPHY_APP_ID');
        $this->app_key = Configuration::get('GAMIPHY_APP_KEY');

        $this->short_live_code = Configuration::get('GAMIPHY_SHORT_LIVE_CODE');
        $this->short_live_code_expiry = Configuration::get('GAMIPHY_SHORT_LIVE_CODE_EXPIRY');
        $this->webhookUrls = Tools::jsonDecode(Configuration::get('gamiphy_webhook_urls'), true);

        // Fallback added to support backward compatability for stores installed version  < 1.2.0
        $this->sdk_url = Configuration::get('GAMIPHY_SDK_URL') ?: $this->SDK_URL[$this->env];
        $this->track_enable = Configuration::get('GAMIPHY_ENABLE') ?: Configuration::get('gamiphy_enable');
    }

    /*Add gamiphy js scipt on pages*/

    public function hookDisplayHeader()
    {
        if (!$this->track_enable) {
            return;
        }

        $user_hash = hash_hmac('sha256', $this->app_id . '|' . $this->context->customer->email, $this->app_key);

        $this->context->smarty->assign(array(
            'gamiphy_app_id' => $this->app_id,
            'gamiphy_customer_id' => $this->context->customer->id,
            'gamiphy_customer_email' => $this->context->customer->email,
            'gamiphy_customer_firstname' => $this->context->customer->firstname,
            'gamiphy_customer_lastname' => $this->context->customer->lastname,
            'gamiphy_customer_hash' => $user_hash,
            'gamiphy_sdk_url' => $this->sdk_url,
            'gamiphy_currency_iso' => $this->context->currency->iso_code,
            'gamiphy_currency_conversion_rate' => $this->context->currency->conversion_rate,
        ));

        return $this->display(__FILE__, 'script.tpl');
    }

    /*Generate short code to be sent to app dashboard*/

    public function generateShortCode()
    {
        $short_live_code = Tools::hash(uniqid());
        $minutes_add = 60;
        $time = new DateTime();
        $time->add(new DateInterval('PT' . $minutes_add . 'M'));
        $short_live_code_expiry = $time->format('Y-m-d H:i:s');
        Configuration::updateValue('GAMIPHY_SHORT_LIVE_CODE', $short_live_code);
        Configuration::updateValue('GAMIPHY_SHORT_LIVE_CODE_EXPIRY', $short_live_code_expiry);
        return $short_live_code;
    }

    /*Redirect to app dashboard with short code and shop url*/

    public function getContent()
    {
        $short_live_code = $this->generateShortCode();
        $redirect_url = $this->dashboard_url .
            '?shop_url=' . rtrim(_PS_BASE_URL_SSL_ . __PS_BASE_URI__, '/') .
            '&code=' . $short_live_code;

        Tools::redirectAdmin($redirect_url);
    }

    /*Webhook call after product add*/

    public function hookActionObjectProductAddAfter($params)
    {
        $this->updateGamiphy('productAdded', $params['object']->id);
    }

    /*Webhook call after product update*/

    public function hookActionProductUpdate($params)
    {
        $this->updateGamiphy('productUpdated', $params['id_product']);
    }

    /*Webhook call after product update*/

    public function hookActionProductDelete($params)
    {
        $this->updateGamiphy('productDeleted', $params['id_product']);
    }

    /*Webhook call after order Add*/

    public function hookActionValidateOrder($params)
    {
        $this->updateGamiphy(
            'orderAdded',
            $params['order']->id,
            $params['order'],
            $params['orderStatus']->id
        );
    }

    /*Webhook call after order update*/

    public function hookActionObjectOrderUpdateAfter($params)
    {
        $this->updateGamiphy(
            'orderUpdated',
            $params['object']->id,
            $params['object'],
            $params['object']->current_state
        );
    }

    /*Send webhook data to gamiphy app*/

    public function updateGamiphy($event, $model_id = false, $orderModel = false, $orderStatus = false)
    {
        if (!$this->access_token) {
            return;
        }

        $webhookUrls = $this->webhookUrls;

        if ((isset($webhookUrls[$event]) && isset($webhookUrls[$event]['url']) && $webhookUrls[$event]['url']) ||
            $event == 'uninstall'
        ) {
            $postData = array(
                'url' => rtrim(_PS_BASE_URL_SSL_ . __PS_BASE_URI__, '/'),
                'event' => $event
            );

            if ($model_id !== false) {
                $postData['model_id'] = $model_id;
                $postData['cart_rule_id'] = [];
                $postData['current_order_status'] = [];

                if ($orderModel) {
                    $cartRuleIds = array();
                    $cartRules = $orderModel->getCartRules();

                    if ($cartRules) {
                        foreach ($cartRules as $cartRule) {
                            $cartRuleIds[] = $cartRule['id_cart_rule'];
                        }
                    }
                    $postData['cart_rule_id'] = $cartRuleIds;
                }

                if ($orderStatus) {
                    $postData['current_order_status'] = $orderStatus;
                }
            }

            $vars = Tools::jsonEncode($postData);

            $ch = curl_init();
            if ($event == 'uninstall') {
                $url = $this->api_base_url . '/v2/accounts/apps/' . $this->app_id . '/hooks';
            } else {
                $url = $webhookUrls[$event]['url'];
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [];

            if (isset($webhookUrls[$event]['headers']) && $webhookUrls[$event]['headers']) {
                $headers = $webhookUrls[$event]['headers'];
            }

            if ($event == 'uninstall') {
                $headers['Content-Type'] = 'application/json';
            }

            $headers['Gamiphy-Signature'] = hash_hmac(
                "sha512",
                $vars,
                $this->access_token
            );

            $headersForCurl = [];

            foreach ($headers as $key => $header) {
                $headersForCurl[] = $key . ":" . $header;
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headersForCurl);

            curl_exec($ch);

            curl_close($ch);
        }
    }

    /*Verify short code for auth process*/

    public function verifyToken()
    {
        $time = new DateTime();
        $current_time = $time->format('Y-m-d H:i');

        return (bool)(
            $this->short_live_code &&
            $this->short_live_code === Tools::getValue('gamiphy_key') &&
            $this->short_live_code_expiry >= $current_time
        );
    }

    /*Verify access token for webhook configuration calls*/

    public function verifyAccessToken()
    {
        return (bool)($this->access_token && $this->access_token !== Tools::getValue('gamiphy_key'));
    }
}
