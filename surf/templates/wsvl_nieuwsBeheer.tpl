{*
 * wsvl_nieuwsBeheer.tpl template for news management
 *
 * 13-04-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Beheer Lidmaatschap{/block}
{block name="topdeel"}
<h3>Voer hier nieuwsberichten in of werk bestaande berichten bij</h3>
{/block}
{block name="linkerDeel"}
<form id="eventData" enctype="multipart/form-data" method="POST" action="{$smarty.server.REQUEST_URI}">
{if isset($search)}
{foreach $search as $key => $val}
<input type='hidden' name='fd_search_{$key}' value="{$val}">
{/foreach}
{/if}
<input type="hidden" name="action" value="saveNews"/>
<table>
<tr><th colspan="3">
<h3>{if $currentId le 0}Nieuw Bericht{else}Bericht bewerken{/if}</h3>
</th></tr>
{$i=0}
{$prefix.{$i}="fd[news]"}
{foreach from=$data.news item=item}
<tr>
    {HFlabeledField prefix="{$prefix[$i]}" data=$item}
    <td></td>
</tr>
{/foreach}
<tr><th colspan="3">
<h3>Voeg eventueel een nieuwe afbeelding toe</h3>
</th></tr>
{$i=0}
{$prefix.{$i}="fd[image]"}
{foreach from=$data.image item=item}
<tr>
    {HFlabeledField prefix="{$prefix[$i]}" data=$item}
    <td></td>
</tr>
{/foreach}
<tr>
<td>
{HFsubmit value="Opslaan"}
</td>
<td>
{HFreset value="Herstellen"}
</td>
</tr>
</table>
</form>
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
<ul>
<ul>
<form id="hiddenSearch" method="POST" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="action" value="showNews">
<input type="hidden" name="fd[news][news_id]" value="">
</form>
{foreach from=$newsList item=item}
<li class="nieuwsTitel">
<a href="#" onClick="setAndSubmit('hiddenSearch','news_id.', {$item.news_id})">
{$item.news_title}
</a>
</li>
{/foreach}
</ul>
</ul
</div>
{/block}
