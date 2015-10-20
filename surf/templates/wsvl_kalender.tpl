{*
 * wsvl_kalenderBeheer.tpl template for calendar management
 *
 * 17-03-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Beheer Lidmaatschap{/block}
{block name="topdeel"}
{if (isset($currentEventItem))}
    {$item = $data.event[$currentEventItem.id]}
{else}
    {$item.title="Overzicht activiteiten"}
    {$currentEventItem.name = ""}
    {$currentEventItem.startText = ""}
    {$currentEventItem.location = ""}
    {$currentEventItem.url = ""}
    {if count($data.event) == 0}
         {$item.text="Er zijn geen activiteiten gepland"}
    {else}
         {$item.text="Er is altijd wat te doen!"}
    {/if}
    {$item.detail=""}
    {$item.image = 0}
{/if}

<div class="heter">
<div class="heterContent">
{HEimage id="{$item.image}" size="small"}
<h2>{$item.title} {$currentEventItem.name}</h2>
<h3>{$currentEventItem.startText}</h3>
<h3>{if $currentEventItem.location == "" and $currentEventItem.url != ""}
{$currentEventItem.location="info"}
{/if}
{if $currentEventItem.location != ""}
<br/>
{if $currentEventItem.url != ""}
<a href="{$currentEventItem.url}">{$currentEventItem.location}</a>
{else}
{$currentEventItem.location}
{/if}
{/if}</h3>
<p>{$item.text}</p>
<p>{$item.detail}</p>
</div>
<div class="heterContent">
<form id="kalender" enctype="multipart/form-data" method="POST" action="{$smarty.server.REQUEST_URI}">
<table>
{foreach from=$data.form.users item=elt}
{if $elt.value != "" || !$elt.protected}
<tr>
{HFlabeledField prefix="fd[users]" data=$elt}
{/if}
{/foreach}
<tr>
<input type="hidden" name="fd[eventRegister][id]" value="{$currentEventItem.id}" />
<input type="hidden" name="fd[eventRegister][start]" value="{$currentEventItem.start}" />
{if $NOROBOT != "OK"}
<tr>{HFrecaptcha}</tr>
{/if}
<td><input type="submit" name="fd[command]" value="{$command}"/></td>
<td><input type="reset" value="WISSEN"/></td>
</tr>
</table
</form>
</div>
</div>
{/block}
{block name="linkerDeel"}
<table>
{$lastYear=-1}{$lastMonth=-1}
{foreach from=$data.GENERAL item=item}
{$item.date[1]=$item.date[1]+0}
{if $item.date[1] != $lastMonth || $item.date[0] != $lastYear}
{$month={$monthNames[$item.date[1]]}}
{if $item.date[0] != $lastYear}
{$lastYear=$item.date[0]}
{$month="{$month} {$item.date[0]}"}
{/if}
{$lastMonth = $item.date[1]}
<tr>
<td colspan='3'><div class="calendarH1">{$month}</div></td>
</tr>
{/if}
<tr>
<td>
{if $item.image != 0}
{HEimage id="{$item.image}" size="thumb"}
{/if}
</td>
<td><div class="calendarH2">{$item.date[2]}</div></td>
<td>
<a href="{HEbuildURI keep="tab" currentEventId={$item.id} currentStart={$item.start}}">{$item.title} {$item.name}</a>
{if $item.location == "" and $item.url != ""}
{$item.location="info"}
{/if}
{if $item.location != ""}
<br/>
{if $item.url != ""}
<a href="{$item.url}">{$item.location}</a>
{else}
{$item.location}
{/if}
{/if}
</td>
</tr>
{/foreach}
</table>
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
<ul>
<ul>
<form id="hiddenSearch" method="POST" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="action" value="showEvent">
<input type="hidden" name="fd[event][id]" value="">
</form>
{foreach $rightColumns item=group}
{foreach $data.$group.dates item=event}
<table>
<tr><th colspan="2">
<a href="{$data.$group.link}">{$event.title}</a>
</th></tr>
{$lastDate=""}
{foreach $event.start item=start}
<tr>
<td>{if $start.date != $lastDate}{$lastDate=$start.date}{$start.date}{/if}</td>
<td>{$start.time}</td>
{/foreach}
</tr>
{/foreach}
</table>
{/foreach}
</ul>
</ul>
</div>
{/block}
