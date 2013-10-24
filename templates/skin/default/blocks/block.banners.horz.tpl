<div class="blockbanner-horz">
  {if $aBlockBanner_Banners}
      {foreach from=$aBlockBanner_Banners item=Banner}
      <a href="{$Banner.url}" {if $Banner.url_title}title="{$Banner.url_title}"{/if}>
          <img src="{$Banner.image_url}" {if $Banner.image_alt}alt="{$Banner.image_alt}"{/if}>
      </a>
      {/foreach}
    {/if}
  </div>
