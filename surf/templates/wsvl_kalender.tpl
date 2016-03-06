{*
 * wsvl_kalender.tpl template for calendar display
 *
 * 17-03-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Kalender{/block}
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

{HEimage id="{$item.image}" size="small"}
<h2>{$item.title} {$currentEventItem.name}</h2>
<h3>{$currentEventItem.startText}</h3>
{if $currentEventItem.location == "" and $currentEventItem.url != ""}
{$currentEventItem.location="info"}
{/if}
{if $currentEventItem.location != ""}
<h3>
{if $currentEventItem.url != ""}
{HEanchor href="{$currentEventItem.url}" inner={$currentEventItem.location}}
{else}
{$currentEventItem.location}
{/if}
</h3>
{/if}
{$item.text}
{$item.detail}
</div>
<div class="heterContent">
<form id="kalender" enctype="multipart/form-data" method="POST" action="{$smarty.server.REQUEST_URI}">
<table>
{foreach from=$data.form.users item=elt}
{if $elt.value != "" || !$elt.protected}
<tr>
{HFlabeledField prefix="fd[users]" data=$elt}
</tr>
{/if}
{/foreach}
{if $NOROBOT != "OK"}
<tr>{HFrecaptcha}</tr>
{/if}
<tr>
<td>
<input type="hidden" name="fd[eventRegister][id]" value="{$currentEventItem.id}" />
<input type="hidden" name="fd[eventRegister][start]" value="{$currentEventItem.start}" />
<input type="submit" name="fd[command]" value="{$command}"/>
</td>
<td><input type="reset" value="WISSEN"/></td>
</tr>
</table>
</form>
<div>{HEsocial currentEventId="{$currentEventItem.id}" currentStart="{$currentEventItem.start}"}</div>
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
{assign var=href value={HEbuildURI keep="tab" currentEventId="{$item.id}" currentStart={$item.start}}}
{HEanchor href={$href} inner="{$item.title} {$item.name}"}
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
<form id="hiddenSearch" method="GET" action="{$smarty.server.REQUEST_URI}">
<input type="hidden" name="action" value="showEvent"/>
<input type="hidden" name="fd[event][id]" value=""/>
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
</tr>
{/foreach}
</table>
{/foreach}
{/foreach}
</div>
{/block}
