{*
 * wsvl_training.tpl template for personal pages
 *
 * 29-03-2013: Huug Peters
 *}
{extends file="wsvl_3panels.tpl"}
{block name="topDeel"}
<script>
function refresh(field, value) {
    alert(window.location.pathname+" Veld "+field+" is nu '"+value+"'");
    window.location.replace(window.location.pathname+"?"+field+"="+value);
}
</script>
<div class="heterContent">
<div class="leftFloat30pct">
<div class="heterTitel">Wie komen er allemaal?</div>
{foreach $present as $item}
<p>
{if count($item.names) <=0}Geen{else}{count($item.names)}{/if}
 aanmelding{if count($item.names) != 1}en{/if}
 voor de training van {$item.start}
</p>
{if $loggedIn}
    <ul>
    {foreach $item.names as $aanmelding}
        <li>
            {$aanmelding}
        </li>
    {/foreach}
    </ul>
{/if}
{/foreach}
</div>
<div class="rightFloat70pct">
<div class="heterTitel">Meld je aan voor de trainingen<em>!</em></div>
<p>Om bij de training voldoende instructeurs op het water te hebben
moeten we vooraf weten wie we allemaal op onze trainingen mogen verwachten.
Daarom vragen we je het formulier in te vullen als je van plan bent om te komen.</p>
<form action="{$smarty.server.REQUEST_URI}" method="post" enctype="multipart/form-data" name="trainingAanmeldForm" id="trainingAanmeldForm"> 
{if $currentUserId < 0 or count($userList)==0}
<table>
<tr><td><strong>Roepnaam</strong></td>
<td><input type="text" size="30" name="fd[user][roepnaam]"/></td></tr>
<tr><td><strong>Voorvoegsel</strong></td>
<td><input type="text" size="30"  name="fd[user][voorvoegsel]"/></td></tr>
<tr><td><strong>Achternaam</strong></td>
<td><input type="text" size="30" name="fd[user][naam]"/></td></tr>
<tr><td><strong>Email</strong></td>
<td><input type="text" size="30" name="fd[user][email]"/></td></tr>
<tr><td colspan="2">(Als je 18- bent: van een ouder/verzorger)</td></tr>
{if $NOROBOT != "OK"}
<tr>{HFrecaptcha}</tr>
{/if}
</table>
{elseif count($userList) == 1}
Meld je hier aan, <strong>
{$userList.{$currentUserId}}
<input type="hidden" name="fd[currentUserId]" value="{$currentUserId}"/>
<input type="hidden" name="fd[user][id]" value="{$currentUserId}"/>
</strong>
{else}
Kies wie je wilt aanmelden:
<select name="currentUserId" onChange="refresh(this.name, this.value)">
{html_options options=$userList selected=$currentUserId}
</select>
<input type="hidden" name="fd[user][id]" value="{$currentUserId}"/>
{/if}
{foreach $data as $item}
<div class="heterTitel">
{$item.event.title}
</div>
<p>{$item.event.text}</p>
<!-- input type="hidden" name="fd[event][id]" value="{$item.event.id}"/ -->
{$elts = count($item.eventRegister)}
{$cols = 1}
{if $elts >= 10}{$cols=2}{/if}
{if $elts >= 20}{$cols=3}{/if}
{$rows = floor(($elts+$cols-1)/$cols)}
{$row=0}
<table>
<tr><td>
{HEanchor onclick="bulkCheck(event, 'fd[eventRegister][{$item.event.id}]', true)" inner="Alles kiezen"}
</td>
{if $cols==1}</tr><tr>{/if}
<td>
{HEanchor onclick="bulkCheck(event, 'fd[eventRegister][{$item.event.id}]', false)" inner="Niets kiezen"}
</td>
{for $i = 3 to $cols}<td></td>{/for}
</tr>
{while $row < $rows}
<tr>
{$col=0}
{while $col < $cols}
{$elt = ($col*$rows)+$row}
<td>
{if $elt < $elts}
{$label = $item.eventRegister[$elt].label}
{$name = $item.eventRegister[$elt].name}
{$checked = ""}
{if $item.eventRegister[$elt].checked != 0}{$checked="checked"}{/if}
<input type="checkbox" name="{$name}" {$checked}/> {$label}
{/if}
</td>
{$col = $col+1}
{/while}
</tr>
{$row = $row+1}
{/while}
</table>
{/foreach}
<input type="submit" name="action" value="AANMELDEN"/>
</form>
</div>
</div>
{/block}
{block name="topOnderkant"}
<img src="images/komjijooktrainen.gif" width="442" height="47" style="align:right" alt="Kom jij ook trainen?"/>
{/block}
{block name="linkerDeel"}
{foreach $information as $info}
<span class="nieuwsTitel">{$info.titel}</span>
<p>{$info.tekst}</p>
{/foreach}
{/block}
{block name="rechterTitel"}
<img src="images/kop_nog-meer.gif" width="188" height="31" alt="Nog meer..."/>
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Trainingsbijdrage</span><br />
<span class="nieuwsAuteur"></span>
<p>Na dat je bent aangemeld voor de training krijg je via email een factuur voor de trainingsbijdrage. Meer over de
trainingsbijdrage</a> vindt je op de <a href="http://{$smarty.server.SERVER_NAME}/informatie.php?tab=tarieven">informatie pagina's</a>.</p>
</div>

<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Dinsdagavondprogramma </span><br />
<span class="nieuwsAuteur"></span>
<p>18:15 - Aankomst<br/>
18:20 - Optuigen<br/>
18:45 - Surfpak aantrekken<br/>
19:00 - Voorbespreking van de training<br/>
19:10 - Het water op<br/>
20:30 - Nabespreken en evalueren<br/>
20:45 - Opruimen
<br/>
</p>
</div>
<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Optuigen</span><br />

<span class="nieuwsAuteur"></span>
<p>Als je gebruik maakt van de Surfpool en op dinsdagavond op
verenigingsmateriaal surft is het slim om ruim op tijd te komen,
je spullen optuigen duurt altijd langer dan je denkt.</p>
</div>

<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Afmelden</span><br />

<span class="nieuwsAuteur"></span>
<p>Heb je jezelf al aangemeld voor de komende training, maar gaat het je om wat voor reden toch niet lukken om er bij te zijn? 
<a href="training_afmelden.php">Meld je dan even af</a>.</p>
</div>
</div>
{/block}
