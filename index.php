<!DOCTYPE html>
<html lang="en">

<!-- Style der Seite Anfang -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<link id="main" rel="stylesheet" href="./css/splash.css" type="text/css" media="screen"/>
 <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon.png">
</head>


<!-- Bilder Slider -->
<script language="javascript">
var time = 9000 //Die Zeit wie lange ein Bild angezeigt wird in ms
var bild = new Array();
bild[0] = "./img/Snapshot_019.jpg"; //Deine Bilder (belibig erweiterbar)
bild[1] = "./img/Snapshot_001.jpg";
bild[2] = "./img/Snapshot_002.jpg";
bild[3] = "./img/Snapshot_003.jpg";
bild[4] = "./img/Snapshot_004.jpg"; 
bild[5] = "./img/Snapshot_005.jpg";
bild[6] = "./img/Snapshot_006.jpg";
bild[7] = "./img/Snapshot_007.jpg";
bild[8] = "./img/Snapshot_008.jpg";
bild[9] = "./img/Snapshot_009.jpg";
bild[10] = "./img/Snapshot_010.jpg"; 
bild[11] = "./img/Snapshot_011.jpg";
bild[12] = "./img/Snapshot_012.jpg";
bild[13] = "./img/Snapshot_013.jpg";
bild[14] = "./img/Snapshot_014.jpg";
bild[15] = "./img/Snapshot_015.jpg"; 
bild[16] = "./img/Snapshot_016.jpg";
bild[17] = "./img/Snapshot_017.jpg";
bild[18] = "./img/Snapshot_018.jpg";


var narf = "0";
function bildwechseln() {
document.wechselbild.src = bild[narf];
narf++;
if (narf == bild.length) {
narf = 0;
}
setTimeout("bildwechseln()",time);
}
</script>

<!-- Hauptbereich anfang -->
<body onLoad="bildwechseln()">

<!-- Hintergrund splash.css name background1 -->

<div id='background1'>
<img src="./img/hintergrund.png" border="0" alt=" " name="wechselbild" width="100%" height="100%">
</div>



<div id='main'><br>
<table border="0" width="100%" height="100%' cellspacing="0" cellpadding="0">

        <tr>
                <img border="0" src="./img/logo.png" width="60%" height="15%">
                </td>
        </tr>

</table>
</div>

<!-- Statistik rechts oben splash.css name stats1 -->
<div id='stats1'>
<fieldset class='grey'>

<!-- Datenbankabfrage Statistik -->
<?php

  include("./includes/config.php");
  
$con = mysqli_connect($CONF_db_server,$CONF_db_user,$CONF_db_pass,$CONF_db_database);

// Query the database and get the count

$result1 = mysqli_query($con,"SELECT COUNT(*) FROM Presence") or die("Error: " . mysqli_error($con));
list($totalUsers) = mysqli_fetch_row($result1);

$result2 = mysqli_query($con,"SELECT COUNT(*) FROM regions") or die("Error: " . mysqli_error($con));
list($totalRegions) = mysqli_fetch_row($result2);

$result3 = mysqli_query($con,"SELECT COUNT(*) FROM UserAccounts") or die("Error: " . mysqli_error($con));
list($totalAccounts) = mysqli_fetch_row($result3);

$result4 = mysqli_query($con,"SELECT COUNT(*) FROM GridUser WHERE Login > (UNIX_TIMESTAMP() - (30*86400))") or die("Error: " . mysqli_error($con));
list($activeUsers) = mysqli_fetch_row($result4);

// Display the results

echo "<div id='stats2'><b><font color=#00FF00>Nutzer im Grid</font><font color=#FFFFFF> : ". $totalUsers ."<font color=#FFFFFF><br>";
echo "<font color=#00FF00>Regionen</font> : ". $totalRegions ."<font #FFFFFF><br>";
echo "<font color=#00FF00>Aktiv in den letzten 30 Tage</font> : ". $activeUsers ."<font color=#FFFFFF><br>";
echo "<font color=#00FF00>Nutzer</font> : ". $totalAccounts ."<font color=#FFFFFF><br>";
echo "<font color=#00AA00>Grid is ONLINE</font></b><br></div>";
/* echo "<font color=#AA0000>Grid is OFFLINE</font></b>";<br></div> */
?>


</fieldset>
</div>
<div id='regions1'><fieldset class='white2'>

<!-- Die Regionsauswahl diese muss leider von Hand geändert werden -->
<a href="secondlife://Welcome" target="_self" style="text-decoration: none;">Welcome</a><br><hr>
<a href="secondlife://Region1" target="_self" style="text-decoration: none;">Region1</a><br><hr>
<a href="secondlife://Region2" target="_self" style="text-decoration: none;">Region2</a><br><hr>
<a href="secondlife://Region3" target="_self" style="text-decoration: none;">Region3</a><br><hr>
<a href="secondlife://Region4" target="_self" style="text-decoration: none;">Region4</a><br><hr>
<a href="secondlife://Region5" target="_self" style="text-decoration: none;">Region5</a><br><hr>
<a href="secondlife://Sandbox" target="_self" style="text-decoration: none;">Sandbox</a><br>
<!-- Die Regionsauswahl Ende -->

<!-- </fieldset>
</div> -->

</fieldset>
</div>
<div id='links'><fieldset class='white2'>

<!-- Die Linkauswahl -->
<a href="/" target="_blank" style="text-decoration: none;">Homepage Infoseite</a><br><hr>
<a href="http://alpha.singularityviewer.org/alpha/" target="_blank" style="text-decoration: none;">Viewer Anzeigeprogramm</a><br><hr>
<a href="/splash/mapindexmax.php" target="_blank" style="text-decoration: none;">Regionen Karte Map</a><br><hr>
<a href="/splash/fs2lsl/index.htm" target="_blank" style="text-decoration: none;">OSSL LSL Online Editor</a><br><hr>
<a href="/splash/Regionsgenerator/RegionsgeneratorV1_2.php" target="_blank" style="text-decoration: none;">Regionsdateien erstellen</a><br><hr>
<!-- Die Linkauswahl Ende -->

</fieldset>
</div>

<!-- Hier wird die Karte eingebunden --> 
<iframe
frameborder="0" src="./map.php" width="170%" height="150%" style="padding:1px; 
position:absolute; top:50%; left:50%; zoom: 0.30; -moz-transform: scale(0.30); -moz-transform-origin: 0 0; -o-transform: scale(0.30); -o-transform-origin: 0 0; -webkit-transform: scale(0.30); -webkit-transform-origin: 0 0;">
</iframe>

</div>

</body>
<!-- Hauptbereich Ende -->

</html>
