{include file='header.tpl' noSidebar=true}

<h2 class="page-header"><a href="{router page='blockbanner'}">{$aLang.plugin.blockbanner.blockbanner}</a> <span>&raquo;</span> {$aLang.plugin.blockbanner.banners.title}</h2>

{include file=$sActionBlockbannerMenuTemplate}

<form method="post" action="{router page='blockbanner/banners'}">
    <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

    <table class="blockbanner-admin">
        <thead><tr>
            <td>&nbsp;</td>
            <td>
                {$aLang.plugin.blockbanner.banners.name}<br/>
                {$aLang.plugin.blockbanner.banners.url}<br/>
                {$aLang.plugin.blockbanner.banners.url_title}
            </td>
            <td>
                {$aLang.plugin.blockbanner.banners.image_path}<br/>
                {$aLang.plugin.blockbanner.banners.image_url}<br/>
                {$aLang.plugin.blockbanner.banners.image_alt}
            </td>
            <td>
                {$aLang.plugin.blockbanner.banners.preview}
            </td>
            <td>
                {$aLang.plugin.blockbanner.banners.order}
            </td>
            <td>
                {$aLang.plugin.blockbanner.banners.visible}
            </td>
        </tr></thead>
        <tbody>
        {foreach from=$aBlockbanner_Banners item=Banner}
            <tr>
                <td>
                    <input type="hidden" name="blockbanner_banners[{$Banner.id}][id]" value="{$Banner.id}"/>
                    <input type="checkbox" name="blockbanner_banners[{$Banner.id}][selected]"/>
                </td>
                <td>
                    <input type="text" name="blockbanner_banners[{$Banner.id}][name]" value="{$Banner.name}" /><br />
                    <input type="text" name="blockbanner_banners[{$Banner.id}][url]" value="{$Banner.url}" /><br />
                    <input type="text" name="blockbanner_banners[{$Banner.id}][url_title]" value="{$Banner.url_title}" />
                </td>
                <td>
                    <input class="twicelonger" type="text" name="blockbanner_banners[{$Banner.id}][image_path]" value="{$Banner.image_path}" /><br />
                    <input class="twicelonger" type="text" name="blockbanner_banners[{$Banner.id}][image_url]" value="{$Banner.image_url}" /><br />
                    <input class="twicelonger" type="text" name="blockbanner_banners[{$Banner.id}][image_alt]" value="{$Banner.image_alt}" />
                </td>
                <td>
                    <a href="{$Banner.url}" title="{$Banner.url_title}" target="_blank"><img class="preview-thumb" src="{$Banner.image_url}" alt="{$Banner.image_alt}"></a>
                </td>
                <td>
                    <input class="twodigits" type="text" name="blockbanner_banners[{$Banner.id}][order]" value="{$Banner.order}" /><br />
                </td>
                <td>
                    <input type="checkbox" name="blockbanner_banners[{$Banner.id}][visible]" {if $Banner.visible}checked="on"{/if} /><br />
                </td>
            </tr>
        {/foreach}
        {if $BlockbannerBannersAddNew}
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <input type="text" name="blockbanner_banners[new][name]" value="" /><br />
                        <input type="text" name="blockbanner_banners[new][url]" value="" />
                        <input type="text" name="blockbanner_banners[new][url_title]" value="" />
                    </td>
                    <td>
                        <input class="twicelonger" type="text" name="blockbanner_banners[new][image_path]" value="" /><br />
                        <input class="twicelonger" type="text" name="blockbanner_banners[new][image_url]" value="" /><br />
                        <input class="twicelonger" type="text" name="blockbanner_banners[new][image_alt]" value="" />
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <input class="twodigits" type="text" name="blockbanner_banners[new][order]" value="0" /><br />
                    </td>
                    <td>
                        <input type="checkbox" name="blockbanner_banners[new][visible]" checked="on"/><br />
                    </td>
                </tr>
        {/if}
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7">
                <input type="submit" name="blockbanner_banners_add" value="{$aLang.plugin.blockbanner.buttons.add}" {if $BlockbannerBannersAddNew}disabled="disabled"{/if}/>
                <input type="submit" name="blockbanner_banners_delete" value="{$aLang.plugin.blockbanner.buttons.delete}"/>
                <input type="submit" name="blockbanner_banners_save" value="{$aLang.plugin.blockbanner.buttons.save}" />
            </td>
        </tr>
        </tfoot>
    </table>

</form>

{include file='footer.tpl'}
