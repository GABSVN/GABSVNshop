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
{extends "customer/_partials/customer-form.tpl"}

{block "form_field"}
  {if $field.name === 'password' and $guest_allowed}
      <p>
        <span class="font-weight-bold">{l s='Create an account' d='Shop.Theme.Checkout'}</span> <span class="font-italic">{l s='(optional)' d='Shop.Theme.Checkout'}</span>
        <br>
        <span class="text-muted">{l s='And save time on your next order!' d='Shop.Theme.Checkout'}</span>
      </p>
      {$smarty.block.parent}
  {else}
    {$smarty.block.parent}
  {/if}
{/block}

{block "form_buttons"}
    <button
      class="continue btn btn-primary float-xs-right"
      name="continue"
      data-link-action="register-new-customer"
      type="submit"
      value="1"
    >
        {l s='Continue' d='Shop.Theme.Actions'}
    </button>
{/block}