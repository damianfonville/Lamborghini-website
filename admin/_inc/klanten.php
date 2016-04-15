<h1>Klanten</h1>
<?php

if(isset($_POST['wis'])){
$query = "DELETE FROM klanten WHERE klantnr = ?";
$edit = $db->prepare($query);
$edit->bindValue(1, $_POST['klantnr'], PDO::PARAM_INT);
$edit->execute();
echo "<p>".$_POST['vnaam']." ".$_POST['anaam']." is verwijdert</p>";
}

if(isset($_POST['wijzig'])){
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
elseif(empty($_POST['email']))
	echo "E-mail is leeg.";
elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	echo "E-mail is Geen emailadress";
else{

if(isset($_post['nieuwsbrief'])){
$nieuwsbrief = 1;
}else{
$nieuwsbrief = 0;
}
if(isset($_POST['admin']))
$admin = 1;
else
$admin = 0;


$query = "UPDATE klanten
SET vnaam=:vnaam, anaam=:anaam, email=:email, adres=:adres, stad=:stad, postcode=:postcode, admin=:admin
WHERE klantnr=:klantnr";
$edit = $db->prepare($query);
$edit->BindValue(":klantnr", $_POST['klantnr'],PDO::PARAM_STR);
$edit->BindValue(":vnaam", $_POST['vnaam'],PDO::PARAM_STR);
$edit->BindValue(":anaam", $_POST['anaam'],PDO::PARAM_STR);
$edit->BindValue(":email", $_POST['email'],PDO::PARAM_STR);
$edit->BindValue(":postcode", $_POST['postcode'],PDO::PARAM_STR);
$edit->BindValue(":adres", $_POST['adres'],PDO::PARAM_STR);
$edit->BindValue(":stad", $_POST['stad'],PDO::PARAM_STR);
$edit->BindValue(":admin", $admin,PDO::PARAM_STR);
$edit->execute();
echo"Wijzigingen zijn uitgevoert";
}
}

if(isset($_POST['nieuw'])){
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
elseif(empty($_POST['email']))
	echo "E-mail is leeg.";
elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	echo "E-mail is Geen emailadress";
else{



if(isset($_POST['admin'])){
$admin = 1;
}else{
$admin = 0;
}
$query = "INSERT INTO klanten (vnaam, anaam, email, adres, postcode, stad, admin) VALUES (:vnaam, :anaam, :email, :adres, :postcode, :stad, :admin)";
$edit = $db->prepare($query);
$edit->BindValue(":vnaam", $_POST['vnaam'],PDO::PARAM_STR);
$edit->BindValue(":anaam", $_POST['anaam'],PDO::PARAM_STR);
$edit->BindValue(":email", $_POST['email'],PDO::PARAM_STR);
$edit->BindValue(":postcode", $_POST['postcode'],PDO::PARAM_STR);
$edit->BindValue(":adres", $_POST['adres'],PDO::PARAM_STR);
$edit->BindValue(":stad", $_POST['stad'],PDO::PARAM_STR);
$edit->BindValue(":admin", $admin,PDO::PARAM_STR);
$edit->execute();
}


}
try
{
	$sQuery= "SELECT * FROM klanten ORDER BY klantnr";
	
	$oStmt = $db->prepare($sQuery); 
	$oStmt->execute();
	
	echo"<table class=\"muteer\">";
	echo"<thead><tr>
	<th>klantnr</th>
	<th>voornaam</th>
	<th>achternaam</th>
	<th>adres</th>
	<th>postcode</th>
	<th>woonplaats</th>
	<th>email</th>
	<th>admin</th>
	<th>wijzig</th>
	<th>del</th>
	</tr>
	</thead>
	<tbody>";
	while($rij = $oStmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
        <form method="post" action="">
        <tr>
        <td><?php echo($rij['klantnr']); ?><input type="hidden" name="klantnr" value="<?php echo($rij['klantnr']);?>"></td>
        <td><input type="text" name="vnaam" value="<?php echo($rij['vnaam']);?>"></td>
        <td><input type="text" name="anaam" value="<?php echo($rij['anaam']);?>"></td>
        <td><input type="text" name="adres" value="<?php echo($rij['adres']);?>"></td>
        <td><input type="text" name="postcode" value="<?php echo($rij['postcode']);?>"></td>
        <td><input type="text" name="stad" value="<?php echo($rij['stad']);?>"></td>
        <td><input type="text" name="email" value="<?php echo($rij['email']);?>"></td>
        <td><input type="checkbox" name="admin" <?php if($rij['admin'] == 1)echo"checked";?>></td>
        <td><input type="submit" name="wijzig" value="wijzig"></td>
        <td><input type="submit" name="wis" value="wis" onClick="return confirm('<?php echo($rij['vnaam']);?> wordt verwijderd. weet u het zeker ?')"></td>
        </tr>
        </form>
        <?php
	}
	?>
    <form method="post" action="">
    <tr>
        <td>Wordt ingevuld</td>
        <td><input type="text" name="vnaam"></td>
        <td><input type="text" name="anaam"></td>
        <td><input type="text" name="adres"></td>
        <td><input type="text" name="postcode"></td>
        <td><input type="text" name="stad"></td>
        <td><input type="text" name="email"></td>
		<td><input type="checkbox" name="admin" ></td>
    <td colspan="2"><input type="submit" name="nieuw" value="Nieuw"></td>
    </tr>
    </form>
	</tbody>
    </table></div>
    <BR>
    <br/>
    <?php
}
catch(PDOException $e)
{
	$sMsg = '<p>
		Regelnummer: '.$e->getLine().'<br/>
		Bestand: '.$e->getFile().'<br/>
		Foutmelding: '.$e->getMessage().'
		</p>';
		trigger_error($sMsg);
}