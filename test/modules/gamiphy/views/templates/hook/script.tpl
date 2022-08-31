{*
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
*  @copyright 2019-2022 Gamiphy
*  @license   Gamiphy
*}

{literal}
<script type="text/javascript">
    window.gamiphyAsyncInit = function (sdk) {
        function gup(name, url) {
            if (!url) url = location.href;
            name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
            var regexS = "[\\?&]" + name + "=([^&#]*)";
            var regex = new RegExp(regexS);
            var results = regex.exec(url);
            return results == null ? null : results[1];
        }

        sdk.init({
            app: "{/literal}{$gamiphy_app_id|escape:'javascript':'UTF-8'}{literal}",
            {/literal}
            {if $gamiphy_customer_id}
            {literal}
            user: {
                externalId: "{/literal}{$gamiphy_customer_id|escape:'javascript':'UTF-8'}{literal}",
                email: "{/literal}{$gamiphy_customer_email|escape:'javascript':'UTF-8'}{literal}",
                firstName: "{/literal}{$gamiphy_customer_firstname|escape:'javascript':'UTF-8'}{literal}",
                lastName: "{/literal}{$gamiphy_customer_lastname|escape:'javascript':'UTF-8'}{literal}",
                hash: '{/literal}{$gamiphy_customer_hash|escape:'javascript':'UTF-8'}{literal}',
            },
            {/literal}
            {/if}
            {literal}
            goToAuth: (isSignUp) => {
                if (isSignUp) {
                    window.location.href = '/login?create_account=1'
                } else {
                    window.location.href = '/login'
                }
            },
            visible: !window.location.href.includes('/login'),
            currency: {
                code: '{/literal}{$gamiphy_currency_iso|escape:'javascript':'UTF-8'}{literal}',
                exchangeRate: {/literal}{$gamiphy_currency_conversion_rate|escape:'javascript':'UTF-8'}{literal}
            }
        });

        if (typeof prestashop !== 'undefined') {
            switch (prestashop.page.page_name) {
                case "product": {
                    var productId = document.querySelector('input[name=id_product]').value;
                    if (productId) {
                        sdk.collectProductView(productId)
                    }
                    break;
                }
                case "order-confirmation": {
                    const orderId = gup('id_order', window.location.href);
                    if (orderId) {
                        sdk.collectOrderPlace(orderId)
                    }
                    break;
                }
            }
        }
    }
</script>
<script src="{/literal}{$gamiphy_sdk_url|escape:'javascript':'UTF-8'}{literal}"></script>
{/literal}