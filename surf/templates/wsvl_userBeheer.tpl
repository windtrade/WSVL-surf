{*
 * wsvl_userBeheer.tpl template for user management
 *
 * 04-01-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Beheer Lidmaatschap{/block}
{block name="topdeel"}
<h3>Wachtwoord wijzigen</h3>
<form id="password"
method="POST"
action="{$smarty.server.REQUEST_URI}">
{if isset($smarty.session.user) &&  isset($smarty.session.user.id)}
{$oldId=$smarty.session.user.id}
{/if}
{if isset($search)}
{if isset($search.id)}{$oldId=$search.id}{/if}
{foreach $search as $key => $val}
<input type='hidden' name='fd[search][{$key}]' value="{$val}">
{/foreach}
{/if}
<input type="hidden" name="action" value="updatePassword"/>
<input type="hidden" name="fd[pw][oldId]" value="{$oldId}"/>
<table>
<tr><td>Huidig wachtwoord</td><td><input type="password" name="fd[pw][oldWachtwoord]"/></tr>
<tr><td>Nieuw wachtwoord</td><td><input type="password" name="fd[pw][newWachtwoord]"/></tr></tr>
<tr><td>Herhaal nieuw wachtwoord</td><td><input type="password" name="fd[pw][chkWachtwoord]"/></tr>
<tr>
<td>
{HFsubmit value="Wijzigen"}
</td>
<td>
{HFreset value="Herstellen"}
</td>
</tr>
</table>
</form>
{/block}
{block name="linkerDeel"}
<h3>Bijwerken gebruikersgegevens</h3>
<form id="userData" method="POST" action="{$smarty.server.REQUEST_URI}">
{if isset($search)}
{foreach $search as $key => $val}
<input type='hidden' name='fd[search][{$key}]' value="{$val}">
{/foreach}
{/if}
<input type="hidden" name="action" value="updateUser"/>
<table>
{foreach from=$user item=item}
<tr>
{HFlabeledField prefix='fd[user]' data=$item}
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
<h3>Bijwerken gebruikersfuncties</h3>
<form id="userRoles" method="POST" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="action" value="updateRoles"/>
<input type="hidden" name="fd[role][id]" value="{$roleId}"/>
<table>
{foreach from=$roles item=item}
<tr>
<td>{$item.label}</td>
<td>
<input type="{$item.type}"
       name="{$item.name}"
       value="{$item.value}"
       {$item.checked}
       {$item.disabled}/>
</td>
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
<form id="resetPassword" method="GET" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="fd[search][id]" value="">
<input type="hidden" name="action" value="resetPassword">
</form>
<form id="hiddenSearch" method="GET" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="fd[search][id]" value="">
</form>
{foreach from=$other item=item}
<li class="nieuwsTitel">
<a href="#" onClick="setAndSubmit('hiddenSearch','id', {$item.id})">
{$item.text}
</a>
<a href="#" onClick="setAndSubmit('resetPassword','id', {$item.id})">
wachtwoordherstel</a>
</li>
{/foreach}
</ul>
</ul
</div>
{/block}
