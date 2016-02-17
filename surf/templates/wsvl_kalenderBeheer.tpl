{*
 * wsvl_kalenderBeheer.tpl template for calendar management
 *
 * 17-03-2013: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Beheer Lidmaatschap{/block}
{block name="topdeel"}
<h3>Voer hier de clubactiviteiten in of werk de gevens bij</h3>
{/block}
{block name="linkerDeel"}
<form id="eventData" enctype="multipart/form-data" method="POST" action="{$smarty.server.REQUEST_URI}">
{if isset($search)}
{foreach $search as $key => $val}
<input type='hidden' name='fd_search_{$key}' value="{$val}">
{/foreach}
{/if}
<input type="hidden" name="action" value="saveEvent"/>
<table>
<tr><th colspan="3">
<h3>{if $currentId le 0}Nieuw Evenement{else}Evenement bewerken{/if}</h3>
</th></tr>
{$i=0}
{$prefix.{$i}="fd[event]"}
{foreach from=$data.event item=item}
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
<tr><td colspan="3">
<h3>Data waarop dit evenement plaats vindt en aanvullende informatie</h3>
</td></tr>
{$i=0}
{$prefix.{$i}="fd[calendar]"}
{$i={$i+1}}
{$j=0}
{foreach $data.calendar item=eventItem}
{$j={$j+1}}
{$prefix.{$i}="{$prefix.{$i-1}}[{$j}]"}
{$min={HEelement tag="a" value="-" onClick="switchList('eventData', '{$prefix.{$i}}', 0)"}}
{$plus={HEelement tag="a" value="+" onClick="switchList('eventData', '{$prefix.{$i}}', 1)"}}
{$col3="{$min}/{$plus}"}
{foreach $eventItem item=item}
<tr name='{$prefix.{$i}}'>
    {HFlabeledField prefix="{$prefix.{$i}}" data=$item}
    <td>{$col3}</td>
</tr>
{$col3=""}
{/foreach}
{/foreach}
<tr>
<td>Herhaal</td>
<td>
<select name="fd[copy][count]" id="fd[copy][count]" />
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
</select>x elke
<select name="fd[copy][interval]" id="fd[copy][interval]">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
</select>
<select name="fd[copy][unit]" id="fd[copy][unit]">
<option value="hour">uur</option>
<option value="day">dag</option>
<option value="week">week</option>
<option value="month">maand</option>
</select>
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
<input type="hidden" name="action" value="showEvent">
<input type="hidden" name="fd[event][id]" value="">
</form>
{foreach from=$eventList item=item}
<li class="nieuwsTitel">
<a href="#" onClick="setAndSubmit('hiddenSearch','id.', {$item.id})">
{$item.title}
</a>
</li>
{/foreach}
</ul>
</ul
</div>
{/block}
