<?php
require_once("config/config.php");
if(isset($_GET['q'])){
$q = $_GET['q'];
$store = $db->prepare("SELECT * FROM store WHERE naam LIKE ?");
$store->bindValue(1, "%$q%", PDO::PARAM_STR);
$store->execute();
if($store->rowCount() == 0)
echo "Geen resultaat";
else{
while($artikel = $store->fetch(PDO::FETCH_ASSOC)){
?>
<div class="artikel"><img src="<?php echo $artikel['foto']; ?>" ><div class="title"><h4><?=$artikel['naam']; ?></h4><span>&euro;<?=$artikel['prijs']; ?></span></div><div class="clear"></div></div>

<?php } 

}

}else{

$store = $db->prepare("SELECT * FROM store");
$store->execute();
while($artikel = $store->fetch(PDO::FETCH_ASSOC)){
?>
<div class="artikel"><img src="<?php echo $artikel['foto']; ?>" ><div class="title"><h4><?=$artikel['naam']; ?></h4><span>&euro;<?=$artikel['prijs']; ?></span></div><div class="clear"></div></div>

<?php } 


}


