{*
 * wsvl_Home.tpl template for home page
 *
 * 25-12-2012: Huug Peters
 *}
{extends file="wvLeidschendam.tpl"}
{block name="body"}
{$heterOpen=0}
{foreach from=$hotNews item=hotItem}
    {if !$heterOpen}
	{$heterOpen=1}
	<div class="heter">
    {/if}
    <div class="heterContent">
    {if $hotItem.news_image != ""}
	<img src="{$hotItem.news_image}" alt="{$hotItem.news_title}" class="img_small"/>
    {/if}
    {if $hotItem.news_title != ""}
	<h3>{$hotItem.news_title}</h3>
    {/if}
    <p>{$hotItem.news_short}</p>
    <div class="linkLogo">
    <a href="news_leesverder.php?news_id={$hotItem.news_id}">
    <img src="{$imageRoot}/butt_sm_leesverder.gif" alt="Lees verder">
    </a>
    </div>
    </div>
{/foreach}
{if $heterOpen}
    </div>
    <div class="heterBottom">
        <img src="{$imageRoot}/heter_dan_de_overstag.gif" alt="heter dan de Overstag">
    </div>
{/if}
<div class="tweeDelen">
	<div class="linkerDeel">
	<div class="titelBalk"><img src="{$imageRoot}/kop_over-ons.gif" alt="Over ons"/></div>
	   	<p>{$aboutUs}<p>
	</div>
	<div class="rechterDeel">
		<div class="titelBalk"><img src="{$imageRoot}/kop_recent-nieuws.gif" alt="Recent nieuws"/></div>
		<div class="recentNieuwsKader">
		{$i=0}{$ul=0}
		{foreach from=$newsItems item=newsItem}
		    {if $i < 2}
			<div class="recentNieuwsBericht">
			<h2 class="nieuwsTitel">{$newsItem.news_title}</h2>
			<p>{$newsItem.news_short}</p>
			<div class="miniLeesverder">
			    <a href="news_leesverder.php?news_id={$newsItem.news_id}">
				<img src="{$imageRoot}/butt_sm_leesverder.gif" alt="Lees verder"/>
			    </a>
			</div>
			</div>
		    {else}
			{if $ul==0} <ul> {$ul=1} {/if}
			<li class="nieuwsTitel">
			    <a href="news_leesverder.php?news_id={$newsItem.news_id}">
			        {$newsItem.news_title}
			    </a>
			</li>
		    {/if}
			{$i=$i+1}
		{/foreach}
		{if $ul != 0}</ul>{/if}
		</div>
	</div>
</div>
{/block}

