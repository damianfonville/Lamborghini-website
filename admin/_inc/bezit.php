<h1>bezit</h1>
<?php
if(isset($_POST['submit'])){
$klantnr = $_POST['klantnr'];
$autonr = $_POST['auto'];
$dealernr = $_POST['dealer'];
if(empty($klantnr))
echo"klantummer is leeg";
else{
try{
$query = "INSERT INTO autoklant (klantnr,autonr,dealernr, tijd) VALUES (:klantnr,:autonr,:dealernr,:time)";
$bezit = $db->prepare($query);
$bezit->BindValue(":klantnr", $klantnr,PDO::PARAM_STR);
$bezit->BindValue(":dealernr", $dealernr,PDO::PARAM_STR);
$bezit->BindValue(":autonr", $autonr,PDO::PARAM_STR);
$bezit->BindValue(":time", time(),PDO::PARAM_STR);
$bezit->execute();
echo "auto is toegevoegt";
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
}

}

?>

<form action="" method="post">
	<table>
		<tr>
			<td>Klantnr.</td>
			<td><input type="text" name="klantnr" placeholder="klantnummer" /></td>
		</tr>
		<tr>
			<td>auto.</td>
			<td>
				<select name="auto">
				<?php
				$auto = $db->prepare("SELECT autonr, naam FROM auto");
				$auto->execute();
				while($result = $auto->fetch(PDO::FETCH_ASSOC)){
				echo '<option value="'.$result['autonr'].'">'.$result['naam'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>dealer.</td>
			<td>
				<select name="dealer">
				<?php
				$dealer = $db->prepare("SELECT dealernr, naam FROM dealers");
				$dealer->execute();
				while($result = $dealer->fetch(PDO::FETCH_ASSOC)){
				echo '<option value="'.$result['dealernr'].'">'.$result['naam'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="bevestig" /></td>
		</tr>
	</table>
</form>

<?php

try{
$query = "SELECT klanten.vnaam, klanten.anaam, auto.naam AS auto,dealers.naam AS dealer, autoklant.tijd
FROM auto, klanten, dealers, autoklant
WHERE auto.autonr=autoklant.autonr AND klanten.klantnr = autoklant.klantnr AND dealers.dealernr = autoklant.dealernr
ORDER BY id";
$auto = $db->prepare($query);
$auto->execute();
echo "<table width=\"100%\">";
echo "<thead><td>Naam</td><td>auto</td><td>dealer</td><td>datum</td>";
while($result = $auto->fetch(PDO::FETCH_ASSOC)){
echo"<tr>";
echo "<td>".$result['vnaam']." ".$result['anaam']."</td>";
echo "<td>".$result['auto']."</td>";
echo "<td>".$result['dealer']."</td>";
$tijd = ($result['tijd']) ? date("d/m/Y H:i",$result['tijd']) : "onbekend";
echo "<td>".$tijd."</td>";
echo"</tr>";
}
echo "</table>";
}
catch(PDOException $e)
{
	$sMsg = '<p>
		Regelnummer: '.$e->getLine().'<br/>
		Bestand: '.$e->getFile().'<br/>
		Foutmelding: '.$e->getMessage().'
		</p>';
		echo $sMsg;
}