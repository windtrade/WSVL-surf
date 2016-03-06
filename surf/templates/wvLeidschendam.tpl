<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, height=device-height"/>  
<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
<meta name="google" content="notranslate"/>
<meta name="description" content="Windsurfvereniging Leidschendam e.o. op het surfstrand van Vlietland. Daar vind je windsurfles, training, clubwedstrijde, windsurfweekends en nog veel meer." />
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="{$stylesheet}" rel="stylesheet" type="text/css"/>
<title>{block name="title"}{$og.title}{/block}</title>
{foreach $og as $tag => $val}
<meta property="og:{$tag}" content="{$val}" />
{/foreach}
{foreach $javascriptFiles as $script}
<script type="text/javascript" src="{$script}"></script>
{/foreach}
{if count($javascriptStatements)}
<script type="text/javascript">
{foreach $javascriptStatements as $statement}
{$statement}
{/foreach}
</script>
<script type="text/javascript">
   $(document).ready(function(){
      showLogin({$mustLogin} && !{$loggedIn});
      addOnClicks();
      $(document).ajaxError(function(event,xhr,options,exc)
      {
        window.alert("exception"+event);
      })
   });
</script>
{/if}
</head> 
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<!-- 21-1-2016 removed illegal characters from twitter script -->
<script>window.twttr = (function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0],
t = window.twttr || {};
if (d.getElementById(id)) return t;
js = d.createElement(s);
js.id = id;
js.src = "https://platform.twitter.com/widgets.js";
fjs.parentNode.insertBefore(js, fjs); 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));
</script>
<div class="contentArea">
<!-- NAVIGATIE MENU BALK MET LOGO -->
<div class="navHeader" id="navHeader">
<h1>Windsurfvereniging Leidschendam en omstreken - surfclub in de regio Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag, Oegstgeest. <img id="navHeaderLogo" src="images/logo.gif" width="755" height="56" alt="WV Leidschendam - Surf"/>
<!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //--></h1>
</div>
<div class="huug" id="huug">
{HEcssmenu menu=$mainMenu id="cssmenu" hassub="has-sub" last="last"}
</div>
<div class="errors">
{foreach $errors as $error}
<div class="error">{$error}</div>
{/foreach}
</div>
<div class="infos">
{foreach $infos as $info}
<div class="info">{$info}</div>
{/foreach}
</div>
<div class="login">
<form method="POST" {*action="{$smarty.server.REQUEST_URI}" *}name="loginform">
emailadres of nick:
<input name="login" type="text" size="25" />
wachtwoord:
<input name="password" type="password" size="15" />
<input name="action" type="hidden" value="JSONlogin"/>
<input type="button" value="inloggen" onclick="logonJSON()"/>
<input type="button" value="annuleren" onclick="showLogin(false)"/>
</form>
</div>
{block name="body"}Deze pagina is nog niet ingevuld{/block}
</div>
<div class="footerTxt">
	Copyright &copy; 1978-{$smarty.now|date_format:'%Y'} Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href="http://www.watersportverbond.nl" target="_blank"><img src="images/logo_watersportverbond.gif" alt="Watersportverbond" style="border:no" /></a>&nbsp;
            <a href="http://www.cwo.nl" target="_blank"><img src="images/logo_cwo.gif" alt="CWO" style="border:no" /></a>
<!-- Google analytics -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-325606-2";
urchinTracker();
</script>
</div>
</body>
{if count($traces)}
{foreach $traces as $trace}
<!-- {$trace} -->
{/foreach}
{/if}
<!-- {$template} -->
</html>
