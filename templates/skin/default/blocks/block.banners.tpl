<div class="block block-banners" id="block_banners">
	<header class="title">
		{$aLang.block_banners}
	</header>
	
	<div class="block-banners-content">
    {if $aBlockBanner_Banners}
        {foreach from=$aBlockBanner_Banners item=Banner}
        <div class="block-banners-banner">
            <a href="{$Banner.url}" {if $Banner.url_title}title="{$Banner.url_title}"{/if}>
                <img src="{$Banner.image_url}" {if $Banner.image_alt}alt="{$Banner.image_alt}"{/if}>
            </a>
        </div>
        {/foreach}
    {/if}
	</div>

    <footer>
    </footer>

</div>
