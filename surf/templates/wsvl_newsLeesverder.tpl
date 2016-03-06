{*
 * users.tpl template for user maintenance
 *
 * 19-03-2012: Huug Peters
 *}
{extends file="wsvl_3panels.tpl"}
{block name="topDeel"}
<h1>{$news_title}</h1>
<h3>{$news_date}</h3>
{if $news_image}
	<div>
	   <img src="{$news_imgUrl}"
	       id="newsPhoto" alt="{$news_title}"/>
	</div>
{/if}
{$news_short}
{/block}
{block name="linkerDeel"}
<div style="margin-left:1em;display:block">
{$news_message}
</div>
{HEsocial}
{/block}
{block name="rechterTitel"}
<img src="images/kop_nog-meer.gif" width="188" height="31" alt="Nog meer..."/>
{/block}
{block name="rechterDeel"}
<div class="recentNieuwsKader">
<ul>
{for $i=0 to count($newsIds)-1}
	{$class="nieuwsTitel"}
	{if $newsIds[$i] == $news_id}{$class="nieuwsTitel newsCurrent"}{/if}
		<li><a href="{$action}?news_id={$newsIds[$i]}" class="{$class}" >{$newsTitles[$i]}</a></li>
{/for}
</ul>
</div>
{/block}
