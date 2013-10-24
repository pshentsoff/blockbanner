{include file='header.tpl' noSidebar=true}
<h2 class="page-header"><a href="{router page='blockbanner'}">{$aLang.plugin.blockbanner.blockbanner}</a> <span>&raquo;</span> {$aLang.plugin.blockbanner.groups.title}</h2>

{include file=$sActionBlockbannerMenuTemplate}

<form method="post" action="{router page='blockbanner/groups'}">
    <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

    <table class="blockbanner-admin">

        <thead>
        <tr>
            <td>&nbsp;</td>
            <td>
                {$aLang.plugin.blockbanner.groups.name}<br/>
                {$aLang.plugin.blockbanner.groups.hook}<br/>
                {$aLang.plugin.blockbanner.groups.template}
            </td>
            <td>
                {$aLang.plugin.blockbanner.groups.banners}
            </td>
            <td>
                {$aLang.plugin.blockbanner.groups.include_pages}<br/>
                {$aLang.plugin.blockbanner.groups.exclude_pages}<br/>
                {$aLang.plugin.blockbanner.groups.comments}
            </td>
        </tr>
        </thead>

        <tbody>
        {foreach from=$aBlockbanner_Groups item=Group}
        <tr>
            <td>
                <input type="checkbox" name="blockbanner_groups[{$Group.id}][selected]" />
                <input type="hidden" name="blockbanner_groups[{$Group.id}][id]" value="{$Group.id}"/>
            </td>
            <td>
                <input type="text" value="{$Group.name}" name="blockbanner_groups[{$Group.id}][name]"/><br />
                <input type="text" name="blockbanner_groups[{$Group.id}][hook]" value="{$Group.hook}" /><br />
                <input type="text" name="blockbanner_groups[{$Group.id}][template]" value="{$Group.template}" /><br/>
                visible: <input type="checkbox" name="blockbanner_groups[{$Group.id}][visible]" {if $Group.visible}checked="on"{/if} />
            </td>
            <td>
                <select name="blockbanner_groups[{$Group.id}][banners][]" multiple="multiple">
                    {foreach from=$Group.banners item=Banner}
                        <option value="{$Banner.id}" {if $Banner.selected}selected="selected"{/if}>{$Banner.name}</option>
                    {/foreach}
                </select>
            </td>
            <td>
                <textarea name="blockbanner_groups[{$Group.id}][include_pages]">{$Group.include_pages}</textarea><br />
                <textarea name="blockbanner_groups[{$Group.id}][exclude_pages]">{$Group.exclude_pages}</textarea><br/>
                <textarea name="blockbanner_groups[{$Group.id}][comments]">{$Group.comments}</textarea>
            </td>
        </tr>
        {foreachelse}
        No groups
        {/foreach}
        {if $BlockbannerGroupsAddNew}
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <input type="text" value="" name="blockbanner_groups[new][name]"/><br />
                <input type="text" name="blockbanner_groups[new][hook]" value="" /><br />
                <input type="text" name="blockbanner_groups[new][template]" value="blocks/block.banner.tpl" /><br/>
                visible: <input type="checkbox" name="blockbanner_groups[new][visible]" value="0" />
            </td>
            <td>
                <select name="blockbanner_groups[new][banners][]" multiple="multiple">
                    {foreach from=$Group.banners item=Banner}
                        <option value="{$Banner.id}">{$Banner.name}</option>
                    {/foreach}
                </select>
            </td>
            <td>
                <textarea name="blockbanner_groups[new][include_pages]"></textarea><br />
                <textarea name="blockbanner_groups[new][exclude_pages]"></textarea><br/>
                <textarea name="blockbanner_groups[new][comments]"></textarea>
            </td>
        </tr>
        {/if}
        </tbody>

        <tfoot>
        <tr>
            <td colspan="4">
                <input type="submit" name="blockbanner_groups_add" value="{$aLang.plugin.blockbanner.buttons.add}" {if $BlockbannerGroupsAddNew}disabled="disabled"{/if}/>
                <input type="submit" name="blockbanner_groups_delete" value="{$aLang.plugin.blockbanner.buttons.delete}"/>
                <input type="submit" name="blockbanner_groups_save" value="{$aLang.plugin.blockbanner.buttons.save}" />
            </td>
        </tr>
        </tfoot>
    </table>
</form>
{include file='footer.tpl'}
