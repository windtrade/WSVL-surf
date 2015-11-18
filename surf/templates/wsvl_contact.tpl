{*
 * wsvl_contact.tpl contact form
 *
 * 31-12-2014: Huug Peters
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
<div class="heterTitel">Heb je vragen? Gebruik dit contactformulier<em>!</em></div>
<p>Als je naar aanleiding van de website nog vragen hebt kun je die hier achterlaten. Wij zullen dan zo spoedig mogelijk contact met je opnemen.</p>
<form id="newMember" enctype="multipart/form-data" method="POST" action="{$smarty.server.REQUEST_URI}">
<table>
{foreach $data key=key item=group}
{$prefix = "fd[{$key}]"}
{foreach $group as $elt}
{if $elt.value != "" || !$elt.protected}
<tr>
{HFlabeledField prefix={$prefix} data=$elt}
</tr>
{/if}
{/foreach}
{/foreach}
{if $NOROBOT == false}
<tr>{HFrecaptcha}</tr>
{/if}
<tr>
<td>
<input type="submit" name="command" value="VERSTUUR">
</td>
<td>
<input type="reset" value="WISSEN">
</td></tr>
</table>
</form>
</div>
{/block}
{block name="linkerDeel"}
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
</div>
{/block}
