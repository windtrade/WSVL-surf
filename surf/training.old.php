<?php
	include "library/config.inc.php";
	include "library/layout.lib.php";
	include "library/db.lib.php";
	include "library/training.lib.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Training | Windsurfvereniging Leidschendam en omstreken</title>
<meta name="description" content="Windsurfvereniging Leidschendam e.o. is te vinden aan het surfstrand van recreatiegebied Vlietland, langs A4 tussen Leidschendam, Voorschoten en Leiden in. Waar we surflessen, clubwedstrijden en diverse andere activiteiten organiseren.">
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="css/default.css" rel="stylesheet" type="text/css">
<?php

		if( strstr($_SERVER['HTTP_USER_AGENT'],"Gecko") && strstr($_SERVER['HTTP_USER_AGENT'],"rv:0.9.") )
		{
			echo "<link href=\"css/wsvl-ns62.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		}
		elseif( strstr($_SERVER['HTTP_USER_AGENT'],"MSIE 6") )
		{
			echo "<link href=\"css/wsvl-ie6.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		}
		elseif( strstr($_SERVER['HTTP_USER_AGENT'],"MSIE 5") )
		{
			echo "<link href=\"css/wsvl-ie5.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		}

		echo " <!-- ".$_SERVER['HTTP_USER_AGENT']." -->\n";

?>
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
  if (s!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+s)}
  document.MM_returnValue = (s=='');
}

//-->
</script>
</head>
<body>
<div class="contentArea">


	<!-- NAVIGATIE MENU BALK MET LOGO -->
		<div class="navHeader">
			<div id="logo"><img src="images/logo.gif" width="755" height="56"></div>
			<ul>
			  <li><a href="index.php?tab=home">Home</a></li>
			  <li><a href="informatie.php?tab=informatie">Informatie</a></li>
			  <li><a href="kalender.php?tab=kalender">Kalender</a></li>
			  <li><a href="training.php?tab=training" class="current">Training</a></li>
			  <li><a href="foto.php?tab=foto">Foto's</a></li>
			  <li><a href="verslagen.php?tab=verslagen">Wedstrijden &amp; Verslagen</a></li>
			  <!-- <li><a href="onze_surfers.php?tab=onze_surfers" >Onze surfers</a></li> -->
			  <li><a href="http://forum.wvleidschendam.nl/index.php">Forum</a></li>
			  <li><a href="contact.php?tab=contact">Contact</a></li>
			</ul>
		</div>
	<!-- EINDE VAN HET NAVIGATIE MENU BALK MET LOGO -->

<?php


	$volgende_dinsdag =  date("Y-m-d", volgendeTraining());
	//$volgende_dinsdag = "2009-03-31";

	$sql_aanmeldingen = " SELECT * FROM trainingsmaatjes WHERE datum = '".$volgende_dinsdag." 00:00:00' AND aangemeld = 1 ORDER BY naam ASC ";
	$result_aanmeldingen = mysql_query($sql_aanmeldingen);
	$aantal_aanmeldingen = mysql_num_rows($result_aanmeldingen);

	$sql_afmeldingen = " SELECT * FROM trainingsmaatjes WHERE datum = '".$volgende_dinsdag." 00:00:00' AND aangemeld = 0 ORDER BY naam ASC ";
	$result_afmeldingen = mysql_query($sql_afmeldingen);
	$aantal_afmeldingen = mysql_num_rows($result_afmeldingen);


	$sql_aanmeldingen = " SELECT * FROM trainingsmaatjes WHERE datum = '".$volgende_dinsdag." 00:00:00' ORDER BY aangemeld DESC, naam ASC ";
	$result_aanmeldingen = mysql_query($sql_aanmeldingen);

?>

	<!-- BLAUWE KADER MET AANMELDINGEN -->
		<div id="heterKader">

			<div class="trainingAanmeldingen">
				<ul>
				  <div class="heterTitel" style="color: #FFFFFF;">Wie komen er allemaal?</div>
				  <span style="font-size: 10px; color: #FFFFFF;">
			  <?php echo($aantal_aanmeldingen); ?> aanmelding<?php echo(($aantal_aanmeldingen!=1?"en":"")); ?> voor de training van <?php echo(date("d/m/Y", volgendeTraining())); ?></span>
					
<?php
		while($aanmeldingen = mysql_fetch_array($result_aanmeldingen))
		{
?>
					<li><a href="onze_surfers.php?tab=onzesurfers&surfer=<?php echo(stripslashes($aanmeldingen['naam'])); ?>" <?php if($aanmeldingen['aangemeld'] == 0) { echo "class=\"afgemeld\""; }elseif($aanmeldingen['surfspullen'] == 'surfpool') { echo "class=\"surfpool\""; } ?> ><?php echo(ucfirst($aanmeldingen['naam'])); ?> <?php if(in_array(strtolower($aanmeldingen['emailadres']),$trainers)) { ?>(trainer)<?php } ?></a> 
						
						<?php if($aanmeldingen['opmerking'] != '') { ?><em><?php echo(stripslashes($aanmeldingen['opmerking'])); ?></em><?php } ?>
					</li>
<?php
		}

/*		while($afmeldingen = mysql_fetch_array($result_afmeldingen))
		{
?>
					<li><a href="onze_surfers.php?tab=onzesurfers&surfer=<?php echo(stripslashes($afmeldingen['naam'])); ?>" <?php if($afmeldingen['aangemeld'] == 0) { echo "class=\"afgemeld\""; } ?> ><?php echo(ucfirst($afmeldingen['naam'])); ?></a> 
						<?php if(in_array(strtolower($afmeldingen['emailadres']),$trainers)) { ?>(trainer)<?php } ?>
						<?php if($afmeldingen['opmerking'] != '') { ?><br /><em><?php echo(stripslashes($afmeldingen['opmerking'])); ?></em><?php } ?>
					</li>
<?php
		}*/
?>
				</ul>
			</div>

			<div id="heterContent">
				<div class="heterTitel">Meld je ook aan voor de volgende training <em>!</em></div>
				<p>Omdat we graag vooraf willen weten wie er allemaal op <strong>dinsdagavond</strong> mee willen doen met de gevorderden training, graag even het formulier invullen als je van plan bent om te komen.</p>

				<form action="training_aanafmelden.php" method="post" enctype="multipart/form-data" name="trainingAanmeldForm" id="trainingAanmeldForm" onSubmit="YY_checkform('trainingAanmeldForm','aanmeldBevestig','#q','1','Je moet wel nog even bevestigen dat je mee wil trainen!','naam','#q','0','Je bent je naam vergeten in te vullen.','email','#S','2','Je bent je e-mail adres vergeten in te vullen.','datum','#q','1','Je bent vergeten een datum te selecteren.');return document.MM_returnValue">
				<table border="0" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="54" align="left"><strong>Naam </strong></td>
                    <td width="108"><input name="naam" type="text" id="naam" size="18" tabindex="1" /></td>
                    <td width="337" rowspan="3"><input name="aanmeldBevestig" type="radio" value="2" onclick="this.form.datum.disabled=true;" checked tabindex="3">
                      Ik doe met alle trainigen mee. <br>
                      <input name="aanmeldBevestig" type="radio" value="1" onclick="this.form.datum.disabled=false;" tabindex="4">
                      Ik doe alleen met de training mee op:<br>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <select name="datum" id="datum" disabled="disabled" tabindex="5">
	      <?php maakDatumSelectOpties(); ?>
					  </select>				    </td>
                  </tr>
                  <tr>
                    <td align="left"><strong>E-mail </strong></td>
                    <td><input name="email" type="text" id="email" size="18" tabindex="2" /></td>
                  </tr>
<tr><td colspan=2><strong>Wat zijn de eerste twee letters van het logo?</strong><br><input type="text" name="berttest" tabindex="6" /></td></tr>

                  <tr>
                    <td colspan="3" align="left" valign="top" nowrap><strong>                    Opmerking<br>
</strong>                      <textarea name="opmerking" cols="46" rows="2" id="opmerking" tabindex="5"></textarea>
<br>
<div align="right" style="width: 390px;"><span style="color:#FFFFFF; font-style:italic;">Op zoek naar het <a style="color:#FFFFFF;" href="http://surf.wvleidschendam.nl/training_afmelden.php">afmeld formulier</a> ? &nbsp; </span> 
  <input type="submit" name="Submit" value="  AANMELDEN  " />
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
	            <p><img src="images/training_zononder-laura.jpg" alt="Clubwedstrijd op Vlietland" width="165" height="225" align="right" style="margin: 3px;" /><strong>Gevorderden trainingen</strong><br>
                  Iedere  dinsdagavond organiseren we trainingen voor gevorderden op Vlietland.  Laat je niet afschrikken door de term &lsquo;gevorderden&rsquo;, want ook als je  graag een gevorderde surfer wil worden mag je de trainingen niet missen.<br /><br />
				Met of zonder wind, de trainingen gaan altijd door, wil je nu eindelijk  de gijp eens onder de knie krijgen, leer je liever waterstarten, wil je  zo veel mogelijk freestyle truckjes beheersen of wil je gewoon beter  leren surfen? Hou dan de dinsdagavonden vrij in je agenda.<br /><br />
				Om 19.00u (!) wordt je op het water verwacht. Zorg dat je op tijd klaar bent, je zeil optuigen en je surfpak aantrekken kost meer tijd dan je denkt.</p>


			<div class="artikelKader">
				<div class="verslagHomeAuteurInfo">Event: <b>Gevorderden Training - dinsdag 13 juni</b></div>
				<div class="heterTitel">Warm met een aantrekkend windje</div>
			    <p>De hele dag was het windstil en tropisch warm, zonder airco of koud zwembad was het nergens echt goed uit te houden. Rond een uur of zes begon er een verkoelende wind op te steken, mooi op tijd voor het begin van de training.<br>
		        De behendigheid van de surfers gaat met grote sprongen vooruit, overstag en gijpen gaat steeds sneller en met meer stijl. Rond een uur of acht kon er zelfs nog even geplaneerd worden, een mooie afsluiting voor een geslaagde training. </p>			
				
				<div class="verder"><b>RJ</b> | 14-06-2006 |  0 reacties <!--// | <a href="verslag_leesverder.php?event_id=116&amp;verslag_id=49&amp;tab=verslagen#49">Lees verder &raquo;</a>//--></div>
			</div>


			<div class="artikelKader">
				<div class="verslagHomeAuteurInfo">Event: <b>Gevorderden Training - dinsdag 6 juni</b></div>
				<div class="heterTitel">Het was weer druk op Vlietland  </div>
			    <p>De trainingen worden steeds drukker bezocht, vlak voor de training trok de wind nog een klein beetje aan zodat er ook druk geoefend kon worden op het hangen en het snel overstag gaan. Veel surfers hadden nog wat moeite om binnen de 'box' te blijven, een mooi aandachtspuntje voor de volgende trainingen ;) </p>			
				
				<div class="verder"><b>RJ</b> | 07-06-2006 |  0 reacties <!--// | <a href="verslag_leesverder.php?event_id=116&amp;verslag_id=49&amp;tab=verslagen#49">Lees verder &raquo;</a>//--></div>
			</div>


			<div class="artikelKader">
				<div class="verslagHomeAuteurInfo">Event: <b>Gevorderden Training - dinsdag 9 mei</b></div>
				<div class="heterTitel">Planeertraining voor Marc, Marc en Laura</div>
			  <p>Een windje tussen de 9 en 12 knopen, met een beetje inspanning kun je zelfs in deze lichte weersomstandigheden constant planeren. Met een beetje feeling voor de omstandigheden, de juiste timing en het goede ritme, ben je zo in plan&eacute;. <br>
				Dat is natuurlijk makkelijker gezegd dan gedaan, maar na een uurtje oefenen en prutsen hadden de cursisten het truckje aardig begrepen. Bekijk <a href="http://rj.surfspullen.nl/2006/05/aanplaneren-is-een-bijzonder-kunstje-2.html" target="_blank">de video's van de training</a>. </p>			
				
				<div class="verder"><b>RJ</b> | 10-05-2006 |  0 reacties <!--// | <a href="verslag_leesverder.php?event_id=116&amp;verslag_id=49&amp;tab=verslagen#49">Lees verder &raquo;</a>//--></div>
			</div>


			<div class="artikelKader">
				<div class="verslagHomeAuteurInfo">Event: <b>Gevorderden Training - dinsdag 2 mei</b></div>
				<div class="heterTitel">Freestyle training</div>
				<p>Een grote opkomst, om de board- en zeil handling van de aanwezige surfers te verbeteren hebben we vanavond <strong><a href="http://www.stehsegelrevue.com/moves/luv_360/" target="_blank">Upwind-360ies</a></strong>, <strong><a href="http://www.stehsegelrevue.com/moves/cowboy/" target="_blank">Cowboys</a></strong> en <strong><a href="http://www.stehsegelrevue.com/moves/spinloop/" target="_blank">Spinloops</a></strong> geoefend. Alhoewel die laatste move in de vlagen tot 4 knopen misschien niet zo spectaculair was als dat het klinkt ;)</p>			
				
				<div class="verder"><b>RJ</b> | 03-05-2006 |  0 reacties  <!--// | <a href="verslag_leesverder.php?event_id=116&amp;verslag_id=49&amp;tab=verslagen#49">Lees verder &raquo;</a>//--></div>
			</div>


            
		</div>

 		<div class="rechterDeel">
			<div class="titelBalk"><img src="images/kop_nog-meer.gif" width="188" height="31" ></div>
			<div class="recentNieuwsKader">

<div class="recentNieuwsBericht">
				<span class="nieuwsTitel">Trainingsbijdrage</span><br />
				<span class="nieuwsAuteur"></span>
				<p>Zorg ervoor dat je tijdens je eerste training ook je trainingsbijdrage bij je hebt, het liefst gepast. Meer over de <a href="http://surf.wvleidschendam.nl/informatie_leesverder.php?tekst=23&rubriek_id=3&tab=informatie">Trainingsbijdrage</a> vindt je op de <a href="http://surf.wvleidschendam.nl/informatie_leesverder.php?tekst=23&rubriek_id=3&tab=informatie">informatie pagina's</a>.</p>
</div>

<div class="recentNieuwsBericht">
				<span class="nieuwsTitel">Dinsdagavondprogramma </span><br />
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

<div class="recentNieuwsBericht">
				<span class="nieuwsTitel">Afmelden</span><br />

				<span class="nieuwsAuteur"></span>
				<p>Heb je jezelf al aangemeld voor de komende training, maar gaat het je om wat voor reden toch niet lukken om er bij te zijn? 
		        <a href="training_afmelden.php">Meld je dan even af</a>.</p>
</div>

<div class="recentNieuwsBericht">
				<span class="nieuwsTitel">Trainingsschema</span><br />

				<span class="nieuwsAuteur"></span>
				<p>

				<ul style="list-style-type: square;">
				<?php
				$maanden = array(0,'januari','februari','maart',
						    'april','mei','juni',
						    'juli','augustus','september',
						    'oktober','november','december');
				$now = time();
				for ($training = eersteTraining() ; $training <= eindeTraining() ; $training+=7*24*3600) {
					$mnd = date("n", $training);
					$style = "list-style-type: square; padding-left: 20px;";
					if ($now > $training) $style .= "text-decoration:line-through";
					echo sprintf('<li style="%s">%s %s %s</li>',
						$style, date("d", $training), $maanden[$mnd], date("Y", $training));
				}
				?>
				</ul>
				</p>

</div>


		</div>
		</div>	
		<!-- EINDE VAN HET RECHTERDEEL -->

	</div>
	<!-- AFSLUITEN VAN DE TWEE DELEN -->

</div>
<div class="footerTxt">
			Copyright &copy; 1978-<?php printf(date("Y", time())) ?> Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href="http://www.watersportverbond.nl" target="_blank"><img src="images/logo_watersportverbond.gif" alt="Watersportverbond" border="0" /></a>&nbsp;<a href="http://www.cwo.nl" target="_blank"><img src="images/logo_cwo.gif" alt="CWO" border="0" /></a>
</div>
<!-- Google analytics -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-325606-2";
urchinTracker();
</script>
</body>
</html>
