{* 
* @Module Name: Leo Elements
* @Website: leotheme.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright Leotheme
* @description: LeoElements is module help you can build content for your shop
*}
{if isset($formAtts.lib_has_error) && $formAtts.lib_has_error}
    {if isset($formAtts.lib_error) && $formAtts.lib_error}
        <div class="alert alert-warning leo-lib-error">{$formAtts.lib_error}</div>
    {/if}
{else}
    <div id="slideshow-{$formAtts.form_id|escape:'html':'UTF-8'}" class="LeoSlideshow">
	{if isset($content_slider)}
		{$content_slider nofilter}{* HTML form , no escape necessary *}
	{/if}
    </div>
{/if}