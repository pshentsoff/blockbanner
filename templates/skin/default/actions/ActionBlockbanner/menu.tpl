<div class="blockbanner-menu">
    <a href="{router page='blockbanner/groups'}">{$aLang.plugin.blockbanner.groups.title}</a>
    &nbsp;|&nbsp;<a href="{router page='blockbanner/banners'}">{$aLang.plugin.blockbanner.banners.title}</a>
    &nbsp;|&nbsp;<a href="{router page='blockbanner/description'}">{$aLang.plugin.blockbanner.description}</a>
    &nbsp;|&nbsp;<a href="{router page='blockbanner/license'}">{$aLang.plugin.blockbanner.license}</a>
    {if $bShowDonateLink}
    &nbsp;|&nbsp;<a href="{router page='blockbanner/donate'}">{$aLang.plugin.blockbanner.donate}</a>
    {/if}
</div>