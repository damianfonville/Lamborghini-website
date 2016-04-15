<h1>Registreren</h1>
<?php

$form = '
<form action="" method="post">
<table>
<tr>
<td>Voornaam</td>
<td><input type="text" placeholder="Voornaam" name="vnaam" required /></td>
</tr>
<tr>
<td>Achternaam</td>
<td><input type="text" placeholder="Achternaam" name="anaam" required /></td>
</tr>
<tr>
<td>Adres</td>
<td><input type="text" placeholder="Adres" name="adres" required /></td>
</tr>
<tr>
<td>Postcode</td>
<td><input type="text" placeholder="Postcode" name="postcode" required /></td>
</tr>
<tr>
<td>Woonplaats</td>
<td><input type="text" placeholder="Woonplaats" name="stad" required /></td>
</tr>
<tr>
<td>Telefoonnummer: </td>
<td><input type="text" placeholder="Telefoonnummer" name="telnr" required/></td>
</tr>
<tr>
<td>E-mail</td>
<td><input type="text" placeholder="Email" name="email" required /></td>
</tr>
<tr>
<td>Nieuwsbrief</td>
<td><input type="checkbox" name="nieuwsbrief"/></td>
</tr>
<tr>
<td>Wachtwoord</td>
<td><input type="password" placeholder="Wachtwoord" name="wachtwoord" required /></td>
</tr>
<tr>
<td>Wachtwoord herhalen</td>
<td><input type="password" placeholder="Wachtwoord Herhalen" name="wachtwoordherhaal" required /></td>
</tr>
<tr>
<td><input type="submit" name="submit" value="Registreren" /></td>
<td><input type="reset" value="reset" /></td>
</tr>
</table>
</form>';

if(isset($_POST['submit'])){
if(empty($_POST['vnaam']))
echo "Voornaam is leeg.".$form;
elseif(empty($_POST['anaam']))
echo "Achternaam is leeg.".$form;
elseif(empty($_POST['adres']))
echo "Adres is leeg.".$form;
elseif(empty($_POST['stad']))
echo "Woonplaats is leeg.".$form;
elseif(empty($_POST['postcode']))
echo "Postcode is leeg.".$form;
elseif(empty($_POST['telnr']))
echo "Telefoonnummer is leeg.".$form;
elseif(empty($_POST['email']))
echo "E-mail is leeg.".$form;
elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
echo "E-mail is Geen emailadres".$form;
elseif(empty($_POST['wachtwoord'] || $_POST['wachtwoordherhaal']))
echo "Wachtwoord is leeg".$form;
elseif($_POST['wachtwoord'] !== $_POST['wachtwoordherhaal'])
echo "wachtwoorden zijn niet gelijk".$form;
else{

$wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);

if(isset($_POST['nieuwsbrief'])){
$nieuwsbrief = 1;
}else{
$nieuwsbrief = 0;
}

try{
$query = "INSERT INTO klanten (vnaam, anaam, email, adres, postcode, stad, wachtwoord, nieuwsbrief, telnr) VALUES (:vnaam, :anaam, :email, :adres, :postcode, :stad, :wachtwoord, :nieuwsbrief, :telnr)";
$edit = $db->prepare($query);
$edit->BindValue(":vnaam", $_POST['vnaam'],PDO::PARAM_STR);
$edit->BindValue(":anaam", $_POST['anaam'],PDO::PARAM_STR);
$edit->BindValue(":email", $_POST['email'],PDO::PARAM_STR);
$edit->BindValue(":postcode", $_POST['postcode'],PDO::PARAM_STR);
$edit->BindValue(":adres", $_POST['adres'],PDO::PARAM_STR);
$edit->BindValue(":stad", $_POST['stad'],PDO::PARAM_STR);
$edit->BindValue(":telnr", $_POST['telnr'],PDO::PARAM_STR);
$edit->BindValue(":wachtwoord", $wachtwoord,PDO::PARAM_STR);
$edit->BindValue(":nieuwsbrief", $nieuwsbrief,PDO::PARAM_STR);
$edit->execute();
}
catch(PDOException $e){
echo "line: ".$e->getLine()."<br/>";
echo "file: ".$e->getFile()."<br/>";
echo "message: ".$e->getMessage()."<br/>";
}

}

}else{
echo $form;

}