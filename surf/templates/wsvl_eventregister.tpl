{*
 * wsvl_eventRegister.tpl template for user management
 *
 * 04-01-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Aanmelden evenementen{/block}
{block name="topdeel"}
<h3>{$curRegistration.event.title}</h3>
{$curRegistration.event.text}<br/>
{$curRegistration.event.detail}<br/>
{/block}
{block name="linkerDeel"}
<form id="eventRegister" method="POST" action="{$smarty.server.REQUEST_URI}">
{if isset($search)}
{foreach $search as $key => $val}
<input type='hidden' name='fd_search_{$key}' value="{$val}">
{/foreach}
{/if}
<input type="hidden" name="action" value="eventRegister"/>
{$rowCount=count($curRegistration.registerList)}
<table>
<tr>
<th colspan="3">
<h3>Aan- en afmelden</h3>
</th>
</tr>
<tr>
<th colspan="3">
Vink hieronder alle data aan waar je aanwezig wil zijn.
Je kunt de lijst later altijd weer wijzigen. 
</th>
</tr>
{for $i=0 to $rowCount-1}
<tr>
{$cal=$curRegistration.registerList[$i]}
{$name="fd[calendar][{$cal.entry}]"}
{if $cal.enrolled ne 0}
{$checked = " checked"}
{else}
{$checked = ""}
{/if}
<td>
<input type="checkbox" name="{$name}"{$checked}/>
</td><td>
{$cal.start}
</td><td>
{$cal.name}
</td>
</tr>
{/for}
</form>
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
<form id="hiddenSearch" method="GET" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="fd_search_id" value="">
</form>
{foreach from=$calendarList item=item}
<li class="nieuwsTitel">
<a href="#" onClick="setAndSubmit('hiddenSearch','id', {$item.calendar.id})">
{$item.event.title}
{if $item.calendar.count > 1}
{$item.calendar.count}x vanaf {$item.calendar.start}
{else}
{$item.calendar.start}
{/if}
</a>
</li>
{/foreach}
</ul>
</ul
</div>
{/block}
