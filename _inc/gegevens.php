<?php checklogin(); 


function niets(){
echo "Kies in het menu een optie<br/><br/><br/><br/><br/>";
}


function autos(){
global $db;
try{
?>
 <link rel="stylesheet" href="http://andreaslagerkvist.com/aFramework/Modules/Base/jquery.liveSearch.css">
<script src="http://andreaslagerkvist.com/aFramework/Modules/Base/jquery.liveSearch.js"></script>
<script src="http://andreaslagerkvist.com/aFramework/Modules/Base/jquery.liveSearch.js"></script>
<script>
$(function(){
$('.zoek').liveSearch({url: 'livesearch.php?q='});
});
</script>
<?php
$autos = $db->prepare("
SELECT *, auto.naam AS autonaam, dealers.naam AS dealernaam FROM autoklant, auto, dealers
WHERE auto.autonr = autoklant.autonr
AND dealers.dealernr = dealers.dealernr
AND klantnr = {$_SESSION['id']}");
$autos->execute();
if($autos->rowCount() == 0)
echo "Nog geen autos bekent</br>";
else{
echo'<input type="text" class="zoek" size="30">';

while($result = $autos->fetch(PDO::FETCH_ASSOC)){
$prijs = explode(".", $result['prijs']);
?>
<div id="<?=$result['id']; ?>" class="auto">
<h2><?php echo $result['autonaam']; ?></h2>	
<?php echo nl2br($result['details']); ?>
<br/>
<br/>
<br/>
<table>
	<tr>
		<td>Prijs</td>
		<td>&euro; <?php echo number_format($prijs[0], 0, ',', '.'); ?>,<sup><?php echo $prijs[1]; ?></sup></td>
	</tr>
	<tr>
		<td>Maximale snelheid</td>
		<td><?php echo $result['snelheid']; ?>Km/H</td>
	</tr>
	<tr>
		<td>0 tot 100km/h</td>
		<td><?php echo $result['acceleratie'];?>s</td>
	</tr>
</table>
<table>
	<tr>
		<td>Verbruik</td>
		<td><?php echo $result['verbruik']; ?>l/100km</td>
	</tr>
	<tr>
		<td>uitstoot</td>
		<td><?php echo $result['uitstoot']; ?>g</td>
	</tr>
	<tr>
		<td>kracht</td>
		<td><?php echo $result['pk']; ?>g</td>
	</tr>
</table>
<div class="clear"></div>
</div>
<div class="dealer">
<h3>Dealer</h3>
<?=$result['dealernaam']; ?><br/>
<?=$result['adres']; ?><br/>
<?=$result['postcode']; ?> <?=$result['stad']; ?><br/>
<?=$result['land']; ?><br/>
tel: <a href="tel:<?=$result['telnr']; ?>"><?=$result['telnr']; ?></a><br/>
E-mail: <a href="mailto:<?=$result['email']; ?>"><?=$result['email']; ?></a><br/>
</div>
<hr />
<?php
}
}
}
catch(PDOException $e){
echo "line: ".$e->getLine()."<br/>";
echo "file: ".$e->getFile()."<br/>";
echo "message: ".$e->getMessage()."<br/>";
}
}


function bewerk(){
global $db;

if(isset($_POST['submit'])){
if(empty($_POST['vnaam']))
echo "Voornaam is leeg.";
elseif(empty($_POST['anaam']))
echo "Achternaam is leeg.";
elseif(empty($_POST['adres']))
echo "Adres is leeg.";
elseif(empty($_POST['stad']))
echo "Woonplaats is leeg.";
elseif(empty($_POST['postcode']))
echo "Postcode is leeg.";
elseif(empty($_POST['telnr']))
echo "Telefoonnummer is leeg.";
elseif(empty($_POST['email']))
echo "E-mail is leeg.";
elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
echo "E-mail is Geen emailadress";
else{

if(isset($_POST['nieuwsbrief'])){
$nieuwsbrief = 1;
}else{
$nieuwsbrief = 0;
}
$query = "UPDATE klanten SET vnaam=:vnaam, anaam=:anaam, email=:email, adres=:adres, postcode=:postcode, telnr=:telnr, nieuwsbrief=:nieuwsbrief WHERE klantnr=:klantnr";
$edit = $db->prepare($query);
$edit->BindValue(":klantnr", $_POST['klantnr'],PDO::PARAM_STR);
$edit->BindValue(":vnaam", $_POST['vnaam'],PDO::PARAM_STR);
$edit->BindValue(":anaam", $_POST['anaam'],PDO::PARAM_STR);
$edit->BindValue(":email", $_POST['email'],PDO::PARAM_STR);
$edit->BindValue(":postcode", $_POST['postcode'],PDO::PARAM_STR);
$edit->BindValue(":adres", $_POST['adres'],PDO::PARAM_STR);
$edit->BindValue(":telnr", $_POST['telnr'],PDO::PARAM_STR);
$edit->BindValue(":nieuwsbrief", $nieuwsbrief,PDO::PARAM_INT);
$edit->execute();
}

}


$klant = klant();
?>
<form action="" method="post">
	<table>
		<tr>
			<td>Klantnummer  </td>
			<td><?=$klant['klantnr']; ?><input type="hidden" name="klantnr" value="<?=$klant['klantnr']; ?>" /></td>
		</tr>
		<tr>
			<td>Voornaam: </td>
			<td><input type="text" name="vnaam" value="<?=$klant['vnaam']; ?>"/></td>
		</tr>
		<tr>
			<td>Achternaam: </td>
			<td><input type="text" name="anaam" value="<?=$klant['anaam']; ?>"/></td>
		</tr>
		<tr>
			<td>Adres: </td>
			<td><input type="text" name="adres" value="<?=$klant['adres']; ?>"/></td>
		</tr>
		<tr>
			<td>Woonplaats: </td>
			<td><input type="text" name="stad" value="<?=$klant['stad']; ?>"/></td>
		</tr>
		<tr>
			<td>Postcode: </td>
			<td><input type="text" name="postcode" value="<?=$klant['postcode']; ?>"/></td>
		</tr>
		<tr>
			<td>Telefoonnummer: </td>
			<td><input type="text" name="telnr" value="<?=$klant['telnr']; ?>"/></td>
		</tr>
		<tr>
			<td>E-mail: </td>
			<td><input type="text" name="email" value="<?=$klant['email']; ?>"/></td>
		</tr>
		<tr>
			<td>Nieuwsbrief: </td>
			<td><input type="checkbox" name="nieuwsbrief" <?php if($klant['nieuwsbrief']) echo"checked"; ?>/></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Verzenden"/></td>
		</tr>
	</table>
</form>
<hr />

<?php
if(isset($_POST['wachtwoord'])){
if(empty($_POST['wachtwoordoud']))
echo "Oude wachtwoord is leeg";
elseif(!password_verify($_POST['wachtwoordoud'], $klant['wachtwoord']))
echo "Oude wachtwoord komt niet overeen";
elseif(empty($_POST['wachtwoordnieuw'] || $_POST['wachtwoordherhaal']))
echo "nieuwe wachtwoord is leeg";
elseif($_POST['wachtwoordnieuw'] != $_POST['wachtwoordherhaal'])
echo "nieuwe wachtwoorden komen niet overeen";
else{
$wachtwoord = password_hash($_POST['wachtwoordnieuw'], PASSWORD_DEFAULT);
$wachtwoordedit = $db->prepare("UPDATE klanten SET wachtwoord=:wachtwoord WHERE klantnr=:klantnr");
$wachtwoordedit->BindValue(":klantnr", $klant['klantnr'],PDO::PARAM_INT);
$wachtwoordedit->BindValue(":wachtwoord", $wachtwoord ,PDO::PARAM_STR);
echo "Wachtwoord gewijzigd";
}
}


?>
<form action="" method="post">
	<table>
		<thead><h3>Wachtwoord wijziggen</h3></thead>
		<tr>
			<td>Oude Wachtwoord:</td>
			<td><input type="password" name="wachtwoordoud" /></td>
		</tr>
		<tr>
			<td>Nieuwe wachtwoord:</td>
			<td><input type="password" name="wachtwoordnieuw" /></td>
		</tr>
		<tr>
			<td>Nieuwe wachtwoord Herhalen: </td>
			<td><input type="password" name="wachtwoordherhaal" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="wachtwoord" value="Verzenden"/></td>
		</tr>
	</table>
</form>
<?php
}

if(isset($_GET['menu'])){
$menu = $_GET['menu'];

switch($menu){

case "autos":
autos();
break;

case "bewerk":
bewerk();
break;

default:
niets();

}
}else
niets();

?>