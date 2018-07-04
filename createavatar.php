<!DOCTYPE html><html><head><meta charset="utf-8">

<link id="main" rel="stylesheet" href="http://www.w3schools.com/lib/w3.css" type="text/css" media="screen"/>

</head>
    <title>The Public World Beta Avatar Registration</title>
</head>

<body>

<div class="w3-container w3-blue">
<h1>The Public World Beta Avatar Registration</h1>
</div>


<?php if (!isset($_POST['etape'])): ?>

<form class="w3-container" action="" method="post">
    <input type="hidden" name="etape" value="1" />
	
		
<!-- General items	 -->

	<div class="form-group">
    <label for="base" class="w3-label w3-text-blue control-label">Vorname :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="John" name="osVorname" maxlength="40" />
        </div>
    </div>
<br>	
	
	<div class="form-group">
    <label for="base" class="w3-label w3-text-blue control-label">Nachname :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="Doe" name="osNachname" maxlength="40" />
        </div>
    </div>
<br>	
		
<!-- mysql database items -->	
	
    <div class="form-group">
    <label for="osEMail" class="w3-label w3-text-blue control-label">E-Mail :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="john@doe.com" name="osEMail" maxlength="40" />
        </div>
    </div>
<br>
    <div class="form-group">
    <label for="osPasswd1" class="w3-label w3-text-blue control-label">Password :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="password" placeholder="*********" name="osPasswd1" maxlength="40" />
        </div>
    </div>
<br>
    <div class="form-group">
    <label for="osPasswd" class="w3-label w3-text-blue control-label">Password wiederholung :</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="password" placeholder="*********" name="osPasswd" maxlength="40" />
        </div>
    </div>
<br>
	
<!-- Captcha Anfang -->

    <div class="form-group">
    <label for="osPasswd" class="w3-label w3-text-blue control-label">AntispamID bitte ohne leerzeichen kopieren :  e3542ff9-5fd6-4ed0-a1ac-bccc1f3aa1c6   : Ende</b></label>
        <div class="col-sm-4">
            <input class="w3-input w3-border" type="text" placeholder="AntispamID bitte hier einfügen" name="oscaptcha" maxlength="40" />
        </div>
    </div>
<br>

<!-- Captcha Ende -->

	
<!-- Registration Button -->
	
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="w3-btn-block w3-blue" type="submit" name="submit" value="Registration">Registration</button>
        </div>
    </div>

</form>

<?php endif ?>
	
</div>

<?php
// UUID Generator Random UUID $benutzeruuid = uuidv4()

  function uuidv4() 
  {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

      // 32 bits
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),

      // 16 bits
      mt_rand(0, 0xffff),

      // 16 bits
      mt_rand(0, 0x0fff) | 0x4000,

      // 16 bits - 8 bits
      mt_rand(0, 0x3fff) | 0x8000,

      // 48 bits
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
  }
?>


<?php
// Salt erstellen OK

	function ospswdsalt() {
		$randomuuid = $benutzeruuid;
		$strrep = str_replace("-", "", $randomuuid);
		return md5($strrep);
	}
?>


<?php
// Md5Hash(password) + ":" + passwordSalt

	function ospswdhash($osPasswd, $osSalt) {
		
		return md5(md5($osPasswd).":".$osSalt);
	}
?>



<?php
if (isset($_POST['etape']) AND $_POST['etape'] == 1)
{
  include("./includes/config.php");
 
    // wir schaffen unsere Variablen und alle Leerzeichen beiläufig entfernen	
	$benutzeruuid = uuidv4();
	$inventoryuuid = uuidv4();
	$neuparentFolderID = uuidv4();
    $neuHauptFolderID = uuidv4();
	$oscaptchaid = "e3542ff9-5fd6-4ed0-a1ac-bccc1f3aa1c6";

	$osVorname   = trim($_POST['osVorname']);
	$osNachname   = trim($_POST['osNachname']);
    $osEMail  = trim($_POST['osEMail']);

    $osDatum = mktime();	
    $osPasswd   = trim($_POST['osPasswd']);
	$osPasswd1   = trim($_POST['osPasswd1']);
	
	$oscaptcha  = trim($_POST['oscaptcha']);

	$osSalt = ospswdsalt();
	$osHash = ospswdhash($osPasswd, $osSalt);
	
	// Programmabbruch bei fehlenden Angaben
    if (empty($osVorname)) 
	{
        echo 'Vorname nicht mit einem Wert belegt, oder nicht gesetzt<br>';
	    exit;
    }
	
	if (empty($osNachname)) 
	{
        echo 'Nachname nicht mit einem Wert belegt, oder nicht gesetzt<br>';
	    exit;
    }
	
	if (empty($osEMail)) 
	{
        echo 'E-Mail nicht mit einem Wert belegt, oder nicht gesetzt<br>';
	    exit;
    }
	
	if (empty($osPasswd)) 
	{
        echo 'Passwort oder Passwortwiederholung nicht mit einem Wert belegt, oder nicht gesetzt<br>';
	    exit;
    }
	
	if (empty($osPasswd1)) 
	{
        echo 'Passwort oder Passwortwiederholung nicht mit einem Wert belegt, oder nicht gesetzt<br>';
	    exit;
    }
	
    if($osPasswd != $osPasswd1) 
	{
       echo 'Die Passwörter müssen übereinstimmen<br>';
       exit;
    }
 
     if($oscaptcha != $oscaptchaid) 
	{
       echo 'Captcha Fehler:  ' . $oscaptcha . '   Richtig wäre:  ' . $oscaptchaid;
       exit;
    }
	
	
// Datenbank öffnen
  $pdo = new PDO("mysql:host=$CONF_db_server;dbname=$CONF_db_database", $CONF_db_user, $CONF_db_pass);
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Avatar und Namen checken
 if(!$error) { 
 $statement = $pdo->prepare("SELECT * FROM UserAccounts WHERE FirstName = :FirstName AND LastName = :LastName");
 //$result = $statement->execute(array('FirstName' + 'LastName' => $osVorname + $osNachname));
 $result = $statement->execute(array('FirstName' => $osVorname, 'LastName' => $osNachname));
 $user = $statement->fetch();
 
 if($user !== false) {
 echo 'Der Name ist bereits vergeben<br>';
 exit;
 } 
 } 


// E-Mail checken
  if(!filter_var($osEMail, FILTER_VALIDATE_EMAIL)) {
 echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
 exit;
 } 

 //Überprüfe, ob die E-Mail-Adresse noch nicht registriert wurde
 if(!$error) { 
 $statement = $pdo->prepare("SELECT * FROM UserAccounts WHERE Email = :Email");
 $result = $statement->execute(array('Email' => $osEMail));
 $user = $statement->fetch();
 
 if($user !== false) {
 echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
 exit;
 } 
 }
 
// Avatar eintragen
$neuer_user = array();
$neuer_user['PrincipalID'] = $benutzeruuid;
$neuer_user['ScopeID'] = '00000000-0000-0000-0000-000000000000';
$neuer_user['FirstName'] = $osVorname;
$neuer_user['LastName'] = $osNachname;
$neuer_user['Email'] = $osEMail;
$neuer_user['ServiceURLs'] = 'HomeURI= InventoryServerURI= AssetServerURI=';
$neuer_user['Created'] = $osDatum;
$neuer_user['UserLevel'] = '0';
$neuer_user['UserFlags'] = '0';
$neuer_user['UserTitle'] = '';
$neuer_user['active'] = '1';

 
// $statement = $pdo->prepare("INSERT INTO UserAccounts (email, vorname, nachname) VALUES (:email, :vorname, :nachname)");
$statement = $pdo->prepare("INSERT INTO UserAccounts (PrincipalID, ScopeID, FirstName, LastName, Email, ServiceURLs, Created, UserLevel, UserFlags, UserTitle, active) VALUES (:PrincipalID, :ScopeID, :FirstName, :LastName, :Email, :ServiceURLs, :Created, :UserLevel, :UserFlags, :UserTitle, :active)");
$statement->execute($neuer_user);  
 

// UUID, passwordHash, passwordSalt, webLoginKey, accountType
$neues_passwd = array();
$neues_passwd['UUID']         = $benutzeruuid;
$neues_passwd['passwordHash'] = $osHash;
$neues_passwd['passwordSalt'] = $osSalt;
$neues_passwd['webLoginKey'] = '00000000-0000-0000-0000-000000000000';
$neues_passwd['accountType'] = 'UserAccount';

 
$statement = $pdo->prepare("INSERT INTO auth (UUID, passwordHash, passwordSalt, webLoginKey, accountType) VALUES (:UUID, :passwordHash, :passwordSalt, :webLoginKey, :accountType)");
$statement->execute($neues_passwd);

// Das nachfolgende eintragen in der GridUser Spalte
$neuer_GridUser = array();
$neuer_GridUser['UserID']         = $benutzeruuid;
$neuer_GridUser['HomeRegionID'] = '00000000-0000-0000-0000-000000000000';
$neuer_GridUser['HomePosition'] = '<0,0,0>';
$neuer_GridUser['LastRegionID'] = '00000000-0000-0000-0000-000000000000';
$neuer_GridUser['LastPosition'] = '<0,0,0>';

 
$statement = $pdo->prepare("INSERT INTO GridUser (UserID, HomeRegionID, HomePosition, LastRegionID, LastPosition) VALUES (:UserID, :HomeRegionID, :HomePosition, :LastRegionID, :LastPosition)");
$statement->execute($neuer_GridUser);

// Inventarverzeichnisse erstellen

// Ordner Textures
$Texturesuuid = uuidv4();

$verzeichnistextur = array();
$verzeichnistextur['folderName'] = 'Textures';
$verzeichnistextur['type'] = '0';
$verzeichnistextur['version'] = '1';
$verzeichnistextur['folderID'] = $Texturesuuid;
$verzeichnistextur['agentID'] = $benutzeruuid;
$verzeichnistextur['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnistextur);

// Ordner Sounds
$Soundsuuid = uuidv4();

$verzeichnisSounds = array();
$verzeichnisSounds['folderName'] = 'Sounds';
$verzeichnisSounds['type'] = '1';
$verzeichnisSounds['version'] = '1';
$verzeichnisSounds['folderID'] = $Soundsuuid;
$verzeichnisSounds['agentID'] = $benutzeruuid;
$verzeichnisSounds['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisSounds);

// Ordner Calling Cards
$CallingCardsuuid = uuidv4();

$verzeichnisCallingCards = array();
$verzeichnisCallingCards['folderName'] = 'Calling Cards';
$verzeichnisCallingCards['type'] = '2';
$verzeichnisCallingCards['version'] = '2';
$verzeichnisCallingCards['folderID'] = $CallingCardsuuid;
$verzeichnisCallingCards['agentID'] = $benutzeruuid;
$verzeichnisCallingCards['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisCallingCards);

// Ordner Landmarks
$Landmarksuuid = uuidv4();

$verzeichnisLandmarks = array();
$verzeichnisLandmarks['folderName'] = 'Landmarks';
$verzeichnisLandmarks['type'] = '3';
$verzeichnisLandmarks['version'] = '1';
$verzeichnisLandmarks['folderID'] = $Landmarksuuid;
$verzeichnisLandmarks['agentID'] = $benutzeruuid;
$verzeichnisLandmarks['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisLandmarks);

// Ordner My Inventory
$MyInventoryuuid = uuidv4();

$verzeichnisMyInventory = array();
$verzeichnisMyInventory['folderName'] = 'My Inventory';
$verzeichnisMyInventory['type'] = '8';
$verzeichnisMyInventory['version'] = '17';
$verzeichnisMyInventory['folderID'] = $neuHauptFolderID;
$verzeichnisMyInventory['agentID'] = $benutzeruuid;
$verzeichnisMyInventory['parentFolderID'] = '00000000-0000-0000-0000-000000000000';

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisMyInventory);

// Ordner Photo Album
$PhotoAlbumuuid = uuidv4();

$verzeichnisPhotoAlbum = array();
$verzeichnisPhotoAlbum['folderName'] = 'Photo Album';
$verzeichnisPhotoAlbum['type'] = '15';
$verzeichnisPhotoAlbum['version'] = '1';
$verzeichnisPhotoAlbum['folderID'] = $PhotoAlbumuuid;
$verzeichnisPhotoAlbum['agentID'] = $benutzeruuid;
$verzeichnisPhotoAlbum['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisPhotoAlbum);

// Ordner Clothing
$Clothinguuid = uuidv4();

$verzeichnisClothing = array();
$verzeichnisClothing['folderName'] = 'Clothing';
$verzeichnisClothing['type'] = '5';
$verzeichnisClothing['version'] = '3';
$verzeichnisClothing['folderID'] = $Clothinguuid;
$verzeichnisClothing['agentID'] = $benutzeruuid;
$verzeichnisClothing['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisClothing);

// Ordner Objects
$Objectsuuid = uuidv4();

$verzeichnisObjects = array();
$verzeichnisObjects['folderName'] = 'Objects';
$verzeichnisObjects['type'] = '6';
$verzeichnisObjects['version'] = '1';
$verzeichnisObjects['folderID'] = $Objectsuuid;
$verzeichnisObjects['agentID'] = $benutzeruuid;
$verzeichnisObjects['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisObjects);

// Ordner Notecards
$Notecardsuuid = uuidv4();

$verzeichnisNotecards = array();
$verzeichnisNotecards['folderName'] = 'Notecards';
$verzeichnisNotecards['type'] = '7';
$verzeichnisNotecards['version'] = '1';
$verzeichnisNotecards['folderID'] = $Notecardsuuid;
$verzeichnisNotecards['agentID'] = $benutzeruuid;
$verzeichnisNotecards['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisNotecards);

// Ordner Scripts
$Scriptsuuid = uuidv4();

$verzeichnisScripts = array();
$verzeichnisScripts['folderName'] = 'Scripts';
$verzeichnisScripts['type'] = '10';
$verzeichnisScripts['version'] = '1';
$verzeichnisScripts['folderID'] = $Scriptsuuid;
$verzeichnisScripts['agentID'] = $benutzeruuid;
$verzeichnisScripts['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisScripts);

// Ordner Body Parts
$BodyPartsuuid = uuidv4();

$verzeichnisBodyParts = array();
$verzeichnisBodyParts['folderName'] = 'Body Parts';
$verzeichnisBodyParts['type'] = '13';
$verzeichnisBodyParts['version'] = '5';
$verzeichnisBodyParts['folderID'] = $BodyPartsuuid;
$verzeichnisBodyParts['agentID'] = $benutzeruuid;
$verzeichnisBodyParts['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisBodyParts);

// Ordner Trash
$Trashuuid = uuidv4();

$verzeichnisTrash = array();
$verzeichnisTrash['folderName'] = 'Trash';
$verzeichnisTrash['type'] = '14';
$verzeichnisTrash['version'] = '1';
$verzeichnisTrash['folderID'] = $Trashuuid;
$verzeichnisTrash['agentID'] = $benutzeruuid;
$verzeichnisTrash['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisTrash);

// Ordner Lost And Found
$LostAndFounduuid = uuidv4();

$verzeichnisLostAndFound = array();
$verzeichnisLostAndFound['folderName'] = 'Lost And Found';
$verzeichnisLostAndFound['type'] = '16';
$verzeichnisLostAndFound['version'] = '1';
$verzeichnisLostAndFound['folderID'] = $LostAndFounduuid;
$verzeichnisLostAndFound['agentID'] = $benutzeruuid;
$verzeichnisLostAndFound['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisLostAndFound);

// Ordner Animations
$Animationsuuid = uuidv4();

$verzeichnisAnimations = array();
$verzeichnisAnimations['folderName'] = 'Animations';
$verzeichnisAnimations['type'] = '20';
$verzeichnisAnimations['version'] = '1';
$verzeichnisAnimations['folderID'] = $Animationsuuid;
$verzeichnisAnimations['agentID'] = $benutzeruuid;
$verzeichnisAnimations['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisAnimations);

// Ordner Gestures
$Gesturesuuid = uuidv4();

$verzeichnisGestures = array();
$verzeichnisGestures['folderName'] = 'Gestures';
$verzeichnisGestures['type'] = '21';
$verzeichnisGestures['version'] = '1';
$verzeichnisGestures['folderID'] = $Gesturesuuid;
$verzeichnisGestures['agentID'] = $benutzeruuid;
$verzeichnisGestures['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisGestures);


// Friends
$Friendsuuid = uuidv4();

$verzeichnisFriends = array();
$verzeichnisFriends['folderName'] = 'Friends';
$verzeichnisFriends['type'] = '2';
$verzeichnisFriends['version'] = '2';
$verzeichnisFriends['folderID'] = $Friendsuuid;
$verzeichnisFriends['agentID'] = $benutzeruuid;
$verzeichnisFriends['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisFriends);

// Favorites
$Favoritesuuid = uuidv4();

$verzeichnisFavorites = array();
$verzeichnisFavorites['folderName'] = 'Favorites';
$verzeichnisFavorites['type'] = '23';
$verzeichnisFavorites['version'] = '1';
$verzeichnisFavorites['folderID'] = $Favoritesuuid;
$verzeichnisFavorites['agentID'] = $benutzeruuid;
$verzeichnisFavorites['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisFavorites);

// Current Outfit
$CurrentOutfituuid = uuidv4();

$verzeichnisCurrentOutfit = array();
$verzeichnisCurrentOutfit['folderName'] = 'Current Outfit';
$verzeichnisCurrentOutfit['type'] = '46';
$verzeichnisCurrentOutfit['version'] = '1';
$verzeichnisCurrentOutfit['folderID'] = $CurrentOutfituuid;
$verzeichnisCurrentOutfit['agentID'] = $benutzeruuid;
$verzeichnisCurrentOutfit['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisCurrentOutfit);

// All
$Alluuid = uuidv4();

$verzeichnisAll = array();
$verzeichnisAll['folderName'] = 'All';
$verzeichnisAll['type'] = '2';
$verzeichnisAll['version'] = '1';
$verzeichnisAll['folderID'] = $Alluuid;
$verzeichnisAll['agentID'] = $benutzeruuid;
$verzeichnisAll['parentFolderID'] = $neuHauptFolderID;

$statement = $pdo->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
$statement->execute($verzeichnisAll);

// Avatar Fertig Verbindung schließen
$pdo = null;
}
?>
</body></html>