{* 
* @Module Name: Leo Elements
* @Website: leotheme.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright Leotheme
* @description: Leo Elements is module help you can build content for your shop
*}
<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
  <div class="thumbnail-container">
    <div class="product-image">
{block name='product_thumbnail'}
	{if isset($profile_params.pl_config.plist_load_multi_product_img) && $profile_params.pl_config.plist_load_multi_product_img}
		<div class="leo-more-info" data-idproduct="{$product.id_product}"></div>
	{/if}
	{if $product.cover}
		{if $profile_params.pl_config.lmobile_swipe == 1 && $isMobile}
		    <div class="product-list-images-mobile">
		    	<div>
		{/if}
			    	<a href="{$product.url}" class="thumbnail product-thumbnail">
					  <img
						class="img-fluid"
						src = "{$product.cover.bySize.home_default.url}"
						alt = "{$product.cover.legend}"
						data-full-size-image-url = "{$product.cover.large.url}"
					  >
					  {if isset($profile_params.pl_config.plist_load_more_product_img) && $profile_params.pl_config.plist_load_more_product_img && $profile_params.pl_config.plist_load_more_product_img_option == 1}
							<span class="second-image-style product-additional" data-idproduct="{if $profile_params.pl_config.lmobile_swipe && $isMobile}0{else}{$product.id_product}{/if}"></span>
						{elseif isset($profile_params.pl_config.plist_load_more_product_img) && $profile_params.pl_config.plist_load_more_product_img && $profile_params.pl_config.plist_load_more_product_img_option == 2}
							<span class="second-image-style product-attribute-additional" data-idproduct="{if $profile_params.pl_config.lmobile_swipe && $isMobile}0{else}{$product.id_product}{/if}" data-id-product-attribute="{$product.id_product_attribute}" data-id-image="{$product.cover.id_image}"></span>
						{elseif isset($profile_params.pl_config.plist_load_more_product_img) && $profile_params.pl_config.plist_load_more_product_img && $profile_params.pl_config.plist_load_more_product_img_option == 3}
							<span class="second-image-style product-all-additional" data-idproduct="{if $profile_params.pl_config.lmobile_swipe && $isMobile}0{else}{$product.id_product}{/if}" data-id-product-attribute="{$product.id_product_attribute}" data-id-image="{$product.cover.id_image}"></span>
					  {/if}
					</a>
		{if $profile_params.pl_config.lmobile_swipe == 1 && $isMobile}
				</div>
		    	{foreach from=$product.images item=image}
			    	{if $product.cover.bySize.home_default.url != $image.bySize.home_default.url}
			            <div>
					    	<a href="{$product.url}" class="thumbnail product-thumbnail">
			                    <img
			                      class="thumb js-thumb img-fluid {if $image.id_image == $product.cover.id_image} selected {/if}"
			                      src="{$image.bySize.home_default.url}"
			                      alt="{$image.legend}"
			                      title="{$image.legend}"
								  loading="lazy"
			                    >
			                </a>
						</div>	
					{/if}
				{/foreach}
			</div>
		{/if}
	{else}
	  <a href="{$product.url}" class="thumbnail product-thumbnail leo-noimage">
	 <img class="img-fluid" src= "{$urls.no_picture_image.bySize.home_default.url}" loading="lazy" >
	  </a>
	{/if}
{/block}
{hook h='displayLeoCartButton' product=$product}
</div>
    <div class="product-meta">
{block name='product_name'}
  <h3 class="h3 product-title"><a href="{$product.url}">{$product.name|truncate:70:'...'}</a></h3>
{/block}

{block name='product_price_and_shipping'}
  {if $product.show_price}
    <div class="product-price-and-shipping">
      {if $product.has_discount}
        {hook h='displayProductPriceBlock' product=$product type="old_price"}

        <span class="regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
        {if $product.discount_type === 'percentage'}
          <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
        {elseif $product.discount_type === 'amount'}
          <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
        {/if}
      {/if}

      {hook h='displayProductPriceBlock' product=$product type="before_price"}

      <span class="price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
        {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
        {if '' !== $smarty.capture.custom_price}
          {$smarty.capture.custom_price nofilter}
        {else}
          {$product.price}
        {/if}
      </span>

      {hook h='displayProductPriceBlock' product=$product type='unit_price'}

      {hook h='displayProductPriceBlock' product=$product type='weight'}
    </div>
  {/if}
{/block}
</div>
  </div>
</article>
