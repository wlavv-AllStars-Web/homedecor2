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
{extends file='page.tpl'}

    {block name='page_content_container'}
      <section id="content" class="page-home">
        {block name='page_content_top'}{/block}

        {block name='page_content'}
          {block name='hook_home'}
            <section class="articles-blog">
              {$HOOK_HOME nofilter}
            </section>
            {* <section class="our-studio">
              <div class="studio-card">
                <img src="https://homedecor.allstars-web.com/img/cms/natal_images/_acasadecampo__1688662128_3141048054865921470_54089535870.jpg">
              </div>
              <div class="store-card">
                <img src="https://homedecor.allstars-web.com/img/cms/natal_images/A%20CASA%20DE%20CAMPO%20(2).jpg"/>
              </div>
            </section> *}
            {* <pre>{$link->getCategoryLink(2)}</pre> *}
            <section class="studio-store">
              <div class="grid">
                <div class="grid-item">
                  <h1>O Nosso Estúdio / Loja<h1>
                </div>
                <div class="grid-item">
                  <img src="https://homedecor.allstars-web.com/img/cms/natal_images/_acasadecampo__1688662128_3141048054865921470_54089535870.jpg">
                </div>
                <div class="grid-item">
                <img src="https://homedecor.allstars-web.com/img/cms/natal_images/_acasadecampo__1688662128_3141048054865921470_54089535870.jpg">
                </div>
                <div class="grid-item">
                <img src="https://homedecor.allstars-web.com/img/cms/natal_images/_acasadecampo__1688662128_3141048054865921470_54089535870.jpg">
                </div>
                <div class="grid-item visit-store-btn">
                {* <pre>{$categories[1][2]['infos']|print_r}</pre> *}
                  <a href="{$link->getCategoryLink(2)}">{l s="Visite a Nossa Loja"} <i class="arrow_right">&#8594;</i></a>
                </div>
                <div class="grid-item">
                <img src="https://homedecor.allstars-web.com/img/cms/natal_images/_acasadecampo__1688662128_3141048054865921470_54089535870.jpg">
                </div>
                <div class="grid-item">
                <img src="https://homedecor.allstars-web.com/img/cms/natal_images/_acasadecampo__1688662128_3141048054865921470_54089535870.jpg">
                </div>
              </div>
            </section>
            <section id="about-us-section" class="about-us">
              
              <div class="about-content">
                <h1>Quem Somos?</h1>
                <ul class="card">
                  <li>
                  <p>A Casa de Campo, uma marca criada em 2022, inserida na empresa SOUMAD,
                  especializada na venda de artigos de bricolagem e materiais de construção.
                  A nossa missão é proporcionar um acompanhamento de excelência, permitindo aos
                  nossos clientes uma vida mais serena, transformando as suas habitações em
                  espaços práticos e acolhedores.</p>
                  </li>
                  <li>
                  <p>Sob a liderança de Bárbara de Sousa, designer, a Casa de Campo une o design de
                  interiores à venda de artigos de decoração para interior e exterior. Surgimos da
                  necessidade de expandir o negócio já existente na SOUMAD, uma empresa familiar
                  fundada em 2000, indo além da venda de produtos de bricolagem e materiais de
                  construção para incluir também artigos decorativos e projetos de design de
                  interiores.</p>
                  </li>
                </ul>
              </div>
              <div class="about-img">
                <div class="about-img-container">
                <div class="about-img-item">
                  <img src="https://homedecor.allstars-web.com/img/cms/natal_images/A%20CASA%20DE%20CAMPO%20(3).jpg" />
                </div>
                <div class="about-img-item">
                  <img src="https://homedecor.allstars-web.com/img/cms/natal_images/A%20CASA%20DE%20CAMPO%20(3).jpg" />
                </div>
                <div class="about-img-item">
                  <img src="https://homedecor.allstars-web.com/img/cms/natal_images/A%20CASA%20DE%20CAMPO%20(3).jpg" />
                </div>
                </div>
              </div>
            </section>
            <section id="services-section" class="our-services">
              <h1>Os Nossos Serviços</h1>
              <div class="services_content">
                <div class="design">
                  <i class="fa-solid fa-ruler-combined"></i>
                  <h3>Design de Interiores</h3>
                  <p>Criamos espaços equilibrados, que combinam classe e
                  contemporaneidade. A componente criativa é liderada pela designer de interiores
                  Bárbara de Sousa.</p>
                </div>
                <div class="shop">
                  <i class="fa-solid fa-store"></i>
                  <h3>Venda de Artigos de Decoração</h3>
                  <p>A nossa loja oferece uma
                  vasta gama de artigos, desde decoração elegante até produtos práticos para o dia a
                  dia.</p>
                </div>
                <div  class="product-design">
                  <i class="fa-solid fa-pen-ruler"></i>
                  <h3>Design de Produto</h3>
                  <p>Muitas das peças de mobiliário apresentadas são exclusivas.
                  Além disso, estabelecemos parcerias e colaborações com designers e arquitetos para
                  fabricar as suas peças desenhadas.</p>
                </div>
                <div  class="social-content">
                  <i class="fa-solid fa-camera-retro"></i>
                  <h3>Conteúdo Editorial</h3>
                  <p>A mais recente componente da nossa marca, integrada no nosso
                  site e nas nossas redes sociais, visa partilhar um estilo de vida que combina arte,
                  design, gastronomia, moda e viagens.</p>
                </div>
               
              </div>
            </section>
            <section id="contact-us" class="contact-homepage">
              <h1>Agende a sua reunião.</h1>
              {hook h='displayContactContent' mod='contactform' id_module=25}
            </section>
            
          {/block}
        {/block}
      </section>
    {/block}
