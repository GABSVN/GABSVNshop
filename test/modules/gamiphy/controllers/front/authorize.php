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

class GamiphyAuthorizeModuleFrontController extends ModuleFrontController
{
    /*Generate and send access token to gamiphy app*/

    public function initContent()
    {
        $result = array();

        if ($this->module->verifyToken()) {
            $apiAccess = new WebserviceKey(Configuration::get('GAMIPHY_WEBSERVICE_KEY_ID'));

            if (Validate::isLoadedObject($apiAccess) && $apiAccess->active) {
                Configuration::updateValue('GAMIPHY_SHORT_LIVE_CODE', null);
                Configuration::updateValue('GAMIPHY_SHORT_LIVE_CODE_EXPIRY', null);
                Configuration::updateValue('GAMIPHY_ACCESS_TOKEN', $apiAccess->key);
                $result['success'] = true;
                $result['access_token'] = $apiAccess->key;
            } elseif (Validate::isLoadedObject($apiAccess)) {
                $apiAccess->active = true;
                if ($apiAccess->save()) {
                    $result['success'] = true;
                    $result['access_token'] = $apiAccess->key;
                } else {
                    $result['success'] = false;
                    $result['error'] = $this->l($this->module->translateStrings['access_token_error']);
                }
            } else {
                Configuration::updateValue('PS_WEBSERVICE', 1);
                $apiAccess = new WebserviceKey();
                $apiAccess->key = Tools::hash(uniqid());
                $apiAccess->description = $this->l($this->module->translateStrings['webservice_key_desc']);
                if ($apiAccess->save()) {
                    $permissions = [
                        'addresses' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'authorize' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'carriers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'carts' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'cart_rules' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'categories' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'combinations' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'configurations' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'contacts' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'countries' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'currencies' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'customers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'customer_threads' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'customer_messages' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'deliveries' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'groups' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'guests' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'images' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'image_types' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'languages' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'manufacturers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'messages' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'order_carriers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'order_details' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'order_histories' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'order_invoices' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'orders' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'order_payments' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'order_states' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'order_slip' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'price_ranges' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'specific_price_rules' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'specific_prices' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'product_features' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'product_feature_values' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'product_options' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'product_option_values' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'product_suppliers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'products' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'customizations' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'product_customization_fields' => [
                            'GET' => 1,
                            'POST' => 1,
                            'PUT' => 1,
                            'DELETE' => 1,
                            'HEAD' => 1
                        ],
                        'states' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'stores' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'suppliers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'tags' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'translated_configurations' => [
                            'GET' => 1,
                            'POST' => 1,
                            'PUT' => 1,
                            'DELETE' => 1,
                            'HEAD' => 1
                        ],
                        'weight_ranges' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'zones' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'employees' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'search' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'content_management_system' => [
                            'GET' => 1,
                            'POST' => 1,
                            'PUT' => 1,
                            'DELETE' => 1,
                            'HEAD' => 1
                        ],
                        'shops' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'shop_groups' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'taxes' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'stock_movements' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'stock_movement_reasons' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'warehouses' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'stocks' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'stock_availables' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'warehouse_product_locations' => [
                            'GET' => 1,
                            'POST' => 1,
                            'PUT' => 1,
                            'DELETE' => 1,
                            'HEAD' => 1
                        ],
                        'supply_orders' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'supply_order_details' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'supply_order_details' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'supply_order_histories' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'supply_order_receipt_histories' => [
                            'GET' => 1,
                            'POST' => 1,
                            'PUT' => 1,
                            'DELETE' => 1,
                            'HEAD' => 1
                        ],
                        'supply_order_states' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'tax_rules' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'tax_rule_groups' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                        'shop_urls' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'DELETE' => 1, 'HEAD' => 1],
                    ];
                    WebserviceKey::setPermissionForAccount($apiAccess->id, $permissions);

                    Configuration::updateValue('GAMIPHY_WEBSERVICE_KEY_ID', $apiAccess->id);
                    Configuration::updateValue('GAMIPHY_SHORT_LIVE_CODE', null);
                    Configuration::updateValue('GAMIPHY_SHORT_LIVE_CODE_EXPIRY', null);
                    Configuration::updateValue('GAMIPHY_ACCESS_TOKEN', $apiAccess->key);
                    $result['success'] = true;
                    $result['access_token'] = $apiAccess->key;
                } else {
                    $result['success'] = false;
                    $result['error'] = $this->l($this->module->translateStrings['access_token_error']);
                }
            }
        } else {
            $result['success'] = false;
            $result['error'] = $this->l($this->module->translateStrings['invalid_token']);
        }
        echo Tools::jsonEncode($result);
        die;
    }
}
