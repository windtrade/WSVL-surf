<!DOCTYPE HTML>
<HTML>
<head>
<meta name="viewport" content="width=device-width, height=device-height">  
<meta http-equiv="Content-type" content="text/html;charset=iso-8859-2">
<meta name="google" content="notranslate">
<meta name="description" content="Windsurfvereniging Leidschendam e.o. is te vinden aan het surfstrand van recreatiegebied Vlietland, langs A4 tussen Leidschendam, Voorschoten en Leiden in. Waar we surflessen, clubwedstrijden en diverse andere activiteiten organiseren.">
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="{$stylesheet}" rel="stylesheet" type="text/css">
<title>{block name="title"}Informatie | Windsurfvereniging Leidschendam en omstreken{/block}</title>
{foreach $javascriptFiles as $script}
<script type="text/javascript" src="{$script}"></script>
{/foreach}
{if count($javascriptStatements)}
<script type="text/javascript">
{foreach $javascriptStatements as $statement}
{$statement}
{/foreach}
</script>
{/if}
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="contentArea">
<!-- NAVIGATIE MENU BALK MET LOGO -->
<div class="navHeader" id="navHeader">
<h1>Windsurfvereniging Leidschendam en omstreken - surfclub in de regio Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag, Oegstgeest. <img id="navHeaderLogo" src="images/logo.gif" width="755" height="56"><!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //--></h1>
</div>
<div class="huug" id="huug">
{HEcssmenu menu=$mainMenu id="cssmenu" hassub="has-sub" last="last"}
</div>
<div class="errors">
{foreach $errors as $error}
<div class="error">{$error}</div>
{/foreach}
</div>
{if $mustLogin and not $loggedIn}
<div class="login">
<form method="POST" action="{$smarty.server.REQUEST_URI}">
emailadres of nick:
<input name="login" type="text" size="25" />
wachtwoord:
<input name="password" type="password" size="15" />
<input name="action" type="hidden" value="login">
<input type="submit" value="in loggen">
</form>
</div>
{else}
{block name="body"}Deze pagina is nog niet ingevuld{/block}
{/if}
</div>
<div class="footerTxt">
	Copyright &copy; 1978-{$smarty.now|date_format:'%Y'} Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href="http://www.watersportverbond.nl" target="_blank"><img src="images/logo_watersportverbond.gif" alt="Watersportverbond" border="0" /></a>&nbsp;<a href="http://www.cwo.nl" target="_blank"><img src="images/logo_cwo.gif" alt="CWO" border="0" /></a>
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
{/if}
</html>
