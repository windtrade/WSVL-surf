{*
 * wsvl_nieuwsBeheer.tpl template for tarif management
 *
 * 13-04-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Beheer Lidmaatschap{/block}
{block name="topdeel"}
<h3>Voer hier tarieven in of werk bestaande tarieven bij</h3>
<p/>
Voor een nieuw tarief in of kies een tarief uit de rechter lijst en wijzig dat.

Een kleine toelichting:
<table>
<tr><td>id</td><td>:</td><td>Het id (nummer) van het evenement waarvoor het tarief geldt</td></tr>
<tr><td>Geldig vanaf</td><td>:</td><td>Datum waarvanaf dit tarief geldt</td></tr>
</table>
{/block}
{block name="linkerDeel"}
<form id="eventData" enctype="multipart/form-data" method="POST" action="{$smarty.server.REQUEST_URI}">
{if isset($search)}
{foreach $search as $key => $val}
<input type='hidden' name='fd_search_{$key}' value="{$val}">
{/foreach}
{/if}
<input type="hidden" name="action" value="saveTarif"/>
<table>
<tr><th colspan="3">
<h3>{if $currentId le 0}Nieuw Tarief{else}Tarief bewerken{/if}</h3>
</th></tr>
{$i=0}
{$prefix.{$i}="fd[tarif]"}
{foreach from=$data.tarif item=item}
<tr>
    {HFlabeledField prefix="{$prefix[$i]}" data=$item}
    <td></td>
</tr>
{/foreach}
<tr>
<td>
<input type="submit" value="Opslaan">
</td>
<td>
<input type="reset" value="Herstellen">
</td>
</tr>
</table>
</form>
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
<ul>
<ul>
{HFform id="hiddenSearch" method="GET"}
<input type="hidden" name="action" value="showTarif">
<input type="hidden" name="fd[tarif][id]" value="">
<input type="hidden" name="fd[tarif][valid_from]" value="">
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

