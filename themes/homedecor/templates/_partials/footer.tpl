{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
{* <div class="container">
  <div class="row">
    {block name='hook_footer_before'}
      {hook h='displayFooterBefore'}
    {/block}
  </div>
</div> *}
<div class="footer-container">
  <div class="container">
    {* <div class="row">
    {renderLogo}
      {block name='hook_footer'}
        {hook h='displayFooter'}
      {/block}
    </div> *}
    {* <div class="row">
      {block name='hook_footer_after'}
        {hook h='displayFooterAfter'}
      {/block}
    </div> *}
    <div class="footer-content">
      <div class="footer-logo col-md-12">{renderLogo}<small>SOUMAD | INTERIOR DESIGN</small></div>
      <div>
        <div class="footer-links  col-md-6">{hook h='displayFooter' mod='ps_linklist'}</div>
        <div class="footer-address  col-md-6">{hook h="displayFooter" mod="ps_contactinfo"}</div>
      </div>
      <div class="footer-newsletter  col-md-12">
      {hook h="displayFooterBefore" mod="ps_emailsubscription"}
      {hook h="displayFooterBefore" mod="ps_socialfollow"}
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p class="text-sm-center">
          {block name='copyright_link'}
            <a class="copyright" href="{$link->getCMSLink(3)}" target="_blank" rel="noopener noreferrer nofollow">
              {l s='A CASA DE CAMPO © 2024. %reservados%' sprintf=['%reservados%' => 'Todos os direitos reservados.'] d='Shop.Theme.Global'}
            </a>
          {/block}
        </p>
      </div>
    </div>
  </div>
</div>
