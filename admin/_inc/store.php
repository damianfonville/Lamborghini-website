<h1>Store</h1>


<?php
if(!isset($_GET['methode'])){
$store = $db->prepare("SELECT * FROM store");

$store->execute();
echo "<table>";
echo '<a href="?page=store&methode=add"><button>toevoegen</button></a>';
while($result = $store->fetch(PDO::FETCH_ASSOC)){
echo "<tr>";
echo "<td>".$result['naam']."<td>";
echo "<td><a href=\"?page=store&methode=wijzig&id=".$result['id']."\"><button>Wijzigen</button></a><td>";
echo "<td><a href=\"?page=store&methode=delete&id=".$result['id']."\" onclick=\"return confirm(\"weet u het zeker?\")\"><button>verwijderen</button></a><td>";
echo "</tr>";
}
echo "</table>";
}elseif(isset($_GET['methode']) and $_GET['methode'] == "wijzig" and isset($_GET['id'])){


if(isset($_POST['submit']) and isset($_FILES['foto'])){
$naam = $_POST['naam'];
$prijs = $_POST['prijs'];
$beschrijving = $_POST['beschrijving'];
$voorraad = $_POST['voorraad'];
$foto = $_FILES['foto'];
if(empty($naam)) echo "Naam is leeg";
elseif(empty($prijs)) echo "prijs is leeg";
elseif(empty($beschrijving)) echo "beschrijving is leeg";
elseif(empty($voorraad)) echo "voorraad is leeg";
else{
if($foto['error'] == 0){
$path = $foto["tmp_name"];
$imgData = base64_encode(file_get_contents($path));
$src = 'data: image/jpeg;base64,'.$imgData;

$update = $db->prepare("UPDATE store SET naam=:naam, prijs=:prijs, foto=:foto, voorraad=:voorraad, beschrijving=:beschrijving WHERE id=:id");
$update->bindParam(':foto', $src, PDO::PARAM_STR);

	

}else
$update = $db->prepare("UPDATE store SET naam=:naam, prijs=:prijs, voorraad=:voorraad, beschrijving=:beschrijving WHERE id=:id");

$naam = strtoupper($_POST['naam']);
$update->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$update->bindParam(':naam', $naam, PDO::PARAM_STR);
$update->bindParam(':prijs', $prijs, PDO::PARAM_STR);
$update->bindParam(':voorraad', $voorraad, PDO::PARAM_STR);
$update->bindParam(':beschrijving', $beschrijving, PDO::PARAM_STR);
$update->execute();

}

}
$store = $db->prepare("SELECT * FROM store WHERE id=:id");
$store->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$store->execute();
$result = $store->fetch(PDO::FETCH_ASSOC);
?>
<img src="<?=$result['foto'];?>" style="float:right;width:25%">
<form action="?page=store&methode=wijzig&id=<?=$_GET['id'];?>" method="post" enctype='multipart/form-data'>
	<table>
		<tr>
			<td>Naam:</td>
			<td><input type="text" size="30" name="naam" value="<?=$result['naam']; ?>"/></td>
		</tr>
		<tr>
			<td>Prijs:</td>
			<td><input type="text" size="30" name="prijs" value="<?=$result['prijs']; ?>"/></td>
		</tr>
		<tr>
			<td>Afbeelding:</td>
			<td>
				<input id="uploadBtn" name="foto" type="file" class="upload" accept="image/*"/>
			</td>
		</tr>
		<tr>
			<td>Voorraad:</td>
			<td>
				<input name="voorraad" type="text" value="<?=$result['voorraad'];?>"/>
			</td>
		</tr>
		<tr>
			<td>Beschrijving:</td>
		</tr>
		<tr>
			<td colspan="2"><textarea style="resize:none;" name="beschrijving" cols="50" rows="8" noresize><?=$result['beschrijving'];?></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="wijzig"/></td>
		</tr>
	</table>

</form>

<div class="clear"></div>
<?php
}elseif(isset($_GET['methode']) and $_GET['methode'] == "delete" and isset($_GET['id'])){

$delete = $db->prepare("DELETE FROM store WHERE id=:id");
$delete->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$delete->execute();

header("location: ?page=store");
}elseif(isset($_GET['methode']) and $_GET['methode'] == "add"){

if(isset($_POST['submit']) and isset($_FILES['foto'])){
$naam = $_POST['naam'];
$prijs = $_POST['prijs'];
$beschrijving = $_POST['beschrijving'];
$voorraad = $_POST['voorraad'];
$foto = $_FILES['foto'];
if(empty($naam)) echo "Naam is leeg";
elseif(empty($prijs)) echo "prijs is leeg";
elseif(empty($beschrijving)) echo "beschrijving is leeg";
elseif(empty($voorraad)) echo "voorraad is leeg";
else{
if($foto['error'] != 0)
echo "een fout met de foto";
else{
$path = $foto["tmp_name"];
$imgData = base64_encode(file_get_contents($path));
$src = 'data: image/jpeg;base64,'.$imgData;



$update = $db->prepare("INSERT INTO store (naam, prijs, foto, voorraad, beschrijving) VALUES (:naam, :prijs, :foto, :voorraad, :beschrijving)");
$update->bindParam(':foto', $src, PDO::PARAM_STR);
$naam = strtoupper($naam);
$update->bindParam(':naam', $naam, PDO::PARAM_STR);
$update->bindParam(':prijs', $prijs, PDO::PARAM_STR);
$update->bindParam(':voorraad', $voorraad, PDO::PARAM_STR);
$update->bindParam(':beschrijving', $beschrijving, PDO::PARAM_STR);
$update->execute();

}

}
}
?>
<form action="?page=store&methode=add" method="post" enctype='multipart/form-data'>
	<table>
		<tr>
			<td>Naam:</td>
			<td><input type="text" size="30" name="naam" /></td>
		</tr>
		<tr>
			<td>Prijs:</td>
			<td><input type="text" size="30" name="prijs" /></td>
		</tr>
		<tr>
			<td>Afbeelding:</td>
			<td>
				<input id="uploadBtn" name="foto" type="file" class="upload" accept="image/*"/>
			</td>
		</tr>
		<tr>
			<td>Voorraad:</td>
			<td>
				<input name="voorraad" type="text"/>
			</td>
		</tr>
		<tr>
			<td>Beschrijving:</td>
		</tr>
		<tr>
			<td colspan="2"><textarea style="resize:none;" name="beschrijving" cols="50" rows="8" noresize></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="wijzig"/></td>
		</tr>
	</table>

</form>

<div class="clear"></div>
<?php


}else
echo "Er is een fout opgetreden";