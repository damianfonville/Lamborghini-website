<h1>auto's</h1>

<?php
function niets(){
global $db;
try{
$auto = $db->prepare("SELECT autonr AS id,naam FROM auto");
$auto->execute();

echo "<table>";
echo "<tr><td><a href=\"?page=autos&methode=add\"><button>toevoegen</button></a></td></tr>";
while($result = $auto->fetch(PDO::FETCH_ASSOC)){
echo "<tr>";
echo "<td>".$result['naam']."<td>";
echo "<td><a href=\"?page=autos&methode=wijzig&id=".$result['id']."\"><button>Wijzigen</button></a><td>";
echo "<td><a href=\"?page=autos&methode=delete&id=".$result['id']."\" onclick=\"return confirm('weet u het zeker?')\"><button>verwijderen</button></a><td>";
echo "</tr>";
}
echo "</table>";
}
catch(PDOException $e){
echo "line: ".$e->getLine()."<br/>";
echo "file: ".$e->getFile()."<br/>";
echo "message: ".$e->getMessage()."<br/>";
}
} //eind functie niets

function wijzig(){
global $db;
try{
if(isset($_POST['submit'])){
$query = "UPDATE auto
SET naam=:naam, prijs=:prijs, details=:details, verbruik=:verbruik, pk=:pk, uitstoot=:uitstoot, acceleratie=:acceleratie, snelheid=:snelheid
WHERE autonr=:autonr";
$edit = $db->prepare($query);
$edit->BindValue(":autonr", $_POST['autonr'],PDO::PARAM_STR);
$edit->BindValue(":naam", $_POST['naam'],PDO::PARAM_STR);
$edit->BindValue(":prijs", $_POST['prijs'],PDO::PARAM_STR);
$edit->BindValue(":details", $_POST['details'],PDO::PARAM_STR);
$edit->BindValue(":verbruik", $_POST['verbruik'],PDO::PARAM_STR);
$edit->BindValue(":pk", $_POST['pk'],PDO::PARAM_STR);
$edit->BindValue(":uitstoot", $_POST['uitstoot'],PDO::PARAM_STR);
$edit->BindValue(":acceleratie", $_POST['acceleratie'], PDO::PARAM_STR);
$edit->BindValue(":snelheid", $_POST['snelheid'], PDO::PARAM_STR);
$edit->execute();
}

$query = "SELECT * FROM auto WHERE autonr = ?";
$auto = $db->prepare($query);
$auto->bindParam(1, $_GET['id'], PDO::PARAM_INT);
$auto->execute();
$fetch = $auto->fetch(PDO::FETCH_ASSOC);
?>


<form action="?page=autos&methode=wijzig&id=<?=$_GET['id']; ?>" method="post">
	<table>
		<tr>
			<td>Autonummer</td>
			<td><?=$fetch['autonr'];?><input type="hidden" name="autonr" value="<?=$fetch['autonr']; ?>" /></td>
		</tr>
		<tr>
			<td>Autonnaam</td>
			<td><input type="text" name="naam" value="<?=$fetch['naam'];?>" /></td>
		</tr>
		<tr>
			<td>Prijs</td>
			<td><input type="text" name="prijs" value="<?=$fetch['prijs'];?>" /></td>
		</tr>
		<tr>
			<td>max. snelheid</td>
			<td><input type="text" name="snelheid" value="<?=$fetch['snelheid'];?>" />  KM/H</td>
		</tr>
		<tr>
			<td>Verbruik</td>
			<td><input type="text" name="verbruik" value="<?=$fetch['verbruik'];?>" />  L/100KM</td>
		</tr>
		<tr>
			<td>0 tot 100KM/H</td>
			<td><input type="text" name="acceleratie" value="<?=$fetch['acceleratie'];?>" />  S</td>
		</tr>
		<tr>
			<td>Uitstoot</td>
			<td><input type="text" name="uitstoot" value="<?=$fetch['uitstoot'];?>" />  G</td>
		</tr>
		<tr>
			<td>Kracht</td>
			<td><input type="text" name="pk" value="<?=$fetch['pk'];?>" />  PK</td>
		</tr>
		<tr>
			<td>details</td>
			<td colspan="3"><textarea name="details" rows="10" cols="50"><?=$fetch['details'];?></textarea>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="werkbij" name="submit" /></td>
		</tr>
	</table>
</form>


<?php
}
catch(PDOException $e){
echo "line: ".$e->getLine()."<br/>";
echo "file: ".$e->getFile()."<br/>";
echo "message: ".$e->getMessage()."<br/>";
}

}//eind functie wijzig

function add(){
global $db;
if(isset($_POST['submit'])){
try{
$query = "INSERT INTO auto
 (naam, prijs, details, verbruik, pk, uitstoot, acceleratie, snelheid)
 VALUES (:naam, :prijs, :details, :verbruik, :pk, :uitstoot, :acceleratie, :snelheid)";
$edit = $db->prepare($query);
$edit->BindValue(":naam", $_POST['naam'],PDO::PARAM_STR);
$edit->BindValue(":prijs", $_POST['prijs'],PDO::PARAM_STR);
$edit->BindValue(":details", $_POST['details'],PDO::PARAM_STR);
$edit->BindValue(":verbruik", $_POST['verbruik'],PDO::PARAM_STR);
$edit->BindValue(":pk", $_POST['pk'],PDO::PARAM_STR);
$edit->BindValue(":uitstoot", $_POST['uitstoot'],PDO::PARAM_STR);
$edit->BindValue(":acceleratie", $_POST['acceleratie'], PDO::PARAM_STR);
$edit->BindValue(":snelheid", $_POST['snelheid'], PDO::PARAM_STR);
$edit->execute();
echo $_POST['naam']." is toegevoegd";
}
catch(PDOException $e){
echo "line: ".$e->getLine()."<br/>";
echo "file: ".$e->getFile()."<br/>";
echo "message: ".$e->getMessage()."<br/>";
}

}

?>



<form action="?page=autos&methode=add" method="post">
	<table>
		<tr>
			<td>Autonnaam</td>
			<td><input type="text" name="naam" /></td>
		</tr>
		<tr>
			<td>Prijs</td>
			<td><input type="text" name="prijs" /></td>
		</tr>
		<tr>
			<td>max. snelheid</td>
			<td><input type="text" name="snelheid" />  KM/H</td>
		</tr>
		<tr>
			<td>Verbruik</td>
			<td><input type="text" name="verbruik" />  L/100KM</td>
		</tr>
		<tr>
			<td>0 tot 100KM/H</td>
			<td><input type="text" name="acceleratie" />  S</td>
		</tr>
		<tr>
			<td>Uitstoot</td>
			<td><input type="text" name="uitstoot"/>  G</td>
		</tr>
		<tr>
			<td>Kracht</td>
			<td><input type="text" name="pk" />  PK</td>
		</tr>
		<tr>
			<td>details</td>
			<td colspan="3"><textarea name="details" rows="10" cols="50"></textarea>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="voegtoe" name="submit" /></td>
		</tr>
	</table>
</form>
<?php


}


function delete(){

global $db;
$delete = $db->prepare("DELETE FROM auto WHERE autonr=:id");
$delete->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$delete->execute();

header("location: ?page=autos");

}


if(isset($_GET['methode'])){
switch($_GET['methode']){
case "wijzig":
wijzig();
break;
case "add":
add();
break;
case "delete":
delete();
break;

}//einde switch

}else
niets();

