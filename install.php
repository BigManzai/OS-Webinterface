<!DOCTYPE html><html><head><meta charset="utf-8">

<link id="main" rel="stylesheet" href="http://www.w3schools.com/lib/w3.css" type="text/css" media="screen"/>

</head>
    <title>Splash Config Setup</title>
</head>

<body>





<div class="w3-container w3-blue">
<h1>Splash Config Setup</h1>
</div>



<?php if (!isset($_POST['etape'])): ?>

<form class="w3-container" action="" method="post">
    <input type="hidden" name="etape" value="1" />
	
	
	
	
<!-- General items	 -->

	<div class="form-group">
    <label for="base" class="w3-label w3-text-blue control-label">DNS Name Server :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="http://localhost" name="domaine" maxlength="40" />
        </div>
    </div>
<br>	
	
	<div class="form-group">
    <label for="base" class="w3-label w3-text-blue control-label">Splash path :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="/splash" name="domainepath" maxlength="40" />
        </div>
    </div>
<br>	
		
<!-- mysql database items -->	
	
    <div class="form-group">
    <label for="hote" class="w3-label w3-text-blue control-label">Database Host :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="localhost" name="hote" maxlength="40" />
        </div>
    </div>
<br>
    <div class="form-group">
    <label for="login" class="w3-label w3-text-blue control-label">Database User :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="opensim" name="login" maxlength="40" />
        </div>
    </div>
<br>
    <div class="form-group">
    <label for="mdp" class="w3-label w3-text-blue control-label">Database Password :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="password" placeholder="*********" name="mdp" maxlength="40" />
        </div>
    </div>
<br>
    <div class="form-group">
    <label for="base" class="w3-label w3-text-blue control-label">Robust Database Name :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="opensim" name="base" maxlength="40" />
        </div>
    </div>
<br>	
<!-- The Coordinates of the Grid-Center -->	
	
	<div class="form-group">
    <label for="base" class="w3-label w3-text-blue control-label">Center x :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="5000 (Grid Center X)" name="imapx" maxlength="40" />
        </div>
    </div>
<br>
	<div class="form-group">
    <label for="base" class="w3-label w3-text-blue control-label">Center y :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="5000 (Grid Center Y)" name="imapy" maxlength="40" />
        </div>
    </div>
<br>
<!-- Install Button -->
	
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="w3-btn-block w3-blue" type="submit" name="submit" value="Installer">Install</button>
        </div>
    </div>

</form>

<?php endif ?>
	
</div>

<!-- Keine ahnung -->

<?php if (isset($_POST['delete']))
{
    unlink('install.php');
    header('Location: ./');
}
?>
	


<?php
if (isset($_POST['etape']) AND $_POST['etape'] == 1)
{
    // eine Konstante erzeugen, die später verwendet wird
    define('RETOUR', '<input class="w3-btn-block w3-blue" type="button" value="Return of form" onclick="history.back()">');

    $datei = './includes/config.php';

    if (file_exists($datei) AND filesize($datei ) > 0)
    {
        // wenn die Datei existiert und nicht leer ist, dann
        exit('<div class="alert alert-danger">Not this configuration file, installation corrupt ...</div>'. RETOUR);
    }

    // wir schaffen unsere Variablen und alle Leerzeichen beiläufig entfernen	
	$domaine   = trim($_POST['domaine']);
	$domainepath   = trim($_POST['domainepath']);
	
    $hote   = trim($_POST['hote']);
    $login  = trim($_POST['login']);
    $pass   = trim($_POST['mdp']);
    $base   = trim($_POST['base']);

	$imapx   = trim($_POST['imapx']);
	$imapy   = trim($_POST['imapy']);

    // überprüft die Verbindung mit dem Server, bevor es weiter geht
    if (!mysqli_connect($hote, $login, $pass, $base))
    {
        exit('<div class="alert alert-danger">Bad connection settings, installation corrupt ...</div>'. RETOUR);
    }


    // der Text, der in der config.php gesetzt wird
    $texte = '
<?php

/* General Domain */
$CONF_sim_domain = "'.$domaine.'";		        // Your Grid-Domain
$CONF_install_path = "'.$domainepath.'";		// Installation path

/* MySQL Database */
$CONF_db_server   = "'. $hote .'";		//Your Database-Server
$CONF_db_user  = "'. $login .'";       	// login
$CONF_db_pass    = "'. $pass .'";     	// password
$CONF_db_database   = "'. $base .'"; 		// Name of BDD

/* The Coordinates of the Grid-Center */
$CONF_center_coord_x = "'. $imapx .'";		// the Center-X-Coordinate
$CONF_center_coord_y = "'. $imapy .'";		// the Center-Y-Koordinate

// style-sheet items
$CONF_style_sheet =    "/css/stylesheet.css";          //Link to your StyleSheet

// ------------------------------------------------------------------------------------
// Change this items to your Language
// ------------------------------------------------------------------------------------

  $CONF_txt_north =      "Norden";
  $CONF_txt_south =      "Sueden";
  $CONF_txt_west =       "Westen";
  $CONF_txt_east =       "Osten";
  $CONF_txt_center =     "Center";
  $CONF_txt_refresh =    "Refresh";
  $CONF_txt_occupied =   "Besetzt";
  $CONF_txt_free =       "FREI";
  $CONF_txt_coords =     "Koordinaten";
  
?>';

    if (!$offen = fopen($datei, 'w'))
    {
        exit('<div class="alert alert-danger">Unable to open file : <strong>'. $datei .'</strong>, installation corrupt. Create the file manually (/includes/config.php.example) or change the permissions on the /includes directory.</div>'. RETOUR);
    }

    if (fwrite($offen, $texte) == FALSE)
    {
        exit('<div class="alert alert-danger">Can not write to the file : <strong>'. $datei .'</strong>, installation corrupt. Create the file manually (/includes/config.php.example) or change the permissions on the /includes directory.</div>'. RETOUR);
    }

    echo '<div class="alert alert-success">Creation of effected configuration file with success ...</div>';
    fclose($offen);


    echo '<div class="alert alert-success">Installing the database tables of data effected with success...</div>';
    echo '<div class="alert alert-warning">Please delete the file <strong>install.php</strong> of server ...</div>';
    echo '<form class="form-group" action="" method="post">';
    echo '<input type="hidden" name="delete" value="1" />';
    echo '<div class="form-group">';
    echo '<button class="w3-btn-block w3-red" type="submit" name="submit" >Delete file install.php</button>';
    echo '</div>';
    echo '</form>';
	
}

?>
<div class="clearfix"></div>

</div>
</body>
</html>	
	
