{**
 * 2007-2019 GABSVNshop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@GABSVNshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade GABSVNshop to newer
 * versions in the future. If you wish to customize GABSVNshop for your
 * needs please refer to https://www.gabsvn.ch for more information.
 *
 * @author    GABSVNshop SA <contact@GABSVNshop.com>
 * @copyright 2007-2019 GABSVNshop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of GABSVNshop SA
 *}
{extends file='customer/page.tpl'}

{block name='page_title'}
  {if $editing}
    {l s='Update your address' d='Shop.Theme.Customeraccount'}
  {else}
    {l s='New address' d='Shop.Theme.Customeraccount'}
  {/if}
{/block}

{block name='page_content'}
  <div class="address-form">
    {render template="customer/_partials/address-form.tpl" ui=$address_form}
  </div>
{/block}
