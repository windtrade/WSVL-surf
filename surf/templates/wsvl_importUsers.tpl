{*
 * users.tpl template for user maintenance
 *
 * 29-10-2011: Huug Peters
 *}
{extends file="wvLeidschendam.tpl"}
{block name="title"}WV Leidschendam User Beheer{/block}
{block name="body"}
<script type="text/javascript">
function moveToStep(form,step)
{
	if (step < 1) {
		window.alert("Er is geen verder terug");
		return false;
	}
	form.step.value=step;
        {foreach $resident as $name => $val}
	addMissingInputToForm(form, "{$name}", "{$val}");
        {/foreach}
	form.submit();
        return true;
}
</script>
<h1>Importeren Ledenbestand</h1><br/>
<h2>Stap {$formStep}:
{if $formStep == 1} Import bestand kiezen
{elseif $formStep == 2} Velden toewijzen aan database kolommen
{elseif $formStep == 3} Records importeren of bestaande gegevens bijwerken
{else} Verrassing!!!{/if}
</h2><br/>
{if $formStep == 1}
<form name="form1_a" method="post" action="{$action}" enctype="multipart/form-data">
<input name="step" type="hidden" value="{$formStep}"/>
{"Importeren van een CSV bestand, let op:
<list>
<li>Vooraan de file worden regels met slechts een enkel veld geskipt.</li>
<li>Er wordt een kolomregel verwacht als begin van de gegevens.</li>
<li>Alle regels dienen evenveel kolommen te bevatten.</li>
</list>"|nl2br}<br/>
Geef importbestand: <input type="file" name="importFile" /><br/>
<a href="javascript:moveToStep(document.form1_a, {$formStep+1})">verder</a>
</form>
{if $importFile != ""}
<form name="form1_b" method="post" action="{$action}">
U kunt ook verder met dit importbestand:
<input name="step" type="hidden" value="{$formStep}"/>
{$importFile}
<input type="hidden" name="importFile" value="{$importFile}" />
<a href="javascript:moveToStep(document.form1_b, {$formStep+1})">verder</a>
</form>
{/if}
{elseif $formStep == 2}
<form name="form2" method="post" action="{$action}">
<table>
<tr><td>Import</td>
{foreach $impColumns as $impColumn}
   <td>{$impColumn}</td>
{/foreach}
</tr>
<tr><td>Intern</td>
{for $i=0 to count($impColumns)-1}
   {$name="destColumn_{$i}"}
   {if isset($resident.{$name})}
	{$val=$resident.{$name}}
   {else}
        {$val=""}
   {/if}
   <td>
      <select id="{$name}" name="{$name}">
      {html_options values=$tbColumns output=$tbColumns selected=$val}
      </select>
   </td>
{/for}
</tr>
<tr>
<td>Uniek veld</td><td>
{$name="uniqueKey"}
{if isset($resident.{$name})}
     {$val=$resident.{$name}}
{else}
     {$val=""}
{/if}
   <select id="{$name}" name="{$name}">
   {html_options values=$tbColumns output=$tbColumns selected=$val}
   </select>
</td>
<td>Koppel veld</td><td>
{$name="primaryMatchColumn"}
{if isset($resident.{$name})}
     {$val=$resident.{$name}}
{else}
     {$val=""}
{/if}
   <select id="{$name}" name="{$name}">
   {html_options values=$tbColumns output=$tbColumns selected=$val}
   </select>
</td>
<td>2e koppel veld</td><td colspan="0">
{$name="alternateMatchColumn"}
{if isset($resident.{$name})}
     {$val=$resident.{$name}}
{else}
     {$val=""}
{/if}
   <select id="{$name}" name="{$name}">
   {html_options values=$tbColumns output=$tbColumns selected=$val}
   </select>
</td>
</tr>
<tr>
<td>
<tr><td>
<input type="hidden" name="step" value="{$formStep}">
<a href="javascript:moveToStep(document.form2, {$formStep-1})">Terug</a></td>
<td><a href="javascript:document.form2.reset();">Herstel</a></td>
<td><a href="javascript:moveToStep(document.form2, {$formStep+1})">Verder</a></td>
</tr>
{foreach $users as $row}
<tr><td>Import</td>
{foreach $row as $column}
   <td>{$column}</td>
{/foreach}
</tr>
{/foreach}
</table>
</form>
{elseif $formStep == 3}
<form name="form{$formStep}" method="post" action="{$action}">
<input type="hidden" name="uniqueKey" id="uniqueKey" value="{$uniqueKey}"/>
<table>
<tr>
<td colspan="3">
<a href="javascript:moveToStep(document.form3, {$formStep-1})">Terug</a>
</td>
</tr>
<tr>
<td colspan="3">Actie</td>
<td>{$uniqueKey}</td>
{if count($impColumns) > 0}
{for $i=0 to count($impColumns)-1}
   {$name="destColumn_{$i}"}
   {if $resident.{$name} ne ""}<td>{$resident.{$name}}</td>{/if}
{/for}
{/if}
</tr>
{if count($matchUsers) == 0}
<tr><td colspan="0">Geen records in {$resident.importFile}</td><tr>
{else}
{foreach $matchUsers as $matchUser}
<tr>{$matchUser}</tr>
{/foreach}
{/if}
<tr>
<td colspan="3">
<input type="hidden" name="step" value="{$formStep}">
<a href="javascript:moveToStep(document.form3, {$formStep-1})">Terug</a>
</td>
</tr>
</table>
</form>
{else}
Step = {$formStep}
{/if}
{/block}
