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
 {* {assign var="categories" value=$categories[2]} *}
 {assign var="category_home" value=$categories[1][2]['infos']}
 {assign var="categories_parent" value=$categories[2]}
 {assign var="categories_child" value=$categories[4]}
 {assign var="currentUrl" value="http://"|cat:$smarty.server.HTTP_HOST|cat:$smarty.server.REQUEST_URI}

{block name='header_banner'}
  <div class="header-banner">
    {hook h='displayBanner'}
  </div>
{/block}

{block name='header_nav'}
  <nav class="header-nav">
    <div class="container">
      <div class="row">
        <div class="hidden-md-up">
          <div class="col-md-5 col-xs-12">
            {hook h='displayNav1'}
          </div>
          <div class="col-md-7 right-nav">
              {hook h='displayNav2'}
          </div>
        </div>
        <div class="hidden-md-up text-sm-center mobile">
          <div class="float-xs-left" id="menu-icon">
            <i class="material-icons d-inline">&#xE5D2;</i>
          </div>
          <div class="float-xs-right" id="_mobile_cart"></div>
          <div class="float-xs-right" id="_mobile_user_info"></div>
          <div class="top-logo" id="_mobile_logo"></div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </nav>
{/block}

{block name='header_top'}
  <div class="header-top">
    <div class="container">
       <div class="row">
        <div class="col-md-2 hidden-sm-down" id="_desktop_logo">
          {if $shop.logo_details}
            {if $page.page_name == 'index'}
              <h1>
                {renderLogo}
              </h1>
              <small>SOUMAD | INTERIOR DESIGN</small>
            {else}
              {renderLogo}
            {/if}
          {/if}
        </div>

        <div class="menu hidden-md-down">
          <ul class="menu-list">
            <li class="menu-item"><a class="activeMenu" onclick="activateLink(this)" href="/">Inicio</a></li>
            <li class="menu-item dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Lifestyle
              <span class="caret"></span></button>
              <ul class="dropdown-menu drop1">
                <div class="links-dropdown">
                  <li><a href="{$link->getCMSLink(6)}" onclick="activateLink(this)">Blog</a></li>
                  <li><a href="#" onclick="activateLink(this)">Vlog</a></li>
                </div>
                <div class="dropdown-imgs">
                  {foreach from=$blogs item=blog}
                    <div class="container-img-drop">
                      <img src="/img/leoblog/b/1/{$blog.id_leoblog_blog}/1160_550/{$blog.thumb}"  loading="lazy" />
                      <h1><a href="{$blog.link_rewrite}">{$blog.meta_title}</a></h1>
                      <p><a href="{$blog.link_rewrite}">Explore Blog</a></p>
                    </div>
                  {/foreach}
                </div>
              </ul>
            </li>
            <li class="menu-item dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Design
              <span class="caret"></span></button>
              <ul class="dropdown-menu drop2">
              <div class="links-dropdown">
                <li><a href="#" onclick="activateLink(this)">Projetos</a></li>
                <li><a href="/#services-section" onclick="activateLink(this)">Serviços</a></li>
                <li><a href="/#contact-us" onclick="activateLink(this)">Contacte-nos</a></li>
              </div>
              <div class="dropdown-imgs">
                  <div class="grid_imgs_dropdown1">
                    <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"/>
                    <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                    <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                    <div class="design3"></div>
                    <div  class="design4"></div>
                    <div  class="design6"></div>
                    
                  </div>
                </div>
              </ul>
            </li>
            <li class="menu-item dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">A Nossa Loja
              <span class="caret"></span></button>
              <ul class="dropdown-menu drop3">
              <div class="links-dropdown">
                <li><a href="/#about-us-section" onclick="activateLink(this)">Sobre Nós</a></li>
              </div>
              <div class="dropdown-imgs">
                <div class="grid_imgs_dropdown3">
                      <div class="about1"></div>
                      <div class="about4"></div>
                      <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                      <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"/>
                </div>
              </div>
              </ul>
            </li>
            <li class="menu-item dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Loja
              <span class="caret"></span></button>
              <ul class="dropdown-menu drop4">
              {* <pre>{$categories_child|print_r}</pre> *}
                <div class="links-dropdown">
                <li><a href="/index.php?controller=new-products" onclick="activateLink(this)">Novidades</a></li>
                  {foreach from=$categories_parent item=category key=key}
                    <li><a href="{$category['infos']['id_category']}-{$category['infos']['link_rewrite']}" onclick="activateLink(this);">{$category['infos']['name']}</a></li>
                  {/foreach}
                  <li><a href="{$category_home.id_category}-{$category_home.link_rewrite}" onclick="activateLink(this)">Todas</a></li>
                </div>
                <div class="dropdown-imgs">
                  <div class="grid_imgs_dropdown2">
                    <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"  />
                    <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                    <img data-src="https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                  </div>
                </div>
                
                
              </ul>
            </li>
            
          </ul>
        </div>
        <div class="header-top-right hidden-md-down col-md-2 col-sm-12 position-static">
          {hook h='displayTop'}
        </div>
      </div>
      <div id="mobile_top_menu_wrapper" class="row hidden-md-up" style="display: none;">
        <div class="js-top-menu mobile" id="_mobile_top_menu">
        <ul class="menu_list">
          <li class="menu-item {if $currentUrl === $link->getPageLink('index', true)}active{/if}"><a href="/">{l s='Home' d='Shop.Theme.Alambic'}</a></li>
          <li class="menu-item" id="about-link"><a href="/#aboutus">{l s='About Us' d='Shop.Theme.Alambic'}</a></li>
        </ul>
        </div>
        <div class="js-top-menu-bottom">
          {* <div id="_mobile_currency_selector"></div> *}
          <div id="_mobile_language_selector"></div>
          {* <div id="_mobile_contact_link"></div> *}
        </div>
      </div>
    </div>
    
  </div>
  {hook h='displayNavFullWidth'}
{/block}
