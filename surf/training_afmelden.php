<?php
	include "library/config.inc.php";
	include "library/layout.lib.php";
	include "library/db.lib.php";
	include "library/training.lib.php";
	
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);


	if($_REQUEST['datum'] && $_REQUEST['email'] && $_REQUEST['datum'])
	{
		$token = addslashes(trim($_REQUEST['token']));
		$email = addslashes(trim($_REQUEST['email']));
		$datum = addslashes(date("Y-m-d H:i:s",strtotime($_REQUEST['datum'])));

		$sql_check = " SELECT * FROM trainingsmaatjes WHERE token = '".$token."' AND emailadres = '".$email."' AND datum = '".$datum."' ";

		$result_aanmeldingen = mysql_query($sql_check);
		$aanmeldingen = mysql_fetch_array($result_aanmeldingen);
	
	}
	else
	{
		// afmelden zonder info vooraf bekend.
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Training afmelden | Windsurfvereniging Leidschendam en omstreken</title>
<meta name="description" content="Windsurfvereniging Leidschendam e.o. is te vinden aan het surfstrand van recreatiegebied Vlietland, langs A4 tussen Leidschendam, Voorschoten en Leiden in. Waar we surflessen, clubwedstrijden en diverse andere activiteiten organiseren.">
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="css/default.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="wvleidschendam.js"></script>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.71
//copyright (c)1998,2002 Yaromat.com
  var a=YY_checkform.arguments,oo=true,v='',s='',err=false,r,o,at,o1,t,i,j,ma,rx,cd,cm,cy,dte,at;
  for (i=1; i<a.length;i=i+4){
    if (a[i+1].charAt(0)=='#'){r=true; a[i+1]=a[i+1].substring(1);}else{r=false}
    o=MM_findObj(a[i].replace(/\[\d+\]/ig,""));
    o1=MM_findObj(a[i+1].replace(/\[\d+\]/ig,""));
    v=o.value;t=a[i+2];
    if (o.type=='text'||o.type=='password'||o.type=='hidden'){
      if (r&&v.length==0){err=true}
      if (v.length>0)
      if (t==1){ //fromto
        ma=a[i+1].split('_');if(isNaN(v)||v<ma[0]/1||v > ma[1]/1){err=true}
      } else if (t==2){
        rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");if(!rx.test(v))err=true;
      } else if (t==3){ // date
        ma=a[i+1].split("#");at=v.match(ma[0]);
        if(at){
          cd=(at[ma[1]])?at[ma[1]]:1;cm=at[ma[2]]-1;cy=at[ma[3]];
          dte=new Date(cy,cm,cd);
          if(dte.getFullYear()!=cy||dte.getDate()!=cd||dte.getMonth()!=cm){err=true};
        }else{err=true}
      } else if (t==4){ // time
        ma=a[i+1].split("#");at=v.match(ma[0]);if(!at){err=true}
      } else if (t==5){ // check this 2
            if(o1.length)o1=o1[a[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!o1.checked){err=true}
      } else if (t==6){ // the same
            if(v!=MM_findObj(a[i+1]).value){err=true}
      }
    } else
    if (!o.type&&o.length>0&&o[0].type=='radio'){
          at = a[i].match(/(.*)\[(\d+)\].*/i);
          o2=(o.length>1)?o[at[2]]:o;
      if (t==1&&o2&&o2.checked&&o1&&o1.value.length/1==0){err=true}
      if (t==2){
        oo=false;
        for(j=0;j<o.length;j++){oo=oo||o[j].checked}
        if(!oo){s+='* '+a[i+3]+'\n'}
      }
    } else if (o.type=='checkbox'){
      if((t==1&&o.checked==false)||(t==2&&o.checked&&o1&&o1.value.length/1==0)){err=true}
    } else if (o.type=='select-one'||o.type=='select-multiple'){
      if(t==1&&o.selectedIndex/1==0){err=true}
    }else if (o.type=='textarea'){
      if(v.length<a[i+1]){err=true}
    }
    if (err){s+='* '+a[i+3]+'\n'; err=false}
  }
  if (s!=''){alert('The required information is incomplete or contains errors: '+s)}
  document.MM_returnValue = (s=='');
}
//-->
</script></head>
<body>
<div class="contentArea">


	<!-- NAVIGATIE MENU BALK MET LOGO -->
		<div class="navHeader">
			<div id="logo"><img src="images/logo.gif" width="755" height="56"></div>
			<ul>
			  <li><a href="index.php?tab=home" class="current">Home</a></li>
			  <li><a href="informatie.php?tab=informatie">Informatie</a></li>
			  <li><a href="kalender.php?tab=kalender">Kalender</a></li>

			  <li><a href="training.php?tab=contact" class="current">Training</a></li>

			  <li><a href="foto.php?tab=foto">Foto's</a></li>
			  <!-- <li><a href="verslagen.php?tab=verslagen">Wedstrijden &amp; Verslagen</a></li> -->
			  <!-- <li><a href="onze_surfers.php?tab=onze_surfers" >Onze surfers</a></li> -->
			  <li><a href="http://forum.wvleidschendam.nl/index.php">Forum</a></li>
			  <li><a href="contact.php?tab=contact">Contact</a></li>

			</ul>
		</div>
	<!-- EINDE VAN HET NAVIGATIE MENU BALK MET LOGO -->

	<!-- BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->
		<div id="heterKader">

			<img src="images/training_oplijnen.jpg" width="300" height="225" align="left" id="heterFoto" />

			<div id="heterContent">
				<div class="heterTitel">Afmelden voor de training </div>
				<p>Heb je jezelf aangemeld voor de komende training, maar gaat het je om wat voor reden toch niet lukken om er bij te zijn? Meld je dan even af. </p>

				<form action="training_aanafmelden.php" method="post" enctype="multipart/form-data" name="trainingAanmeldForm" id="trainingAanmeldForm" onSubmit="YY_checkform('trainingAanmeldForm','afmeldBevestig','#q','1','Je moet wel nog even bevestigen dat je je af meldt!','naam','#q','0','Je bent je naam vergeten in te vullen.','email','#S','2','Je bent je e-mail adres vergeten in te vullen.');return document.MM_returnValue">
				<input type="hidden" name="berttest" value="wi"> <!-- no need for BertTest here -->
				<table border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="48" align="left"><strong>Naam </strong></td>
                    <td width="177"><input name="naam" type="text" id="naam" size="22" value="<?php if($aanmeldingen['naam'] != '') { echo(stripslashes($aanmeldingen['naam'])); } ?>" /></td>
                    <td width="279"><input name="afmeldBevestig" type="checkbox" id="afmeldBevestig" value="1" /> 
                    Afmelden voor de training van
</td>
                  </tr>
                  <tr>
                    <td align="left"><strong>E-mail </strong></td>
                    <td><input name="email" type="text" id="email" size="22" value="<?php if($aanmeldingen['emailadres'] != '') { echo(stripslashes($aanmeldingen['emailadres'])); } ?>" /></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <select name="datum" id="datum">
	      <?php maakDatumSelectOpties(); ?>
					  </select>
                    <input type="hidden" name="token" id="token" value="<?php echo($aanmeldingen['token']); ?>">				    </td>
                  </tr>

                  <tr>
                    <td colspan="3" align="left" valign="top" nowrap><strong>Opmerking<br>
</strong>                      <textarea name="opmerking" cols="46" rows="2" id="opmerking"></textarea>
<br>
<div align="right" style="width: 390px;"><input type="submit" name="Submit" value="  AFMELDEN  " />
</div></td>
                  </tr>
                </table>
			  </form>
				<div></div>
			</div>
  </div>

		<div class="heterBottom">
			<img src="images/komjijooktrainen.gif" width="442" height="47" align="right" />		</div>
	<!-- EINDE VAN HET BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->


	<!-- HET ONDERDERSTE GEDEELTE VAN DE PAGINA, DAT IN TWEE DELEN IS GESPLITST -->
	<div class="tweeDelen">

		<div class="linkerDeel">

			<div class="titelBalk"><img src="images/kop_informatie.gif" width="186" height="29" ></div>
	            <p><strong>Gevorderden trainingen</strong><br>
                  Iedere  dinsdagavond organiseren we trainingen voor gevorderden op Vlietland.  Laat je niet afschrikken door de term &lsquo;gevorderden&rsquo;, want ook als je  graag een gevorderde surfer wil worden mag je de trainingen niet missen.<br /><br />
				Met of zonder wind, de trainingen gaan altijd door, wil je nu eindelijk  de gijp eens onder de knie krijgen, leer je liever waterstarten, wil je  zo veel mogelijk freestyle truckjes beheersen of wil je gewoon beter  leren surfen? Hou dan de dinsdagavonden vrij in je agenda.<br /><br />
		  We beginnen om 19.00u (!) Zorg dat je op tijd klaar bent, je zeil optuigen en je surfpak aantrekken kost meer tijd dan je denkt.</p>

            
		</div>

 		<div class="rechterDeel">
			<div class="titelBalk"><img src="images/kop_nog-meer.gif" width="188" height="31" ></div>
			<div class="recentNieuwsKader">

<div class="recentNieuwsBericht">
				<span class="nieuwsTitel">Avondprogramma </span><br />
				<span class="nieuwsAuteur"></span>
				<p>18:15 - Aankomst<br>
				  18:20 - Optuigen<br>
				  18:45 - Surfpak aantrekken<br>
				  19:00 - Voorbespreking van de training<br>
				  19:10 - Het water op<br>
				  20:30 - Nabespreken en evalueren<br>
				  20:45 - Opruimen
				  <br>
</p>
</div>
<div class="recentNieuwsBericht">
				<span class="nieuwsTitel">Optuigen</span><br />

				<span class="nieuwsAuteur"></span>
				<p>Als je gebruik maakt van de Surfpool en op dinsdagavond op verenigingsmateriaal surft is het slim om ruim op tijd te komen, je spullen optuigen duurt altijd langer dan je denkt.</p>
</div>

<p>&nbsp;</p>


		</div>
		</div>	
		<!-- EINDE VAN HET RECHTERDEEL -->

	</div>
	<!-- AFSLUITEN VAN DE TWEE DELEN -->

</div>
<div class="footerTxt">
			Copyright &copy; 1978-2006 Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href="http://www.watersportverbond.nl" target="_blank"><img src="images/logo_watersportverbond.gif" alt="Watersportverbond" border="0" /></a>&nbsp;<a href="http://www.cwo.nl" target="_blank"><img src="images/logo_cwo.gif" alt="CWO" border="0" /></a>
</div>
</body>
</html>
