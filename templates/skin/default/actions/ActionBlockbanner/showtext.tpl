{include file='header.tpl' noSidebar=true}
{literal}
<style type="text/css">
    .showtext {
        width: 100%;
    }

    .showtext div {
        padding: 15px;
    }

    .showtext textarea {

        width: 930px;
        height: 420px;

    }
</style>
{/literal}

<div class="showtext">
    <div>
        <h3>{$sShowTextTitle}</h3>
        <a href="{router page=$sURLBack}" title="{$sURLBackTitle}">{$sURLBackTitle}</a>
    </div>
    <div>
    {if $sTextFile}
        <textarea readonly="readonly">{include file=$sTextFile}</textarea>
    {elseif $sHTMLFile}
        {include file=$sHTMLFile}
    {/if}
    </div>
</div>

{include file='footer.tpl'}