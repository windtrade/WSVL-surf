{*
 * wsvl_aanmeldenLid.tpl template for registration of new members
 *
 * 30-12-2014: Creation
 *}
{extends file="wsvl_personal.tpl"}
{block name="title"}WV Leidschendam Beheer Lidmaatschap{/block}
{block name="topdeel"}
<div class="heter">
<div class="heterContent">
<h1>Aanvraag surflidmaatschap WV Leidschendam</h1>

Door onderstaand formulier in te vullen doe je een verzoek aan de <strong>Watersportvereniging Leidschendam en Omstreken</strong> om als (jeugd-)surflid te worden toegelaten.
Het lidmaatschap gaat in zodra het bestuur van de vereniging de aanvraag heeft goedgekeurd en de contributie voor het lopende kalenderjaar is voldaan.
Het lidmaatschap wordt in principe jaarlijks stilzwijgend verlengd, tenzij het lid of diens wettelijk vertegenwoordiger uiterlijk op 31 oktober aangeeft het lidmaatschap niet te willen voortzetten.
<form id="newMember" enctype="multipart/form-data" method="POST" action="{$smarty.server.REQUEST_URI}">
<table>
{foreach from=$data key=key item=group}
{foreach from=$group item=elt}
{if $elt.value != "" || !$elt.protected}
<tr>
{HFlabeledField prefix="fd[{$key}]" data=$elt}
</tr>
{/if}
{/foreach}
{/foreach}
{if $NOROBOT == false}
<tr>{HFrecaptcha}</tr>
{/if}
<tr>
<td>{HFsubmit name="command" value="AANMELDEN"}</td>
<td>{HFreset value="WISSEN"}</td>
</tr>
</table>
</form>
</div>
</div>
{/block}
{block name="linkerDeel"}
{HEtext textId="3"}
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
</div>
{/block}
