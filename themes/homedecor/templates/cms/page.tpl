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

{block name='page_title'}
  {$cms.meta_title}
{/block}

{block name='page_content_container'}
  <section id="content" class="page-content page-cms page-cms-{$cms.id}">

    {block name='cms_content'}
      {$cms.content nofilter}
       {* <div class="projects-section">
        <div class="project-item">
          <div class="project-item-img">
            <img src="https://studio-mcgee.com/wp-content/app/uploads/2024/04/studiomcgee-HoustonEstate-20230915-0668-aspect-ratio-3-4-400x533.jpg" />
          </div>
          <div class="project-item-content">  
            <h1><a href="#">The Houston Estate</a></h1>
            <h5><a href="#">Modern and traditional merge in a friendly family home.</a></h5>
          </div>
        </div>
        <div class="project-item">
          <div class="project-item-img">
            <img src="https://studio-mcgee.com/wp-content/app/uploads/2024/04/studiomcgee-HoustonEstate-20230915-0668-aspect-ratio-3-4-400x533.jpg" />
          </div>
          <div class="project-item-content">
            <h1><a href="#">The McGee Home Refresh</a></h1>
            <h5><a href="#">Phase two of Syd and Shea's Utah dream home.</a></h5>
          </div>
        </div>
        <div class="project-item">
          <div class="project-item-img">
            <img src="https://studio-mcgee.com/wp-content/app/uploads/2024/04/studiomcgee-HoustonEstate-20230915-0668-aspect-ratio-3-4-400x533.jpg" />
          </div>
          <div class="project-item-content">  
            <h1><a href="#">The Houston Estate</a></h1>
            <h5><a href="#">Modern and traditional merge in a friendly family home.</a></h5>
          </div>
        </div>
        <div class="project-item">
          <div class="project-item-img">
            <img src="https://studio-mcgee.com/wp-content/app/uploads/2024/04/studiomcgee-HoustonEstate-20230915-0668-aspect-ratio-3-4-400x533.jpg" />
          </div>
          <div class="project-item-content">
            <h1><a href="#">The McGee Home Refresh</a></h1>
            <h5><a href="#">Phase two of Syd and Shea's Utah dream home.</a></h5>
          </div>
        </div>
        <div class="project-item">
          <div class="project-item-img">
            <img src="https://studio-mcgee.com/wp-content/app/uploads/2024/04/studiomcgee-HoustonEstate-20230915-0668-aspect-ratio-3-4-400x533.jpg" />
          </div>
          <div class="project-item-content">  
            <h1><a href="#">The Houston Estate</a></h1>
            <h5><a href="#">Modern and traditional merge in a friendly family home.</a></h5>
          </div>
        </div>
        <div class="project-item">
          <div class="project-item-img">
            <img src="https://studio-mcgee.com/wp-content/app/uploads/2024/04/studiomcgee-HoustonEstate-20230915-0668-aspect-ratio-3-4-400x533.jpg" />
          </div>
          <div class="project-item-content">
            <h1><a href="#">The McGee Home Refresh</a></h1>
            <h5><a href="#">Phase two of Syd and Shea's Utah dream home.</a></h5>
          </div>
        </div>
        
        
        
        
        
      </div> *}
      {* <style>
        .cms-id-8 .page-header h1{
          font-size: 4rem !important;
          font-weight: lighter;
          color: var(--color-text) !important;
        }

        .page-cms-8{
          padding: 0 !important;
        }
        .projects-section {
          display: grid;
          grid-template-columns: 1fr 1fr 1fr;
          gap: 5rem 2rem;
          background: var(--bege);
        }

        .project-item{

        }
        .project-item-img img{
          width: 100%;
        }
        .project-item-content {
          padding: 1rem 0;
        }

        .project-item-content h1{
          color: var(--color-text);
          font-size: 1.5rem;
          font-weight: var(--fw-500);
        }
        .project-item-content h5{
          color: var(--color-text);
          font-size: 1.25rem;
          font-weight: var(--fw-100);
        }
      </style> *}
    {/block}

    {block name='hook_cms_dispute_information'}
      {hook h='displayCMSDisputeInformation'}
    {/block}

    {block name='hook_cms_print_button'}
      {hook h='displayCMSPrintButton'}
    {/block}

  </section>
{/block}
