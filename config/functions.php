<?php

if(isset($_GET['page']) && $_GET['page'] == "logout"){
unset($_SESSION['id']);
session_destroy();
}

function klant($veld = "*"){
global $db;
$query = "SELECT ".$veld." FROM klanten WHERE klantnr = {$_SESSION['id']}";
$naamquery = $db->prepare($query);
$naamquery->execute();
$aRow = $naamquery->fetch(PDO::FETCH_ASSOC);
if($veld == "*")
return $aRow;
else
return $aRow[$veld];
}

function login(){
if(!isset($_SESSION['id'])) return"
<li><a href=\"?page=login\">Inloggen</a></li>
<li><a href=\"?page=registreer\">Registreren</a></li>";
else return"
<li class=\"extend\"><a href=\"?page=gegevens\">Gegevens</a>
<div>
<ul>
<li><a href=\"?page=gegevens&menu=bewerk\">Mijn gegevens</a></li>
<li><a href=\"?page=gegevens&menu=autos\">Mijn auto's</a></li>
</div>
</ul>
</li>
<li><a href=\"?page=logout\">Uitloggen</a></li>";
}

function checklogin(){
if(!isset($_SESSION['id'])){
header("location: ?page=login");
exit();
}
}

function admin(){
if(isset($_SESSION['id'])){
global $db;
$query = "SELECT admin FROM klanten WHERE klantnr = {$_SESSION['id']}";
$naamquery = $db->prepare($query);
$naamquery->execute();
$aRow = $naamquery->fetch(PDO::FETCH_ASSOC);
if($aRow['admin'] == 1)
return 1;
else
return 0;

}else{
return false;
}
}