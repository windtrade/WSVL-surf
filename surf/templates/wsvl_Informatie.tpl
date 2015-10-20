{*
 * wsvl_kalenderBeheer.tpl template for calendar management
 *
 * 17-03-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam - Informatie{/block}
{block name="topdeel"}
{if count($teksten) > 0}
<h1>{$teksten[0].titel}</h1>
<p/>
{$teksten[0].tekst}
{/if}
<p/>
{if count($data) > 0}
<p>
<h1>Aanmelden</h1>
Vul onderstaand formulier in om je op te geven voor de starterscursus:
</p>
<p>
<form action="{$smarty.server.REQUEST_URI}" method="post" enctype="multipart/form-data" name="surflesAanmeldForm" id="surflesAanmeldForm">
<table>
{foreach $data.user as $item}
<tr>{HFlabeledField prefix="fd[user]" data=$item}</tr>
{/foreach}
{if $NOROBOT == false}
<tr>{HFrecaptcha}</tr>
{/if}
{foreach $data.eventRegister as $group}
{foreach $group as $item}
{$checked = ""}
{if $item.checked != 0}{$checked="checked"}{/if}
<tr>
<td>{$item.label}</td>
<td><input type="checkbox" name="{$item.name}" {$checked}/></td>
</tr>
{/foreach}
{/foreach}
</table>
<input type="submit" name="action" value="AANMELDEN"/>
</p>
{/if}
{/block}
{block name="linkerDeel"}
{for $i=1 ; $i < count($teksten) ; $i++}
<h1>{$teksten[$i].titel}</h1>
<p>
{$teksten[$i].tekst}
<p>
{/for}
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
<ul>
<ul>
<form id="hiddenSearch" method="POST" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="action" value="showEvent">
<input type="hidden" name="fd[event][id]" value="">
</form>
</ul>
</ul>
</div>
{/block}
