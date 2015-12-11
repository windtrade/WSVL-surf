{*
 * users.tpl template for user maintenance
 *
 * 19-03-2012: Huug Peters
 *}
{extends file="wvLeidschendam.tpl"}
{block name="title"}WV Leidschendam Nieuws{/block}
{block name="body"}
<div class="tweeDelen">
	<div class="linkerDeel">
		<div class="titelBalk">
			<img src="images/overgangs-streep.gif" />
		</div>
		<div class="nieuwsTitel" />
			<div class="objTitel">{$news_title}</div>
		</div>
			<div class="objDatum">{$news_date}</div>
			<hr align="left" size="1" noshade />
			{if $news_image}
			<div width="100%">
			    <img src="{$news_imgUrl}"
			     id="newsPhoto" width="90%" title="{$news_title}"/>
			</div>
			{/if}
		<div>
			<p><b>{$news_short}</b><p/>
			{$news_message}
            {HEsocial}
		</div>
	</div>
	<div class="rechterDeel">
		<div class="titelBalk"><img src="images/kop_ander-nieuws.gif" /></div>
		<div class="recentNieuwsKader">
		<ul>
		{for $i=0 to count($newsIds)-1}
			{$class="nieuwsTitel"}
			{if $newsIds[$i] == $news_id}{$class="nieuwsTitel newsCurrent"}{/if}
			<li><a href="{$action}?news_id={$newsIds[$i]}" class="{$class}" >{$newsTitles[$i]}</a></li>
		{/for}
		</ul>
		</div>
	</div>
</div>
{/block}
